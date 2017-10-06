<?php

declare(strict_types = 1);

namespace tests\Deetrych\Mapping\Mapper\ReadModel;

use Deetrych\Mapping\Mapper\ReadModel\ArrayMapper;
use Deetrych\Mapping\PropertyAccessProvider;
use PHPUnit\Framework\TestCase;
use tests\Deetrych\Mapping\StubModel;

class ArrayMapperTest extends TestCase
{
    public function testMap()
    {
        $mapper = new ArrayMapper(
            new PropertyAccessProvider(),
            [
                'someProperty' => [
                    'path' => 'x.y'
                ],
                'otherProperty' => [
                    'path' => 'z'
                ],
                'yetAnother' => [
                    'path' => 'someFreakyKey'
                ]
            ],
            new StubModel('str')
        );

        $result = $mapper->map(['x' => ['y' => 'siema'], 'z' => 'xx', 'someFreakyKey' => 'someFreakyValue']);

        $this->assertInstanceOf(StubModel::class, $result);
        $this->assertSame('siema', $result->getSomeProperty());
        $this->assertSame('xx', $result->getOtherProperty());
        $this->assertSame('someFreakyValue', $result->getYetAnother());
    }
}
