<?php

declare(strict_types = 1);

namespace Deetrych\Mapping\Decorator;

use Deetrych\Mapping\Mapper\WriteModel\AbstractMapper;
use Deetrych\Mapping\Mapper\WriteModel\Factory;

class FactoryDecorator extends Factory
{
    public function createFromType(string $type): AbstractMapper
    {
        if ($type == 'elastic') {
            $arrayMapper = parent::createFromType('array');

            return new ElasticMapperDecorator($arrayMapper);
        }

        return parent::createFromType($type);
    }
}
