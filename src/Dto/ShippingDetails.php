<?php

namespace Evotodi\WaveBundle\Dto;

use Evotodi\WaveBundle\Interfaces\CreateArrayInterface;
use Evotodi\WaveBundle\Interfaces\PatchArrayInterface;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class ShippingDetails implements CreateArrayInterface, PatchArrayInterface
{
    public ?string $name;
    public ?Address $address;
    public ?string $phone;
    public ?string $instructions;

    public function __construct(
        ?string $name,
        ?Address $address,
        ?string $phone,
        ?string $instructions
    )
    {
        $this->name = $name;
        $this->address = $address;
        $this->phone = $phone;
        $this->instructions = $instructions;
    }

    #[Pure]
    #[ArrayShape(['name' => "string", 'address' => "array", 'phone' => "string", 'instructions' => "string"])]
    public function toCreateArray(): array
    {
        return [
            'name' => $this->name,
            'address' => $this->address->toCreateArray(),
            'phone' => $this->phone,
            'instructions' => $this->instructions
        ];
    }

    #[Pure]
    #[ArrayShape(['name' => "string", 'address' => "array", 'phone' => "string", 'instructions' => "string"])]
    public function toPatchArray(): array
    {
        return $this->toCreateArray();
    }
}
