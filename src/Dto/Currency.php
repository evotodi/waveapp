<?php

namespace Evotodi\WaveBundle\Dto;

class Currency
{
    public ?string $code;
    public ?string $symbol;
    public ?string $name;
    public ?string $plural;
    public ?int $exponent;

    public function __construct(?string $code, ?string $symbol, ?string $name, ?string $plural, ?int $exponent)
    {
        $this->code = $code;
        $this->symbol = $symbol;
        $this->name = $name;
        $this->plural = $plural;
        $this->exponent = $exponent;
    }
}
