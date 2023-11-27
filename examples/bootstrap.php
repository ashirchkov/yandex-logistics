<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use GuzzleHttp\Client;

$showErrorMessages = function (array $messages) {
    foreach ($messages as $message) {
        echo $message . "\n";
    }
};

$dotenv = Dotenv::createImmutable(__DIR__);
$env = $dotenv->load();

return [new Client(), $env['YANDEX_API_KEY'], $env['YANDEX_TEST_MODE']];