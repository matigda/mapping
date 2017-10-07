<?php

declare(strict_types = 1);

namespace tests\Deetrych\Mapping\Mapper\WriteModel;

use Deetrych\Mapping\Mapper\WriteModel\JsonMapper;

class JsonMapperTest extends AbstractMapperTest
{
    /**
     * {@inheritdoc}
     */
    protected function getClass(): string
    {
        return JsonMapper::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareResult(array $result)
    {
        return json_encode($result);
    }
}
