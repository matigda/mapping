<?php

declare(strict_types = 1);

namespace tests\Deetrych\Mapping\Decorator;

use Deetrych\Mapping\Decorator\ElasticMapperDecorator;
use Deetrych\Mapping\Decorator\FactoryDecorator;
use Deetrych\Mapping\Mapper\WriteModel\ArrayMapper;
use Deetrych\Mapping\PropertyAccessProvider;
use PHPUnit\Framework\TestCase;

class FactoryDecoratorTest extends TestCase
{
    public function testCreateFromType()
    {
        $factory = new FactoryDecorator(
            new PropertyAccessProvider(),
            [
                ['type' => 'array', 'fields' => []],
                ['type' => 'json', 'fields' => []],
            ],
            [
                'array' => ArrayMapper::class
            ]
        );

        $elasticMapper = $factory->createFromType('elastic');

        $this->assertInstanceOf(
            ElasticMapperDecorator::class,
            $elasticMapper
        );
    }
}
