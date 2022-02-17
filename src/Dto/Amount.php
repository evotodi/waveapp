<?php

namespace Evotodi\WaveBundle\Dto;

class Amount
{
    public ?int $raw;
    public ?string $value;
    public ?Currency $currency;

    public function __construct(
        ?int $raw,
        ?string $value,
        ?Currency $currency
    )
    {
        $this->raw = $raw;
        $this->value = $value;
        $this->currency = $currency;
    }
}
