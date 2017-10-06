<?php

declare(strict_types = 1);

namespace Deetrych\Mapping;

interface PropertyAccessProviderInterface
{
    /**
     * @param object $object
     * @param string $property
     * @param mixed $value
     *
     * @return $object
     */
    public function setValue($object, string $property, $value);

    /**
     * @param $object
     * @param string $path
     *
     * @return mixed
     */
    public function getValue($object, string $path);
}
