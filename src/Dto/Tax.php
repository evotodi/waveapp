<?php

namespace Evotodi\WaveBundle\Dto;

use DateTime;
use Evotodi\WaveBundle\Interfaces\ArchiveArrayInterface;
use Evotodi\WaveBundle\Interfaces\CreateArrayInterface;
use Evotodi\WaveBundle\Interfaces\PatchArrayInterface;
use JetBrains\PhpStorm\ArrayShape;

class Tax implements CreateArrayInterface, PatchArrayInterface, ArchiveArrayInterface
{
    public ?Business $business;
    public ?string $id;
    public ?string $name;
    public ?string $abbreviation;
    public ?string $description;
    public ?string $taxNumber;
    public ?bool $showTaxNumberOnInvoices;
    public ?float $rate;
    public ?array $rates;
    public ?bool $isCompound;
    public ?bool $isRecoverable;
    public ?bool $isArchived;
    public ?DateTime $createdAt;
    public ?DateTime $modifiedAt;

    /**
     * @param TaxRate[]|null $rates
     */
    public function __construct(
        ?Business $business,
        ?string $id,
        ?string $name,
        ?string $abbreviation,
        ?string $description,
        ?string $taxNumber,
        ?bool $showTaxNumberOnInvoices,
        ?float $rate,
        ?array $rates,
        ?bool $isCompound,
        ?bool $isRecoverable,
        ?bool $isArchived,
        ?DateTime $createdAt,
        ?DateTime $modifiedAt,
    )
    {
        $this->business = $business;
        $this->id = $id;
        $this->name = $name;
        $this->abbreviation = $abbreviation;
        $this->description = $description;
        $this->taxNumber = $taxNumber;
        $this->showTaxNumberOnInvoices = $showTaxNumberOnInvoices;
        $this->rate = $rate;
        $this->rates = $rates;
        $this->isCompound = $isCompound;
        $this->isRecoverable = $isRecoverable;
        $this->isArchived = $isArchived;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
    }

    #[ArrayShape(['businessId' => "string", 'name' => "string", 'abbreviation' => "string", 'rate' => "float", 'description' => "string", 'taxNumber' => "string", 'showTaxNumberOnInvoices' => "bool", 'isCompound' => "bool", 'isRecoverable' => "bool"])]
    public function toCreateArray(): array
    {
        return [
            'businessId' => null,
            'name' => $this->name,
            'abbreviation' => $this->abbreviation,
            'rate' => $this->rate,
            'description' => $this->description,
            'taxNumber' => $this->taxNumber,
            'showTaxNumberOnInvoices' => $this->showTaxNumberOnInvoices,
            'isCompound' => $this->isCompound,
            'isRecoverable' => $this->isRecoverable
        ];
    }

    #[ArrayShape(['id' => "string", 'name' => "string", 'abbreviation' => "string", 'description' => "string", 'taxNumber' => "string", 'showTaxNumberOnInvoices' => "bool"])]
    public function toPatchArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'abbreviation' => $this->abbreviation,
            'description' => $this->description,
            'taxNumber' => $this->taxNumber,
            'showTaxNumberOnInvoices' => $this->showTaxNumberOnInvoices,
        ];
    }

    #[ArrayShape(['id' => "string"])]
    public function toArchiveArray(): array
    {
        return ['id' => $this->id];
    }
}
