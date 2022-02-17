<?php

namespace Evotodi\WaveBundle\Dto;

use DateTime;
use Evotodi\WaveBundle\Interfaces\ArchiveArrayInterface;
use Evotodi\WaveBundle\Interfaces\CreateArrayInterface;
use Evotodi\WaveBundle\Interfaces\PatchArrayInterface;
use JetBrains\PhpStorm\ArrayShape;

class Product implements CreateArrayInterface, PatchArrayInterface, ArchiveArrayInterface
{
    public ?string $id;
    public ?string $name;
    public ?string $description;
    public ?string $unitPrice;
    public ?bool $isSold;
    public ?bool $isBought;
    public ?bool $isArchived;
    public ?DateTime $createdAt;
    public ?DateTime $modifiedAt;

    public function __construct(
        ?string $id,
        ?string $name,
        ?string $description,
        ?string $unitPrice,
        ?bool $isSold,
        ?bool $isBought,
        ?bool $isArchived,
        ?DateTime $createdAt,
        ?DateTime $modifiedAt,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->unitPrice = $unitPrice;
        $this->isSold = $isSold;
        $this->isBought = $isBought;
        $this->isArchived = $isArchived;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
    }

    #[ArrayShape(['businessId' => "string", 'name' => "string", 'unitPrice' => "float", 'description' => "string", 'defaultSalesTaxIds' => "array", 'incomeAccountId' => "string", 'expenseAccountId' => "string"])]
    public function toCreateArray(): array
    {
        return [
            'businessId' => null,
            'name' => $this->name,
            'unitPrice' => floatval($this->unitPrice),
            'description' => $this->description,

            'defaultSalesTaxIds' => [],
            'incomeAccountId' => null,
            'expenseAccountId' => null,
        ];
    }

    #[ArrayShape(['id' => "string", 'name' => "string", 'unitPrice' => "float", 'description' => "string", 'defaultSalesTaxIds' => "array", 'incomeAccountId' => "string", 'expenseAccountId' => "string"])]
    public function toPatchArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'unitPrice' => floatval($this->unitPrice),
            'description' => $this->description,

            'defaultSalesTaxIds' => [],
            'incomeAccountId' => null,
            'expenseAccountId' => null,
        ];
    }

    #[ArrayShape(['id' => "string"])]
    public function toArchiveArray(): array
    {
        return ['id' => $this->id];
    }
}
