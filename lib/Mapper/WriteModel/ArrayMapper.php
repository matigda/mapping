<?php

declare(strict_types = 1);

namespace Deetrych\Mapping\Mapper\WriteModel;


class ArrayMapper extends AbstractMapper
{
    /**
     * {@inheritdoc}
     */
    public function map($dataToMap)
    {
        $result = [];
        foreach ($this->fieldsToMap as $fieldName => $field) {
            $result[$fieldName] = $this->propertyAccessProvider->getValue($dataToMap, $field['path']);
        }
        
        return $result;
    }
}
