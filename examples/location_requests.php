<?php

/**
 * @var $showErrorMessages Closure
 */

declare(strict_types = 1);

use AlexeyShirchkov\Yandex\Logistics\Client;

$args = require_once __DIR__ . '/bootstrap.php';

$client = new Client(...$args);

// Point list request
$response = $client->anotherDay()->location()->getPointList([
    'type' => 'terminal',
]);

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    $showErrorMessages($response->getErrors());
}

// Get geo id by address request
$response = $client->anotherDay()->location()->getGeoIdByAddress('Москва');

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    $showErrorMessages($response->getErrors());
}