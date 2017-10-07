<?php

declare(strict_types = 1);

namespace tests\Deetrych\Mapping\Mapper\WriteModel;

use Deetrych\Mapping\Mapper\WriteModel\Factory;
use Deetrych\Mapping\Mapper\WriteModel\ArrayMapper;
use Deetrych\Mapping\Mapper\WriteModel\JsonMapper;
use Deetrych\Mapping\PropertyAccessProvider;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    /**
     * @var Factory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new Factory(
            new PropertyAccessProvider(),
            [
                ['type' => 'array', 'fields' => []],
                ['type' => 'json', 'fields' => []],
            ],
            [
                'array' => ArrayMapper::class,
                'json' => JsonMapper::class
            ]
        );
    }

    public function testFactoryIsCreatingMapperFromType()
    {
        $this->assertInstanceOf(ArrayMapper::class, $this->factory->createFromType('array'));
        $this->assertInstanceOf(JsonMapper::class, $this->factory->createFromType('json'));
    }

    public function testThrowsExceptionWhenNoMapperForGivenTypeWasPassed()
    {
        $this->expectException(InvalidArgumentException::class);

        $factory = new Factory(
            new PropertyAccessProvider(),
            [
                ['type' => 'array', 'fields' => []],
                ['type' => 'json', 'fields' => []],
            ],
            [
                'array' => ArrayMapper::class
            ]
        );

        $factory->createFromType('json');
    }

    public function testThrowsExceptionWhenRequestedTypeIsNotInConfig()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->assertInstanceOf(ArrayMapper::class, $this->factory->createFromType('xoxo'));
    }

    public function testThrowsExceptionWhenGivenTypeIsNotASubclassOfAbstractMapper()
    {
        $this->expectException(InvalidArgumentException::class);

        new Factory(
            new PropertyAccessProvider(),
            [
                ['type' => 'array', 'fields' => []]
            ],
            [
                'array' => 'ArjenRobben',
            ]
        );

    }
}
