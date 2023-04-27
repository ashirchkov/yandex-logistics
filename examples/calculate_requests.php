<?php

/**
 * @var $showErrorMessages Closure
 */

declare(strict_types = 1);

use AlexeyShirchkov\Yandex\Logistics\Client;

$args = require_once __DIR__ . '/bootstrap.php';

$client = new Client(...$args);

$response = $client->anotherDay()->calculate()->calculatePrice([
    'tariff' => 'self_pickup',
    'source' => [
        'platform_station_id' => '4eb18cc4-329d-424d-a8a8-abfd8926463d',
    ],
    'destination' => [
        'platform_station_id' => '0530d1b2-58be-4dba-8d69-3fb86fd61c9c',
    ],
    'total_assessed_price' => 100000,
    'total_weight' => 1000,
]);

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    $showErrorMessages($response->getErrors());
}


$response = $client->anotherDay()->calculate()->calculateIntervals(
    '4eb18cc4-329d-424d-a8a8-abfd8926463d',
    [
        'self_pickup_id' => '0530d1b2-58be-4dba-8d69-3fb86fd61c9c',
        'send_unix' => true,
    ]
);

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    $showErrorMessages($response->getErrors());
}