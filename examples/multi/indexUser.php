<?php
require 'vendor/autoload.php';
require 'B24api.php';
require 'B24apiUserRequest.php';

$profile = [];
try {
    $b24api = new B24apiUserRequest($_REQUEST['member_id']);

    $api = $b24api->getApi();
    $profile = $api->profile()->call();
} catch (Exception $e) {
    echo '<pre>';
    print_r($e);
    echo '</pre>';
}

?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <script src="//api.bitrix24.com/api/v1/"></script>
    <title>Приложение</title>
</head>
<body>
<div id="app">
    <pre>
        <?php print_r($profile); ?>
    </pre>
</div>

</body>
</html>
