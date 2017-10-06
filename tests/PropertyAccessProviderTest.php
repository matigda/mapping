<?php

declare(strict_types = 1);

namespace tests\Deetrych\Mapping;

use Deetrych\Mapping\PropertyAccessProvider;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PropertyAccessProviderTest extends TestCase
{
    /**
     * @var PropertyAccessProvider
     */
    private $propertyAccessProvider;

    public function setUp()
    {
        $this->propertyAccessProvider = new PropertyAccessProvider();
    }

    function testSetsValuesForPrivateProperties()
    {
        $object = new class
        {
            private $propertyToAccess;
        };

        $object = $this->propertyAccessProvider->setValue($object, 'propertyToAccess', 2);

        $this->assertSame(
            2,
            $this->propertyAccessProvider->getValue($object, 'propertyToAccess')
        );
    }

    function testGetsValuesFromPrivateProperties()
    {
        $object = new class
        {
            private $propertyToAccess = 2;
        };

        $this->assertSame(
            2,
            $this->propertyAccessProvider->getValue($object, 'propertyToAccess')
        );
    }

    function testGetsValuesFromNestedObjectPrivateProperties()
    {
        $object = new class
        {
            private $keeper;
            public function __construct()
            {
                $this->keeper = new class
                {
                    private $zipper = 4;
                };
            }
        };

        $this->assertSame(
            4,
            $this->propertyAccessProvider->getValue($object, 'keeper.zipper')
        );
    }

    function testThrowsExceptionWhenTooLongPathIsGiven()
    {
        $this->expectException(InvalidArgumentException::class);

        $object = new class
        {
            private $test = 2;
        };

        $this->propertyAccessProvider->getValue($object, 'test.test');
    }

    function testThrowsExceptionWhenProperyDoesntExistInGivenObject()
    {
        $this->expectException(InvalidArgumentException::class);

        $object = new class
        {
            private $test = 2;
        };

        $this->propertyAccessProvider->getValue($object, 'xiaomi');
    }

    function testThrowsExceptionWhenFirstParamIsNotAnObject()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->propertyAccessProvider->getValue(2, 'test.test');
    }
}
