<?php

declare(strict_types = 1);

namespace Deetrych\Mapping\Mapper\ReadModel;

use Deetrych\Mapping\PropertyAccessProviderInterface;

abstract class AbstractMapper
{
    /**
     * @var array
     */
    protected $fieldsToMap;

    /**
     * @var object
     */
    protected $modelInstance;

    /**
     * @var PropertyAccessProviderInterface
     */
    protected $propertyAccessProvider;

    /**
     * @param PropertyAccessProviderInterface $propertyAccessProvider
     * @param array $fieldsToMap
     * @param object $modelInstance
     */
    public function __construct(
        PropertyAccessProviderInterface $propertyAccessProvider,
        array $fieldsToMap,
        $modelInstance
    ) {
        foreach ($fieldsToMap as $fieldName => $fieldToMap) {
            if (!isset($fieldToMap['path'])) {
                throw new \InvalidArgumentException(sprintf('You have to provide path to field "%s"', $fieldName));
            }
        }
        if (!is_object($modelInstance)) {
            throw new \InvalidArgumentException(
                sprintf('Second argument passed to "%s" is supposed to be object, "%s" given.', gettype($modelInstance))
            );
        }

        $this->fieldsToMap = $fieldsToMap;
        $this->modelInstance = $modelInstance;
        $this->propertyAccessProvider = $propertyAccessProvider;
    }

    /**
     * @param mixed $dataToMap
     *
     * @return object
     */
    abstract public function map($dataToMap);
}
