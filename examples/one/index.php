<?php
require 'vendor/autoload.php';
require 'B24api.php';
$data = [];
try {
    $b24api = new B24Api($_REQUEST['member_id']);

    $api = $b24api->getApi();
    $data = $api->request('profile')->getResponseData()->getResult()->getResultData();
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
        <?= print_r($data) ?>
    </pre>
</div>

</body>
</html>
