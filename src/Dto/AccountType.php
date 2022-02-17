<?php

namespace Evotodi\WaveBundle\Dto;

class AccountType
{
    public ?string $name;
    public ?string $normalBalanceType;
    public ?string $value;

    public function __construct(?string $name, ?string $normalBalanceType, ?string $value)
    {
        $this->name = $name;
        $this->normalBalanceType = $normalBalanceType;
        $this->value = $value;
    }
}
