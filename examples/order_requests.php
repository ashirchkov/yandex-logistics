<?php

/**
 * @var $showErrorMessages Closure
 */

declare(strict_types = 1);

use AlexeyShirchkov\Yandex\Logistics\Client;

$args = require_once __DIR__ . '/bootstrap.php';

$client = new Client(...$args);

// Create order request
$response = $client->anotherDay()->order()->createOrder([
    'info' => [
        'operator_request_id' => '1234',
    ],
    'recipient_info' => [
        'first_name' => 'Иван',
        'phone' => '+79999999999',
    ],
    'billing_info' => [
        'payment_method' => 'already_paid',
    ],
    'source' => [
        'platform_station' => [
            'platform_id' => '4eb18cc4-329d-424d-a8a8-abfd8926463d',
        ],
    ],
    'destination' => [
        'type' => 'platform_station',
        'platform_station' => [
            'platform_id' => '0530d1b2-58be-4dba-8d69-3fb86fd61c9c',
        ],
    ],
    'places' => [
        [
            'barcode' => '1234567890',
            'physical_dims' => [
                'predefined_volume' => 100,
                'weight_gross' => 1000,
            ],
        ],
    ],
    'items' => [
        [
            'name' => 'Ручка шариковая (цвет синий)',
            'count' => 5,
            'article' => 'a123456',
            'billing_details' => [
                'assessed_unit_price' => 10000,
                'unit_price' => 10000,
            ],
            'place_barcode' => '1234567890',
        ],
        [
            'name' => 'Ручка шариковая (цвет красный)',
            'count' => 5,
            'article' => 'a654321',
            'billing_details' => [
                'assessed_unit_price' => 20000,
                'unit_price' => 20000,
            ],
            'place_barcode' => '1234567890',
        ],
    ],
    'last_mile_policy' => 'self_pickup',
]);

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    $showErrorMessages($response->getErrors());
}

// Get exist orders request
$response = $client->anotherDay()->order()->getOrders([
    'from' => (new DateTime('today'))->getTimestamp(),
    'to' => (new DateTime('tomorrow'))->getTimestamp(),
]);

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    $showErrorMessages($response->getErrors());
}

$offerId = ''; // Put here offer_id from createOffer response

if (!empty($offerId)) {

    // Confirm order request
    $response = $client->anotherDay()->order()->confirmOrder($offerId);

    if ($response->isSuccess()) {
        var_dump($response->getResult());
    } else {
        $showErrorMessages($response->getErrors());
    }

}

$requestId = ''; // Put here request_id from confirmOffer response

if (!empty($requestId)) {

    // Get exist order info request
    $response = $client->anotherDay()->order()->getOrder($requestId);

    if ($response->isSuccess()) {
        var_dump($response->getResult());
    } else {
        $showErrorMessages($response->getErrors());
    }

    // Edit order request
    $response = $client->anotherDay()->order()->editOrder($requestId, [
        'recipient_info' => [
            'first_name' => 'Петр',
            'phone' => '+78888888888',
        ],
    ]);

    if ($response->isSuccess()) {
        var_dump($response->getResult());
    } else {
        $showErrorMessages($response->getErrors());
    }

    // Redelivery order request
    $response = $client->anotherDay()->order()->redeliveryOrder($requestId, [
        'destination' => ['type' => 'platform_station'],
    ]);

    if ($response->isSuccess()) {
        var_dump($response->getResult());
    } else {
        $showErrorMessages($response->getErrors());
    }

    // Order status history request
    $response = $client->anotherDay()->order()->orderStatusHistory($requestId);

    if ($response->isSuccess()) {
        var_dump($response->getResult());
    } else {
        $showErrorMessages($response->getErrors());
    }

    // Cancel order request
    $response = $client->anotherDay()->order()->cancelOrder($requestId);

    if ($response->isSuccess()) {
        var_dump($response->getResult());
    } else {
        $showErrorMessages($response->getErrors());
    }

}