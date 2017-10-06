<?php

declare(strict_types = 1);

namespace Deetrych\Mapping\Mapper\ReadModel;


class JsonMapper extends ArrayMapper
{
    /**
     * {@inheritdoc}
     */
    public function map($dataToMap)
    {
        return parent::map(json_decode($dataToMap, true));
    }
}
