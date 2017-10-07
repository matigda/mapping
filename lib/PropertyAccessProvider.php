<?php

namespace Deetrych\Mapping;

use ReflectionObject;
use ReflectionProperty;

class PropertyAccessProvider implements PropertyAccessProviderInterface
{
    /**
     * @var ReflectionObject
     */
    protected $reflection;

    /**
     * {@inheritdoc}
     */
    public function setValue($object, string $property, $value)
    {
        return $this->execute($object, $property, function() use ($property, $object, $value) {
            $this->reflection = new ReflectionObject($object);
            $property = $this->getProperty($property);
            $property->setValue($object, $value);

            return $object;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getValue($object, string $path)
    {
        return $this->execute($object, $path, function() use ($path, $object) {
            foreach (explode('.', $path) as $property) {
                $value = $this->get($object, $property);
                $object = $value;
            }

            return $value;
        });
    }

    protected function execute($object, string $propertyPath, callable $callback)
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException(
                sprintf('Object expected as first parameter, %s given.', gettype($object))
            );
        }

        try {
            return $callback();
        } catch (\Exception $e) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Provided path is incorrect. Available properties: "%s", given path: "%s"',
                    implode('","', array_map(function (ReflectionProperty $property) {
                        return $property->getName();
                    }, $this->reflection->getProperties())),
                    $propertyPath
                )
            );
        }
    }

    protected function get($object, $name)
    {
        $this->reflection = new ReflectionObject($object);

        return $this->getProperty($name)->getValue($object);
    }

    protected function getProperty($name)
    {
        $property = $this->reflection->getProperty($name);
        $property->setAccessible(true);

        return $property;
    }
}
