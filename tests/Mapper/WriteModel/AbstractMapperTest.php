<?php

declare(strict_types = 1);

namespace tests\Deetrych\Mapping\Mapper\WriteModel;

use Deetrych\Mapping\PropertyAccessProvider;
use PHPUnit\Framework\TestCase;

abstract class AbstractMapperTest extends TestCase
{
    abstract protected function getClass(): string;

    /**
     * @param array $result
     *
     * @return mixed
     */
    abstract protected function prepareResult(array $result);

    public function testMapSimpleStructure()
    {
        $class = $this->getClass();

        $mapper = new $class(
            new PropertyAccessProvider(),
            [
                'someField' => [
                    'path' => 'x.y'
                ],
                'otherField' => [
                    'path' => 'x.z'
                ]
            ]
        );

        $this->assertSame(
            $this->prepareResult(['someField' => 2, 'otherField' => 3]),
            $mapper->map(new class{
                    private $x;

                    public function __construct()
                    {
                        $this->x = new class{
                            private $y = 2;
                            private $z = 3;
                        };
                    }
                }
            )
        );
    }

    public function testMapNestedStructure()
    {
        $class = $this->getClass();

        $mapper = new $class(
            new PropertyAccessProvider(),
            [
                'someField.nestedField' => [
                    'path' => 'x.y'
                ],
                'someField.anotherNestedField' => [
                    'path' => 'x.z'
                ],
                'smth' => [
                    'path' => 'someProperty'
                ]
            ]
        );

        $this->assertSame(
            $this->prepareResult(['someField' => ['nestedField' => 2, 'anotherNestedField' => 3], 'smth' => 5]),
            $mapper->map(new class{
                private $someProperty = 5;
                private $x;

                public function __construct()
                {
                    $this->x = new class{
                        private $y = 2;
                        private $z = 3;
                    };
                }
            })
        );
    }
}
