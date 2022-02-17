<?php

namespace Evotodi\WaveBundle\Dto;

use Evotodi\WaveBundle\Interfaces\CreateArrayInterface;
use JetBrains\PhpStorm\ArrayShape;

class TaxRate implements CreateArrayInterface
{
    public ?\DateTime $effective;
    public ?float $rate;

    public function __construct(?\DateTime $effective, ?float $rate)
    {
        $this->effective = $effective;
        $this->rate = $rate;
    }

    #[ArrayShape(['effective' => "string", 'rate' => "float"])]
    public function toCreateArray(): array
    {
        return [
            'effective' => $this->effective->format('Y-m-d'),
            'rate' => $this->rate
        ];
    }
}
