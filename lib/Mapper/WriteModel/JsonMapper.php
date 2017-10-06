<?php

declare(strict_types = 1);

namespace Deetrych\Mapping\Mapper\WriteModel;


class JsonMapper extends ArrayMapper
{
    /**
     * {@inheritdoc}
     */
    public function map($dataToMap)
    {
        return json_encode(parent::map($dataToMap));
    }
}
