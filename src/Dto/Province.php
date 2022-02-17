<?php

namespace Evotodi\WaveBundle\Dto;

class Province
{
    public ?string $code;
    public ?string $name;

    public function __construct(?string $code, ?string $name)
    {
        $this->code = $code;
        $this->name = $name;
    }
}
