<?php

declare(strict_types = 1);

namespace Deetrych\Mapping\Mapper\WriteModel;

use Symfony\Component\PropertyAccess\PropertyAccess;

class ArrayMapper extends AbstractMapper
{
    /**
     * {@inheritdoc}
     */
    public function map($dataToMap)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $result = [];

        foreach ($this->fieldsToMap as $fieldName => $field) {
            $accessor->setValue(
                $result,
                '['.implode('][', explode('.', $fieldName)).']',
                $this->propertyAccessProvider->getValue($dataToMap, $field['path'])
            );
        }
        
        return $result;
    }
}
