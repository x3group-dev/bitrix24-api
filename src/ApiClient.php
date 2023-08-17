<?php
declare(strict_types=1);

namespace Bitrix24Api;

use Bitrix24Api\Batch\Batch;
use Bitrix24Api\Batch\Command;
use Bitrix24Api\Config\Config;
use Bitrix24Api\EntitiesServices\AppOption;
use Bitrix24Api\EntitiesServices\Bizproc\Event;
use Bitrix24Api\EntitiesServices\Bizproc\Robot;
use Bitrix24Api\EntitiesServices\CRM\Activity;
use Bitrix24Api\EntitiesServices\CRM\ActivityCommunication;
use Bitrix24Api\EntitiesServices\CRM\ActivityType;
use Bitrix24Api\EntitiesServices\CRM\Catalog;
use Bitrix24Api\EntitiesServices\CRM\Category;
use Bitrix24Api\EntitiesServices\CRM\Company;
use Bitrix24Api\EntitiesServices\CRM\Contact;
use Bitrix24Api\EntitiesServices\CRM\Deal;
use Bitrix24Api\EntitiesServices\CRM\ItemProductRow;
use Bitrix24Api\EntitiesServices\CRM\Lead;
use Bitrix24Api\EntitiesServices\CRM\LeadProductRows;
use Bitrix24Api\EntitiesServices\CRM\LeadUserField;
use Bitrix24Api\EntitiesServices\CRM\Product;
use Bitrix24Api\EntitiesServices\CRM\ProductProperty;
use Bitrix24Api\EntitiesServices\CRM\ProductPropertyEnumeration;
use Bitrix24Api\EntitiesServices\CRM\ProductPropertySettings;
use Bitrix24Api\EntitiesServices\CRM\Smart\Item as crmSmartItem;
use Bitrix24Api\EntitiesServices\Disk\AttachedObject;
use Bitrix24Api\EntitiesServices\Disk\File;
use Bitrix24Api\EntitiesServices\Disk\Folder;
use Bitrix24Api\EntitiesServices\Disk\Storage;
use Bitrix24Api\EntitiesServices\Entity\Entity;
use Bitrix24Api\EntitiesServices\Entity\Item;
use Bitrix24Api\EntitiesServices\Entity\ItemProperty;
use Bitrix24Api\EntitiesServices\Entity\Section;
use Bitrix24Api\EntitiesServices\Imbot\Message;
use Bitrix24Api\EntitiesServices\Lists\Element as ListsElement;
use Bitrix24Api\EntitiesServices\Lists\Lists;
use Bitrix24Api\EntitiesServices\Lists\ListsField;
use Bitrix24Api\EntitiesServices\Placement;
use Bitrix24Api\EntitiesServices\Profile;
use Bitrix24Api\EntitiesServices\Sonet\Group;
use Bitrix24Api\EntitiesServices\Sonet\GroupUser;
use Bitrix24Api\EntitiesServices\Task\CommentItem;
use Bitrix24Api\EntitiesServices\Task\Stages;
use Bitrix24Api\EntitiesServices\Task\Task;
use Bitrix24Api\EntitiesServices\User;
use Bitrix24Api\EntitiesServices\UserOption;
use Bitrix24Api\EntitiesServices\Messageservice;
use Bitrix24Api\EntitiesServices\Messageservice\Sender;
use Bitrix24Api\Exceptions\ApiException;
use Bitrix24Api\Exceptions\ApplicationNotInstalled;
use Bitrix24Api\Exceptions\ExpiredRefreshToken;
use Bitrix24Api\Exceptions\InvalidArgumentException;
use Bitrix24Api\Exceptions\ServerInternalError;
use Exception;
use Generator;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClient
{
    protected const BITRIX24_OAUTH_SERVER_URL = 'https://oauth.bitrix.info';
    protected const CLIENT_VERSION = '1.0.0';
    protected const CLIENT_USER_AGENT = 'bitrix24-api';
    protected Config $config;
    protected HttpClientInterface $httpClient;
    protected string $typeTransport = 'json';
    private $accessTokenRefreshCallback;


    public function __construct(Config $config = null)
    {
        $this->config = $config;
        $this->httpClient = HttpClient::create(['http_version' => '2.0']);
    }

    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Устанавливаем callback, который будет вызван при обновлении Credential'а
     * @param callable $callback
     * @return $this
     */
    public function onAccessTokenRefresh(callable $callback): self
    {
        $this->accessTokenRefreshCallback = $callback;

        return $this;
    }

    public function getList(string $method, array $params = []): Generator
    {
        do {
            $result = $this->request(
                $method,
                $params
            );

            $start = $params['start'] ?? 0;
            if (!is_null($this->config->getLogger())) {
                $this->config->getLogger()->debug(
                    "По запросу (getList) {$method} (start: {$start}) получено сущностей: " . count($result->getResponseData()->getResult()->getResultData()) .
                    ", всего существует: " . $result->getResponseData()->getPagination()->getTotal(),
                );
            }
            yield $result;

            if (empty($result->getResponseData()->getPagination()->getNextItem())) {
                break;
            }

            $params['start'] = $result->getResponseData()->getPagination()->getNextItem();
        } while (true);
    }

    /**
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ApiException
     * @throws Exception
     */
    public function request(string $method, array $params = []): ?Response
    {
        if ($this->config->isWebHookMode()) {
            $url = sprintf('%s%s', $this->config->getWebHookUrl(), $method . '.' . $this->typeTransport);
        } else {
            $url = sprintf('%s%s', $this->config->getCredential()->getClientEndpoint(), $method . '.' . $this->typeTransport);
            if ($this->config->getCredential() === null) {

            }
            $params['auth'] = $this->config->getCredential()->getAccessToken();
        }

        $requestOptions = [
            'json' => $params,
            'headers' => $this->getRequestDefaultHeaders(),
        ];

        $response = null;

        if (!is_null($this->config->getLogger())) {
            $this->config->getLogger()->debug(
                sprintf('request.start %s', $method),
                [
                    'params' => $params,
                ]
            );
        }
        try {
            $request = $this->httpClient->request('POST', $url, $requestOptions);
            if (!is_null($this->config->getLogger())) {
                $this->config->getLogger()->debug(
                    sprintf('request.end %s', $method),
                    [
                        'httpStatus' => $request->getStatusCode(),
                        'body' => $request->toArray(false)
                    ]
                );
            }
            switch ($request->getStatusCode()) {
                case 200:
                    $response = new Response($request, new Command($method, $params));
                    break;
                case 404:
                    $body = $request->toArray(false);
                    if (isset($body['error'])) {
                        if ($body['error'] === 'ERROR_METHOD_NOT_FOUND') {
                            //todo: correct exception
                            throw new Exception('ERROR_METHOD_NOT_FOUND');
                        }
                    }
                    break;
                case 400:
                    $body = $request->toArray(false);
                    if (isset($body['error'])) {
                        if ($body['error'] === 'ERROR_REQUIRED_PARAMETERS_MISSING') {
                            //todo: correct exception
                            throw new ApiException((string)$body['error'], 400, $body['error_description']);
                        } else {
                            throw new ApiException((string)$body['error'], 400, $body['error_description']);
                        }
                    }
                    break;
                case 401:
                    $body = $request->toArray(false);

                    if ($body['error'] === 'expired_token') {
                        $this->getNewAccessToken();
                        $response = $this->request($method, $params);
                    }

                    if($body['error'] === 'ERROR_OAUTH' && $body['error_description'] === 'Application not installed') {
                        throw new ApplicationNotInstalled();
                    }

                    break;
                case 500:
                    throw new ServerInternalError('request: 500 internal error');
                default:
                    if (!is_null($this->config->getLogger())) {
                        $this->config->getLogger()->debug(
                            sprintf('request.end %s', $method),
                            [
                                'httpStatus' => $request->getStatusCode(),
                                'body' => $request->toArray(false)
                            ]
                        );
                    }
                    break;
            }

        } catch (TransportExceptionInterface $e) {
            if (!is_null($this->config->getLogger())) {
                $this->config->getLogger()->error($e->getMessage());
            }
        }

        return $response;
    }

    protected function getRequestDefaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Accept-Charset' => 'utf-8',
            'User-Agent' => sprintf('%s-v-%s-php-%s', self::CLIENT_USER_AGENT, self::CLIENT_VERSION, PHP_VERSION),
        ];
    }

    public function getNewAccessToken(): void
    {
        $url = sprintf(
            '%s/oauth/token/?%s',
            $this::BITRIX24_OAUTH_SERVER_URL,
            http_build_query(
                [
                    'grant_type' => 'refresh_token',
                    'client_id' => $this->config->getApplicationConfig()->getClientId(),
                    'client_secret' => $this->config->getApplicationConfig()->getClientSecret(),
                    'refresh_token' => $this->config->getCredential()->getRefreshToken(),
                ]
            )
        );

        $requestOptions = [
            'headers' => $this->getRequestDefaultHeaders(),
        ];
        try {
            $response = $this->httpClient->request('GET', $url, $requestOptions);

            switch ($response->getStatusCode()) {
                case 200:
                    $result = $response->toArray(false);
                    $this->config->getCredential()->setFromArray($result);
                    if (is_callable($this->accessTokenRefreshCallback)) {
                        $callback = $this->accessTokenRefreshCallback;
                        $callback($this->config->getCredential());
                    }
                    break;
                case 500:
                    throw new ServerInternalError('getNewToken: 500 internal error');
                case 401:
                    throw new ExpiredRefreshToken('refresh token expired');
                default:

                    break;
            }
        } catch (TransportExceptionInterface $e) {
            if (!is_null($this->config->getLogger())) {
                $this->getLogger()->error($e);
            }
        }
    }

    public function getLogger(): ?LoggerInterface
    {
        return $this->config->getLogger() ?? null;
    }

    public function getListFast(string $method, array $params = []): Generator
    {
        $params['order']['id'] = 'ASC';
        $params['filter']['>ID'] = 0;
        $params['start'] = -1;

        if (isset($params['FILTER']) && is_array($params['FILTER']) && count($params['FILTER']) > 0) {
            if (!isset($params['filter'])) {
                $params['filter'] = [];
            }
            $params['filter'] = array_merge($params['filter'], $params['FILTER']);
            unset($params['FILTER']);
        }

        $totalCounter = 0;

        do {
            // костыль чтобы наверняка
            $params['FILTER'] = $params['filter'];
            $result = $this->request(
                $method,
                $params
            );

            $start = $params['start'] ?? 0;
            $resultCounter = count($result->getResponseData()->getResult()->getResultData());
            $totalCounter += $resultCounter;
            if (!is_null($this->config->getLogger())) {
                $this->config->getLogger()->debug(
                    "По запросу (getListFast) {$method} (start: {$start}) получено сущностей: " . $resultCounter .
                    ", всего получено: " . $totalCounter,
                );
            }

            yield $result;

            if ($resultCounter < 50) {
                break;
            }

            $params['filter']['>ID'] = $result->getResponseData()->getResult()->getResultData()[$resultCounter - 1]['ID'];
        } while (true);
    }

    public function batch(?bool $halt = false): Batch
    {
        return new Batch($this, $halt);
    }

    public function profile(): Profile
    {
        return new Profile($this);
    }

    public function placement(): Placement
    {
        return new Placement($this);
    }

    /*
     * CRM
     */

    public function crmSmartItem(array $params = []): crmSmartItem
    {
        return new crmSmartItem($this, $params);
    }

    public function crmActivity(array $params = []): Activity
    {
        return new Activity($this, $params);
    }

    public function crmActivityCommunication(array $params = []): ActivityCommunication
    {
        return new ActivityCommunication($this, $params);
    }

    public function crmActivityType(array $params = []): ActivityType
    {
        return new ActivityType($this, $params);
    }

    public function crmCatalog(array $params = []): Catalog
    {
        return new Catalog($this, $params);
    }

    /**
     * @throws Exceptions\InvalidArgumentException
     */
    public function crmCategory(string $entityTypeId): Category
    {
        return new Category($this, $entityTypeId);
    }

    public function crmCompany(array $params = []): Company
    {
        return new Company($this, $params);
    }

    public function crmContact(array $params = []): Contact
    {
        return new Contact($this, $params);
    }

    public function crmItemProductRow(array $params = []): ItemProductRow
    {
        return new ItemProductRow($this, $params);
    }

    public function crmLead(array $params = []): Lead
    {
        return new Lead($this, $params);
    }

    public function crmDeal(array $params = []): Deal
    {
        return new Deal($this, $params);
    }

    public function crmLeadProductRows(array $params = []): LeadProductRows
    {
        return new LeadProductRows($this, $params);
    }

    public function crmLeadUserField(array $params = []): LeadUserField
    {
        return new LeadUserField($this, $params);
    }

    public function crmProduct(array $params = []): Product
    {
        return new Product($this, $params);
    }

    public function crmProductProperty(array $params = []): ProductProperty
    {
        return new ProductProperty($this, $params);
    }

    public function crmProductPropertyEnumeration(array $params = []): ProductPropertyEnumeration
    {
        return new ProductPropertyEnumeration($this, $params);
    }

    public function crmProductPropertySettings(array $params = []): ProductPropertySettings
    {
        return new ProductPropertySettings($this, $params);
    }

    /*
     * Disk
     */

    public function diskAttachedObject(array $params = []): AttachedObject
    {
        return new AttachedObject($this, $params);
    }

    public function diskFile(array $params = []): File
    {
        return new File($this, $params);
    }

    public function diskFolder(array $params = []): Folder
    {
        return new Folder($this, $params);
    }

    public function diskStorage(array $params = []): Storage
    {
        return new Storage($this, $params);
    }

    /*
     * Entity
     */

    /**
     * @throws Exceptions\InvalidArgumentException
     */
    public function entity(string $entityId): Entity
    {
        return new Entity($this, $entityId);
    }

    public function entityItem(array $params = []): Item
    {
        return new Item($this, $params);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function entityItemProperty(string $entityId): ItemProperty
    {
        return new ItemProperty($this, $entityId);
    }

    public function entitySection(array $params = []): Section
    {
        return new Section($this, $params);
    }

    /*
     * Lists
     */

    public function listsList(array $params = []): Lists
    {
        return new Lists($this, $params);
    }

    public function listsElement(array $params = []): ListsElement
    {
        return new ListsElement($this, $params);
    }

    public function listsListField(array $params = []): ListsField
    {
        return new ListsField($this, $params);
    }

    /*
     * Tasks
     */
    public function taskTask(array $params = []): Task
    {
        return new Task($this, $params);
    }

    public function taskItem(array $params = []): \Bitrix24Api\EntitiesServices\Task\Item
    {
        return new \Bitrix24Api\EntitiesServices\Task\Item($this, $params);
    }

    public function taskElapsedItem(): \Bitrix24Api\EntitiesServices\Task\ElapsedItem
    {
        return new \Bitrix24Api\EntitiesServices\Task\ElapsedItem($this);
    }

    public function taskCommentItem(array $params = []): CommentItem
    {
        return new CommentItem($this, $params);
    }

    public function taskStages(array $params = []): Stages
    {
        return new Stages($this, $params);
    }

    /*
     * Sonet
     */

    public function sonetGroup(array $params = []): Group
    {
        return new Group($this, $params);
    }

    public function sonetGroupUser(): GroupUser
    {
        return new GroupUser($this);
    }

    /*
     * User
     */

    public function user(array $params = []): User
    {
        return new User($this, $params);
    }

    public function bizprocRobot(array $params = []): Robot
    {
        return new Robot($this, $params);
    }

    public function option(): AppOption
    {
        return new AppOption($this);
    }

    public function userOption(): UserOption
    {
        return new UserOption($this);
    }

    public function imBotMessage(): Message
    {
        return new Message($this);
    }

    /*
     * MessageService
     */

    public function messageServiceSender(): Sender
    {
        return new Sender($this);
    }

    /**
     * Bizproc Event
     */

     public function bizprocEvent(array $params = []): Event
    {
        return new Event($this, $params);
    }
}
