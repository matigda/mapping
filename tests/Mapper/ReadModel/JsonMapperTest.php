<?php

declare(strict_types = 1);

namespace tests\Deetrych\Mapping\Mapper\ReadModel;

use Deetrych\Mapping\Mapper\ReadModel\JsonMapper;
use Deetrych\Mapping\PropertyAccessProvider;
use PHPUnit\Framework\TestCase;
use tests\Deetrych\Mapping\StubModel;

class JsonMapperTest extends TestCase
{
    public function testMap()
    {
        $mapper = new JsonMapper(
            new PropertyAccessProvider(),
            [
                'someProperty' => [
                    'path' => 'x.y'
                ],
                'otherProperty' => [
                    'path' => 'x.z'
                ],
                'yetAnother' => [
                    'path' => 'someFreakyKey'
                ]
            ],
            new StubModel('xoo')
        );

        $result = $mapper->map(json_encode(['x' => ['y' => 'siema', 'z' => 'xx'], 'someFreakyKey' => 'someFreakyValue']));

        $this->assertInstanceOf(StubModel::class, $result);
        $this->assertSame('siema', $result->getSomeProperty());
        $this->assertSame('xx', $result->getOtherProperty());
        $this->assertSame('someFreakyValue', $result->getYetAnother());
    }
}
