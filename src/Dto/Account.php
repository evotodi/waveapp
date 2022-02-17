<?php

namespace Evotodi\WaveBundle\Dto;

use Evotodi\WaveBundle\Interfaces\ArchiveArrayInterface;
use Evotodi\WaveBundle\Interfaces\CreateArrayInterface;
use Evotodi\WaveBundle\Interfaces\PatchArrayInterface;
use JetBrains\PhpStorm\ArrayShape;

class Account implements CreateArrayInterface, PatchArrayInterface, ArchiveArrayInterface
{
    public ?Business $business;
    public ?string $id;
    public ?string $name;
    public ?string $description;
    public ?string $displayId;
    public ?Currency $currency;
    public ?AccountType $type;
    public ?AccountSubType $subType;
    public ?string $normalBalanceType;
    public ?bool $isArchived;
    public ?string $sequence;
    public ?string $balance;
    public ?string $balanceInBusinessCurrency;

    public function __construct(
        ?Business $business,
        ?string $id,
        ?string $name,
        ?string $description,
        ?string $displayId,
        ?Currency $currency,
        ?AccountType $type,
        ?AccountSubType $subType,
        ?string $normalBalanceType,
        ?bool $isArchived,
        ?string $sequence,
        ?string $balance,
        ?string $balanceInBusinessCurrency
    )
    {
        $this->business = $business;
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->displayId = $displayId;
        $this->currency = $currency;
        $this->type = $type;
        $this->subType = $subType;
        $this->normalBalanceType = $normalBalanceType;
        $this->isArchived = $isArchived;
        $this->sequence = $sequence;
        $this->balance = $balance;
        $this->balanceInBusinessCurrency = $balanceInBusinessCurrency;
    }

    #[ArrayShape(['businessId' => "string", 'subtype' => "string", 'currency' => "string", 'name' => "string", 'description' => "string", 'displayId' => "string"])]
    public function toCreateArray(): array
    {
        return [
            'businessId' =>$this->business?->id,
            'subtype' => $this->subType?->value,
            'currency' => $this->currency?->code,
            'name' => $this->name,
            'description' => $this->description,
            'displayId' => $this->displayId,
        ];
    }

    #[ArrayShape(['id' => "string", 'sequence' => "string", 'name' => "string", 'description' => "string", 'displayId' => "string"])]
    public function toPatchArray(): array
    {
        return [
            'id' =>$this->id,
            'sequence' => $this->sequence,
            'name' => $this->name,
            'description' => $this->description,
            'displayId' => $this->displayId,
        ];
    }

    #[ArrayShape(['id' => "string"])]
    public function toArchiveArray(): array
    {
        return ['id' => $this->id];
    }
}
