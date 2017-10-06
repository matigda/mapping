<?php

declare(strict_types = 1);

namespace tests\Deetrych\Mapping\Mapper\ReadModel;

use Deetrych\Mapping\Mapper\ReadModel\Factory;
use Deetrych\Mapping\Mapper\ReadModel\ArrayMapper;
use Deetrych\Mapping\Mapper\ReadModel\JsonMapper;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use tests\Deetrych\Mapping\StubModel;

class FactoryTest extends TestCase
{
    /**
     * @var Factory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new Factory(
            [
                ['type' => 'array', 'fields' => [], 'model' => StubModel::class],
                ['type' => 'json', 'fields' => [], 'model' => StubModel::class ],
            ],
            [
                'array' => ArrayMapper::class,
                'json' => JsonMapper::class
            ]
        );
    }

    public function testFactoryIsCreatingMapperFromType()
    {
        $this->assertInstanceOf(ArrayMapper::class, $arrayFactory = $this->factory->createFromType('array'));
        $this->assertInstanceOf(StubModel::class, $arrayFactory->map([]));
        $this->assertInstanceOf(JsonMapper::class, $jsonFactory = $this->factory->createFromType('json'));
        $this->assertInstanceOf(StubModel::class, $jsonFactory->map('{}'));
    }

    public function testThrowsExceptionWhenNoMapperForGivenTypeWasPassed()
    {
        $this->expectException(InvalidArgumentException::class);

        $factory = new Factory(
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
            [
                ['type' => 'array', 'fields' => []]
            ],
            [
                'array' => 'ArjenRobben',
            ]
        );

    }
}
