<?php

use Bitrix24Api\ApiClient;
use Bitrix24Api\Config\Credential;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use YandexCloud\Ydb\Ydb;

class B24Api
{
    protected string $B24API_CLIENT_ID = '';
    protected string $B24API_CLIENT_SECRET = '';
    protected Logger $log;
    protected string $memberId;
    protected ApiClient $api;

    public static array $YdbConfig = [
        // Database path
        'database' => '/ru-central1/',

        // Database endpoint
        'endpoint' => 'ydb.serverless.yandexcloud.net:2135',

        // Auto discovery (dedicated server only)
        'discovery' => false,

        // IAM config
        'iam_config' => [
            'temp_dir' => './tmp', // Temp directory
//            'use_metadata' => true,
            'oauth_token' => ''
        ],
    ];

    protected static function ydbLogger(): Logger
    {
        $ydbLog = new Logger('ydb');
        $ydbLog->pushHandler(new StreamHandler(__DIR__ . '/logs/ydb/' . $_REQUEST['member_id'] . '.log', Logger::DEBUG));
        return $ydbLog;
    }

    public function getApi(): ApiClient
    {
        return $this->api;
    }

    /**
     * @throws \Exception
     */
    public function __construct($memberId)
    {
        if (!empty($memberId)) {
            $this->memberId = $memberId;

            $this->log = new Logger('b24');
            $this->log->pushHandler(new StreamHandler(__DIR__ . '/logs/b24api/' . $memberId . '/' . date('Y-m') . '/' . date('d') . '/' . date('H') . '.log', Logger::DEBUG));

            $application = new \Bitrix24Api\Config\Application($this->B24API_CLIENT_ID, $this->B24API_CLIENT_SECRET);
            $settings = static::getSettings($memberId);

            if (!empty($settings)) {
                $credential = Credential::initFromArray($settings);
                $config = new \Bitrix24Api\Config\Config(null, $application, $credential, $this->log);
                $api = new \Bitrix24Api\ApiClient($config);
                $api->onAccessTokenRefresh(function (Credential $credential) {
                    $this->saveMemberData($credential->toArray());
                });
                $this->api = $api;
            } else {
                throw new \Exception('settings is null');
            }
        } else {
            throw new \Exception('empty member_id');
        }
    }

    /**
     * Статичный метод, используется при установках приложения для сохранения авторизационных данных
     * @return array
     * @throws Exception
     */
    public static function install(): array
    {
        $result = [
            'rest_only' => true,
            'install' => false
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ydb = new Ydb(static::$YdbConfig, static::ydbLogger());
            $table = $ydb->table();
            $session = $table->session();

            try {
                $session->createTable('b24api',
                    \YandexCloud\Ydb\YdbTable::make()
                        ->addColumn('member_id', 'UTF8')
                        ->addColumn('access_token', 'UTF8')//AUTH_ID
                        ->addColumn('refresh_token', 'UTF8')//REFRESH_ID
                        ->addColumn('client_endpoint', 'UTF8')
                        ->addColumn('domain', 'UTF8')
                        ->addColumn('expires', 'Int64')
                        ->addColumn('expires_in', 'Int64')//AUTH_EXPIRES
                        ->addColumn('user_id', 'Int64')
                        ->addColumn('status', 'UTF8')
                        ->addColumn('application_token', 'UTF8')//APP_SID
                        ->primaryKey('member_id'));

                if (isset($_REQUEST['event']) && $_REQUEST['event'] === 'ONAPPINSTALL' && isset($_REQUEST['auth']) && $_REQUEST['auth']) {
                    $result['install'] = static::saveMemberData($_REQUEST['auth']);
                } elseif (isset($_REQUEST['PLACEMENT']) && $_REQUEST['PLACEMENT'] === 'DEFAULT') {
                    $result['rest_only'] = false;

                    $result['install'] = static::saveMemberData([
                        'access_token' => htmlspecialchars($_REQUEST['AUTH_ID']),
                        'refresh_token' => htmlspecialchars($_REQUEST['REFRESH_ID']),
                        'client_endpoint' => 'https://' . htmlspecialchars($_REQUEST['DOMAIN']) . '/rest/',

                        'member_id' => $_REQUEST['member_id'],
                        'domain' => htmlspecialchars($_REQUEST['DOMAIN']),

                        'expires' => time() + (int)$_REQUEST['AUTH_EXPIRES'] - 600,
                        'expires_in' => htmlspecialchars($_REQUEST['AUTH_EXPIRES']),

                        'status' => htmlspecialchars($_REQUEST['status']),
                        'application_token' => htmlspecialchars($_REQUEST['APP_SID']),
                    ]);
                }

            } catch (Exception $e) {
                echo '<pre>';
                print_r($e);
                echo '</pre>';
            }
        }
        return $result;
    }

    /**
     * Адаптационный метод для сохранения обратной совместимости
     * @param string $apiMethod
     * @param array $parameters
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     */
    public function call(string $apiMethod, array $parameters = []): array
    {
        $responseData = $this->getApi()->request($apiMethod, $parameters)->getResponseData();
        return [
            'result' => $responseData->getResult()->getResultData(),
        ];
    }

    /**
     * Сохранение/обновление авторизационных данных
     * @param $settings
     * @return bool
     */
    protected static function saveMemberData($settings): bool
    {
        if (is_array($settings)) {
            $oldData = self::getSettings($settings['member_id']);

            if (!empty($oldData)) {
                $settings = array_merge($oldData, $settings);
            }

            $updateFields = array_intersect_key($settings, [
                'access_token' => '',
                'refresh_token' => '',
                'client_endpoint' => '',

                'domain' => '',
                'member_id' => '',

                'expires' => '',
                'expires_in' => '',

                'user_id' => '',
                'status' => '',
//                'scope' => '',
                'application_token' => ''
            ]);

            try {
                $ydb = new Ydb(static::$YdbConfig, static::ydbLogger());
                $table = $ydb->table();
                $session = $table->session();

                array_walk($updateFields, function (&$item, $key) {
                    if ($key === 'expires' || $key === 'expires_in' || $key === 'user_id')
                        $item = (int)$item;
                    else
                        $item = '"' . htmlspecialchars($item) . '"';
                });

                try {
                    $session->transaction(function ($session) use ($updateFields) {
                        return $session->query('UPSERT INTO b24api (' . implode(',', array_keys($updateFields)) . ') VALUES (' . implode(',', $updateFields) . ');');
                    });
                    return true;
                } catch (Exception $e) {
                    return false;
                }
            } catch (\YandexCloud\Ydb\Exception $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * Получение данных приложения из базы
     * @return array
     */
    protected static function getSettings(string $memberId): array
    {
        $return = [];
        try {
            $ydb = new Ydb(static::$YdbConfig, static::ydbLogger());
            $table = $ydb->table();
            /** @var \YandexCloud\Ydb\QueryResult $result */
            $result = $table->query('select * from `b24api` where member_id="' . $memberId . '" limit 1;');

            if ($result->rowCount() > 0) {
                return current($result->rows());
            }
        } catch (\YandexCloud\Ydb\Exception $e) {
            return [];
        }
        return $return;
    }
}