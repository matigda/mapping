<?php

declare(strict_types = 1);

namespace Deetrych\Mapping\Mapper\ReadModel;


class ArrayMapper extends AbstractMapper
{
    /**
     * {@inheritdoc}
     */
    public function map($dataToMap)
    {
        foreach ($this->fieldsToMap as $fieldName => $field) {
            $result = $dataToMap;
            $fullPath = explode('.', $field['path']);

            foreach ($fullPath as $property) {
                $result = $result[$property];
            }
            $this->propertyAccessProvider->setValue($this->modelInstance, $fieldName, $result);
        }

        return $this->modelInstance;
    }
}
