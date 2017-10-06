<?php

declare(strict_types = 1);

namespace tests\Deetrych\Mapping;

class StubModel
{
    private $someProperty;
    private $otherProperty;
    private $yetAnother;

    public function __construct(string $someParameter)
    {

    }

    public function getSomeProperty()
    {
        return $this->someProperty;
    }

    public function getOtherProperty()
    {
        return $this->otherProperty;
    }

    public function getYetAnother()
    {
        return $this->yetAnother;
    }
}
