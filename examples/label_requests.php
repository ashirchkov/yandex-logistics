<?php

/**
 * @var $showErrorMessages Closure
 */

declare(strict_types = 1);

use AlexeyShirchkov\Yandex\Logistics\Client;

$args = require_once __DIR__ . '/bootstrap.php';

$client = new Client(...$args);

$requestIds = ['aeb00713-1605-48a5-b4b1-de02e5f00556']; // // Put here request_ids

if (!empty($requestIds)) {

    $response = $client->anotherDay()->label()->generateLabels($requestIds);

    if ($response->isSuccess()) {
        file_put_contents(__DIR__ . '/test.pdf', $response->getResult());
    } else {
        $showErrorMessages($response->getErrors());
    }

    $response = $client->anotherDay()->label()->getHandoverAct([
        'request_ids' => $requestIds,
    ]);

    if ($response->isSuccess()) {
        var_dump($response->getResult());
    } else {
        $showErrorMessages($response->getErrors());
    }


}
