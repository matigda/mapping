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
        try {
            foreach ($this->fieldsToMap as $fieldName => $field) {
                $result = $dataToMap;
                $fullPath = explode('.', $field['path']);

                foreach ($fullPath as $property) {
                    if (!isset($result[$property]) && $field['isRequired']) {
                        throw new \InvalidArgumentException(sprintf('Field "%s" is required, but its missing in passed data.', $property));
                    }
                    $result = $result[$property];
                }
                $this->propertyAccessProvider->setValue($this->modelInstance, $fieldName, $result);
            }
        } catch (\Exception $e) {
            if (get_class($e) === \InvalidArgumentException::class) {
                throw $e;
            }
        }

        return $this->modelInstance;
    }
}
