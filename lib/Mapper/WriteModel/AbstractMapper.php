<?php

declare(strict_types = 1);

namespace Deetrych\Mapping\Mapper\WriteModel;

use Deetrych\Mapping\PropertyAccessProviderInterface;

abstract class AbstractMapper
{
    /**
     * @var array
     */
    protected $fieldsToMap;

    /**
     * @var PropertyAccessProviderInterface
     */
    protected $propertyAccessProvider;

    public function __construct(PropertyAccessProviderInterface $propertyAccessProvider, array $fieldsToMap)
    {
        foreach ($fieldsToMap as $fieldName => $fieldToMap) {
            if (!isset($fieldToMap['path'])) {
                throw new \InvalidArgumentException(sprintf('You have to provide path to field "%s"', $fieldName));
            }
        }
        $this->fieldsToMap = $fieldsToMap;
        $this->propertyAccessProvider = $propertyAccessProvider;
    }

    /**
     * @param object $dataToMap
     *
     * @return mixed
     */
    abstract public function map($dataToMap);
}
