<?php

declare(strict_types = 1);

namespace tests\Deetrych\Mapping\Mapper\WriteModel;

use Deetrych\Mapping\Mapper\WriteModel\ArrayMapper;

class ArrayMapperTest extends AbstractMapperTest
{
    /**
     * {@inheritdoc}
     */
    protected function getClass(): string
    {
        return ArrayMapper::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareResult(array $result)
    {
        return $result;
    }
}
