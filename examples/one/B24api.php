<?php

use Bitrix24Api\ApiClient;
use Bitrix24Api\Config\Credential;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class B24Api
{
    protected string $B24API_CLIENT_ID = '';
    protected string $B24API_CLIENT_SECRET = '';
    protected Logger $log;
    protected ApiClient $api;

    public function getApi(): ApiClient
    {
        return $this->api;
    }

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->log = new Logger('b24');
        $this->log->pushHandler(new StreamHandler(__DIR__ . '/logs/b24api/' . date('Y-m') . '/' . date('d') . '/' . date('H') . '.log', Logger::DEBUG));

        $application = new \Bitrix24Api\Config\Application($this->B24API_CLIENT_ID, $this->B24API_CLIENT_SECRET);
        $settings = static::getSettings();

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
            try {

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
            $oldData = self::getSettings();

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
                'scope' => '',
                'application_token' => ''
            ]);

            return (boolean)file_put_contents(__DIR__ . '/settings.json', json_encode($updateFields, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT));
        }
        return false;
    }

    /**
     * Получение данных приложения
     * @return array
     */
    protected static function getSettings(): array
    {
        $return = [];
        if (file_exists(__DIR__ . '/settings.json')) {
            $return = json_decode(file_get_contents(__DIR__ . '/settings.json'), true);
        }
        return $return;
    }
}