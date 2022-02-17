<?php

namespace Evotodi\WaveBundle\Dto;

use Evotodi\WaveBundle\Interfaces\CreateArrayInterface;
use JetBrains\PhpStorm\ArrayShape;

class Taxes implements CreateArrayInterface
{
    public ?Amount $amount;
    public ?float $rate;
    public ?Tax $salesTax;

    public function __construct(
        ?Amount $amount,
        ?float $rate,
        ?Tax $salesTax
    )
    {
        $this->amount = $amount;
        $this->rate = $rate;
        $this->salesTax = $salesTax;
    }

    #[ArrayShape(['salesTaxId' => "string"])]
    public function toCreateArray(): array
    {
        return [
            'salesTaxId' => $this->salesTax?->id,
        ];
    }
}
