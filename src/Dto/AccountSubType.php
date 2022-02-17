<?php

namespace Evotodi\WaveBundle\Dto;

class AccountSubType
{
    public ?string $name;
    public ?string $value;
    public ?AccountType $type;

    public function __construct(?string $name, ?string $value, ?AccountType $type)
    {
        $this->name = $name;
        $this->value = $value;
        $this->type = $type;
    }
}
