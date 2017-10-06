<?php

declare(strict_types = 1);

namespace tests\Deetrych\Mapping\Mapper\WriteModel;

use Deetrych\Mapping\Mapper\WriteModel\JsonMapper;
use Deetrych\Mapping\PropertyAccessProvider;
use PHPUnit\Framework\TestCase;

class JsonMapperTest extends TestCase
{
    public function testMap()
    {
        $mapper = new JsonMapper(
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

        $this->assertSame(json_encode(['someField' => 2, 'otherField' => 3]), $mapper->map(new class{
            private $x;

            public function __construct()
            {
                $this->x = new class{
                    private $y = 2;
                    private $z = 3;
                };
            }
        }));
    }
}
