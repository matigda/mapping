<?php

declare(strict_types = 1);

namespace tests\Deetrych\Mapping\Mapper\ReadModel;

use Deetrych\Mapping\PropertyAccessProvider;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use tests\Deetrych\Mapping\StubModel;

abstract class AbstractMapperTest extends TestCase
{
    abstract protected function getClass(): string;

    /**
     * @param array $data
     *
     * @return mixed
     */
    abstract protected function prepareData(array $data);

    public function testMapSimpleStructure()
    {
        $class = $this->getClass();

        $mapper = new $class(
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

        $result = $mapper->map($this->prepareData(['x' => ['y' => 'siema', 'z' => 'xx'], 'someFreakyKey' => 'someFreakyValue']));

        $this->assertInstanceOf(StubModel::class, $result);
        $this->assertSame('siema', $result->getSomeProperty());
        $this->assertSame('xx', $result->getOtherProperty());
        $this->assertSame('someFreakyValue', $result->getYetAnother());
    }

//  @TODO - make code so those tests will pass
//    public function testMapNestedStructure()
//    {
//        $class = $this->getClass();
//
//        $mapper = new $class(
//            new PropertyAccessProvider(),
//            [
//                'someProperty' => [
//                    'type' => StubModel::class
//                ],
//                'someProperty.otherProperty' => [
//                    'path' => 'x.z',
//                ]
//            ],
//            new StubModel('xoo')
//        );

//        $result = $mapper->map($this->prepareData(['x' => ['y' => 'siema', 'z' => 'xx'], 'someFreakyKey' => 'someFreakyValue']));

//        $this->assertInstanceOf(StubModel::class, $result);
//        $this->assertInstanceOf(StubModel::class, $result->getSomeProperty());
//        $this->assertSame('xx', $result->getSomeProperty()->getOtherProperty());
//    }
//
//    public function testMapNestedStructureThrowsExceptionWhenNestedTypeIsNotDefined()
//    {
//        $this->expectException(InvalidArgumentException::class);
//
//        $class = $this->getClass();
//
//        $mapper = new $class(
//            new PropertyAccessProvider(),
//            [
//                'someProperty.nestedProperty' => [
//                    'path' => 'x.y'
//                ]
//            ],
//            new StubModel('xoo')
//        );
//
//        $mapper->map([]);
//    }
}
