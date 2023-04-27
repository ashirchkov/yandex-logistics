# Yandex Logistics SDK

Полная реализация SDK для интеграции с API Yandex Logistics

[Описание](https://yandex.ru/dev/logistics/)

## Документация API

[API Яндекс Доставки в другой день](https://yandex.ru/dev/logistics/delivery-api/doc/about/intro.html)

[API Яндекс «Экспресс-доставки»/«Доставки в течение дня»](https://yandex.ru/dev/logistics/api/about/intro.html)

## Возможности:

> *Не отмеченные возможности еще не реализованы*

**API Яндекс Доставки в другой день**

- [x] Подготовка заявки
    - [x] Предварительная оценка стоимости доставки
    - [x] Получение интервалов доставки
- [x] Точки самопривоза и ПВЗ
    - [x] Получение идентификатора населённого пункта
    - [x] Получение списка точек самопривоза и ПВЗ
- [x] Основные запросы
    - [x] Создание заявки
    - [x] Подтверждение заявки
    - [x] Получение информации о заявке
    - [x] Получение информации о заявках во временном интервале
    - [x] Редактирование заказа
    - [x] Получение интервалов доставки для нового места получения заказа
    - [x] История статусов заявки
    - [x] Отмена заявки
- [x] Ярлыки и акты приема-передачи
    - [x] Получение ярлыков
    - [x] Получение актов приёма-передачи для отгрузки

**API Яндекс Доставки в другой день**

- [ ] Методы «Доставки в течение дня»
    - [ ] Интервалы «Доставки в течение дня»
- [ ] Предварительная оценка
    - [ ] Первичная оценка стоимости без создания заявки
    - [ ] Получение тарифов, доступных в точке
- [ ] Базовые методы
    - [ ] Создание заявки
    - [ ] Подтверждение заявки
    - [ ] Поиск заявок
    - [ ] Получение информации по заявке
- [ ] Отмена заявки и пропуск точек
    - [ ] Получение признака отмены
    - [ ] Отмена заявки
    - [ ] Пропуск точки в заказе с мультиточками
- [ ] Информация о курьере
    - [ ] Получение номера телефона курьера
    - [ ] Получение местоположения курьера
    - [ ] Получение ссылок для отслеживания курьера
- [ ] Коды подтверждения и акты приёма-передачи
    - [ ] Получение кода подтверждения
    - [ ] Получение акта приёма-передачи
- [ ] Информация по заявкам
    - [ ] Получение информации по нескольким заявкам
    - [ ] Журнал изменений заказов
    - [ ] Получение прогноза по времени прибытия на точки
- [ ] Редактирование заявки
    - [ ] Редактирование заявки до её подтверждения
    - [ ] Частичное редактирование заявки после ее подтверждения
    - [ ] Получить результат применения изменений
- [ ] Ровер
    - [ ] Запрос на проверку возможности доставки ровером
    - [ ] Запрос на открытие крышки ровера
- [ ] Подтверждение доставки
    - [ ] Получение фотографий по точке
    - [ ] Получение информации по заявке

## Установка

``` shell 
$ composer require ashirchkov/yandex-logistics
```

## Документация SDK

### Инициализация API клиента

В примере использован GuzzleHttp клиент, вы можете использовать любой PSR-18 клиент.

``` php
<?php 

require_once 'vendor/autoload.php';

$psr18Client = new GuzzleHttp\Client();
$apiKey = '<your API-key>';
$testMode = true; // Если установлен true, запросы будут отправляться к тестовому API сервису Yandex

$apiClient = new AlexeyShirchkov\Yandex\Logistics\Client($psr18Client, $apiKey, $testMode); 
```

Далее в примерах подразумевается, что вы уже инициализировали **$apiClient**

### API Яндекс Доставки в другой день:

** **

### Предварительная оценка стоимости доставки

[Список параметров](https://yandex.ru/dev/logistics/delivery-api/doc/ref/part1/api_b2b_platform_pricing-calculator_post.html)

``` php
$params = [
    'tariff' => 'self_pickup',
    'source' => [
        'platform_station_id' => '4eb18cc4-329d-424d-a8a8-abfd8926463d',
    ],
    'destination' => [
        'platform_station_id' => '0530d1b2-58be-4dba-8d69-3fb86fd61c9c',
    ],
    'total_assessed_price' => 100000,
    'total_weight' => 1000,
]

$response = $apiClient->anotherDay()->calculate()->calculatePrice($params);

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    var_dump($response->getErrors());
}
```

### Получение интервалов доставки

[Список параметров](https://yandex.ru/dev/logistics/delivery-api/doc/ref/part1/api_b2b_platform_offers_info_get.html)

``` php
$stationId = '4eb18cc4-329d-424d-a8a8-abfd8926463d';

$params = [
    'self_pickup_id' => '0530d1b2-58be-4dba-8d69-3fb86fd61c9c',
    'send_unix' => true,
];

$response = $apiClient->anotherDay()->calculate()->calculateIntervals($stationId, $params);

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    var_dump($response->getErrors());
}
```

### Получение идентификатора населённого пункта

[Список параметров](https://yandex.ru/dev/logistics/delivery-api/doc/ref/part2/api_b2b_platform_location_detect_post.html)

``` php
$response = $apiClient->anotherDay()->location()->getGeoIdByAddress('Москва');

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    var_dump($response->getErrors());
}
```

### Получение списка точек самопривоза и ПВЗ

[Список параметров](https://yandex.ru/dev/logistics/delivery-api/doc/ref/part2/api_b2b_platform_pickup-points_list_post.html)

``` php
$params = [
    'type' => 'terminal',
];

$response = $apiClient->anotherDay()->location()->getPointList($params);

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    var_dump($response->getErrors());
}
```

### Создание заявки

[Список параметров](https://yandex.ru/dev/logistics/delivery-api/doc/ref/part3/api_b2b_platform_offers_create_post.html)

``` php
$params = [
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
];

$response = $apiClient->anotherDay()->order()->createOrder($params);

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    var_dump($response->getErrors());
}
```

### Подтверждение заявки

[Список параметров](https://yandex.ru/dev/logistics/delivery-api/doc/ref/part3/api_b2b_platform_offers_confirm_post.html)

``` php
$offerId = '<your offer_id>'; // offer_id, полученный после выполнения createOrder

$response = $apiClient->anotherDay()->order()->confirmOrder($offerId);

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    var_dump($response->getErrors());
}
```

### Получение информации о заявке

[Список параметров](https://yandex.ru/dev/logistics/delivery-api/doc/ref/part3/api_b2b_platform_request_info_get.html)

``` php
$requestId = '<your request_id>'; // request_id, полученный после выполнения confirmOrder

$response = $apiClient->anotherDay()->order()->getOrder($requestId);

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    var_dump($response->getErrors());
}
```

### Получение информации о заявках во временном интервале

[Список параметров](https://yandex.ru/dev/logistics/delivery-api/doc/ref/part3/api_b2b_platform_request_info_get.html)

``` php
$params = [
    'from' => (new DateTime('today'))->getTimestamp(),
    'to' => (new DateTime('tomorrow'))->getTimestamp(),
];

$response = $apiClient->anotherDay()->order()->getOrders($params);

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    var_dump($response->getErrors());
}
```

### Редактирование заказа

[Список параметров](https://yandex.ru/dev/logistics/delivery-api/doc/ref/part3/api_b2b_platform_request_edit_post.html)

``` php
$requestId = '<your request_id>'; // request_id, полученный после выполнения confirmOrder

$params = [
    'recipient_info' => [
        'name' => 'Пётр'
    ]
];

$response = $apiClient->anotherDay()->order()->editOrder($requestId, $params);

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    var_dump($response->getErrors());
}
```

### Получение интервалов доставки для нового места получения заказа

[Список параметров](https://yandex.ru/dev/logistics/delivery-api/doc/ref/part3/api_b2b_platform_request_redelivery_options_post.html)

``` php
$requestId = '<your request_id>'; // request_id, полученный после выполнения confirmOrder

$params = [
    'destination' => [
        'type' => 'platform_station'
    ],
];

$response = $apiClient->anotherDay()->order()->redeliveryOrder($requestId, $params);

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    var_dump($response->getErrors());
}
```

### История статусов заявки

[Список параметров](https://yandex.ru/dev/logistics/delivery-api/doc/ref/part3/api_b2b_platform_request_history_get.html)

``` php
$requestId = '<your request_id>'; // request_id, полученный после выполнения confirmOrder

$response = $apiClient->anotherDay()->order()->orderStatusHistory($requestId);

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    var_dump($response->getErrors());
}
```

### Отмена заявки

[Список параметров](https://yandex.ru/dev/logistics/delivery-api/doc/ref/part3/api_b2b_platform_request_cancel_post.html)

``` php
$requestId = '<your request_id>'; // request_id, полученный после выполнения confirmOrder

$response = $apiClient->anotherDay()->order()->cancelOrder($requestId);

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    var_dump($response->getErrors());
}
```

### Получение ярлыков

[Список параметров](https://yandex.ru/dev/logistics/delivery-api/doc/ref/part4/api_b2b_platform_request_generate-labels_post.html)

``` php
$requestIds = [
    '<your request_id>' // список request_id, полученных после выполнения confirmOrder
];

$response = $apiClient->anotherDay()->label()->generateLabels($requestIds);

if ($response->isSuccess()) {
    file_put_contents(__DIR__ . '/labels.pdf', $response->getResult());
} else {
    var_dump($response->getErrors());
}
```

### Получение актов приёма-передачи для отгрузки

[Список параметров](https://yandex.ru/dev/logistics/delivery-api/doc/ref/part4/api_b2b_platform_request_get-handover-act_post.html)

``` php
$params = [
    'request_ids' => [
        '<your request_id>' // список request_id, полученных после выполнения confirmOrder
    ]
]

$response = $client->anotherDay()->label()->getHandoverAct($params);

if ($response->isSuccess()) {
    var_dump($response->getResult());
} else {
    var_dump($response->getErrors());
}
```

### API Яндекс «Экспресс-доставки»/«Доставки в течение дня»:

** **

Coming soon...