<?php

declare(strict_types = 1);

namespace tests\Deetrych\Mapping\Mapper\ReadModel;

use Deetrych\Mapping\Mapper\ReadModel\ArrayMapper;

class ArrayMapperTest extends AbstractMapperTest
{
    protected function getClass(): string
    {
        return ArrayMapper::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareData(array $data)
    {
        return $data;
    }
}
