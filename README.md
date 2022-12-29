Обертка для работы с REST API Битрикс24

Установка

``
composer require x3group-dev/bitrix24-api
``

Пример вызова

```injectablephp
use Bitrix24Api\ApiClient;
use Bitrix24Api\Config\Application;
use Bitrix24Api\Config\Config;
use Bitrix24Api\Config\Credential;
use Bitrix24Api\Models\ProfileModel;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

try {
$application = new Application('local.61efad2c1b9651.84092660', 'yUMINzBh99gHYu5aZcE5ui2e6M0ylR23Ouwg1RzKasv7DYhov1');
$credential = Credential::initFromArray([
    'access_token' => 'c6d91962005924exxxxxxxxxxxx6ed53e582b4963a890e9fe9',
    'expires' => 1643362553,
    'domain' => 'domain.bitrix24.ru',
    'server_endpoint' => 'https://oauth.bitrix.info/rest/',
    'client_endpoint' => 'https://domain.bitrix24.ru/rest/',
    'member_id' => 'd8ec73fxxxxxxxxxxxc9f52588fca4d',
    'user_id' => 3,
    'refresh_token' => 'b6584162005924exxxxxxxxxxx003b8cc7f3196b8e823af463169b888e2a1',
    'status' => ''
]);

    $logger = new Logger('name');
    $logger->pushHandler(new StreamHandler('debug.log', Logger::DEBUG));

    $config = new Config(null, $application, $credential, $logger);
    $api = new ApiClient($config);
    $api->onAccessTokenRefresh(function (Credential $credential) {
        echo '<pre>';
        print_r($credential->toArray());
        echo '</pre>';
    });
    /** @var ProfileModel $profile */
    $profile = $api->profile()->call();
    if($profile) {
        echo '<pre>';
        print_r($profile->getName());
        echo '</pre>';
    }
} catch (\Bitrix24Api\Exceptions\ExpiredRefreshToken $exception){
    echo 'ExpiredRefreshToken';
} catch (\Exception $exception) {
    echo '<pre>';
    print_r($exception->getMessage());
    echo '</pre>';
}
```

Пример вызова через вебхук

```injectablephp
use Bitrix24Api\ApiClient;
use Bitrix24Api\Config\Application;
use Bitrix24Api\Config\Config;
use Bitrix24Api\Config\Credential;
use Bitrix24Api\Models\ProfileModel;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

try {
    $logger = new Logger('name');
    $logger->pushHandler(new StreamHandler('debug.log', Logger::DEBUG));

    $config = new Config('https://xxxxxxxx.bitrix24.ru/', null, null, $logger);
    $api = new ApiClient($config);
    /** @var ProfileModel $profile */
    $profile = $api->profile()->call();
    if($profile) {
        echo '<pre>';
        print_r($profile->getName());
        echo '</pre>';
    }
} catch (\Exception $exception) {
    echo '<pre>';
    print_r($exception->getMessage());
    echo '</pre>';
}
```

Пример выполнения batch

```injectablephp
$batch = $api->batch();
$batch->addCommand('profile',[]);
foreach ($batch->call() as $batchResult)
{

}
```
