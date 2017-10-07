<?php

declare(strict_types = 1);

namespace tests\Deetrych\Mapping\Decorator;

use Deetrych\Mapping\Decorator\ElasticMapperDecorator;
use Deetrych\Mapping\Mapper\WriteModel\ArrayMapper;
use Deetrych\Mapping\PropertyAccessProvider;
use Elastica\Document;
use PHPUnit\Framework\TestCase;

class ElasticMapperDecoratorTest extends TestCase
{
    public function testMap()
    {
        $mapper = new ElasticMapperDecorator($this->getArrayMapper());

        $result = $mapper->map(new class{
                private $x;

                public function __construct()
                {
                    $this->x = new class{
                        private $y = 2;
                        private $z = 3;
                    };
                }
            }
        );

        $this->assertInstanceOf(
            Document::class,
            $result
        );
        $this->assertSame(['someField' => 2, 'otherField' => 3], $result->getData());
    }

    private function getArrayMapper()
    {
        return $arrayMapper = new ArrayMapper(
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
    }
}
