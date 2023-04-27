<?php

namespace AlexeyShirchkov\Yandex\Logistics\Exception;

use http\Exception\BadMethodCallException;

class NotImplementedException extends BadMethodCallException
{

    public function __construct(string $className, $method) {
        
        parent::__construct(
            sprintf(
                'Class "%s" does not implement method %s',
                $className,
                $method
            )
        );

    }

}