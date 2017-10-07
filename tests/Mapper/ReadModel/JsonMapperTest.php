<?php

declare(strict_types = 1);

namespace tests\Deetrych\Mapping\Mapper\ReadModel;

use Deetrych\Mapping\Mapper\ReadModel\JsonMapper;

class JsonMapperTest extends AbstractMapperTest
{
    protected function getClass(): string
    {
        return JsonMapper::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareData(array $data)
    {
        return json_encode($data);
    }
}
