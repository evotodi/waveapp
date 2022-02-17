<?php

namespace Evotodi\WaveBundle\Dto;

use Evotodi\WaveBundle\Interfaces\CreateArrayInterface;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class InvoiceItem implements CreateArrayInterface
{
    public ?Account $account;
    public ?string $description;
    public ?float $quantity;
    public ?float $unitPrice;
    public ?Amount $subTotal;
    public ?Amount $total;
    public ?array $taxes;
    public ?Product $product;

    /**
     * @param Taxes[] $taxes
     */
    public function __construct(
        ?Account $account,
        ?string $description,
        ?float $quantity,
        ?float $unitPrice,
        ?Amount $subTotal,
        ?Amount $total,
        ?array $taxes, // Array of Taxes
        ?Product $product
    )
    {
        $this->account = $account;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
        $this->subTotal = $subTotal;
        $this->total = $total;
        $this->taxes = $taxes;
        $this->product = $product;
    }

    #[Pure]
    #[ArrayShape(['productId' => "string", 'description' => "string", 'quantity' => "float", 'unitPrice' => "float", 'taxes' => "array"])]
    public function toCreateArray(): array
    {
        $taxes = [];
        foreach ($this->taxes as $tax){
            $taxes[] = $tax->toCreateArray();
        }

        return [
            'productId' => $this->product?->id,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'unitPrice' => $this->unitPrice,
            'taxes' => $taxes
        ];
    }
}
