<?php

namespace Evotodi\WaveBundle\Dto;

use DateTime;
use Evotodi\WaveBundle\Interfaces\CloneArrayInterface;
use Evotodi\WaveBundle\Interfaces\CreateArrayInterface;
use Evotodi\WaveBundle\Interfaces\DeleteArrayInterface;
use Evotodi\WaveBundle\Interfaces\InvoiceApproveInterface;
use Evotodi\WaveBundle\Interfaces\InvoiceMarkSentInterface;
use Evotodi\WaveBundle\Interfaces\InvoiceSendInterface;
use JetBrains\PhpStorm\ArrayShape;

class Invoice implements CreateArrayInterface, DeleteArrayInterface, CloneArrayInterface, InvoiceSendInterface, InvoiceApproveInterface, InvoiceMarkSentInterface
{
    public ?Business $business;
    public ?Customer $customer;
    public ?string $id;
    public ?string $source;
    public ?string $pdfUrl;
    public ?string $viewUrl;
    public ?string $status;
    public ?string $title;
    public ?string $subhead;
    public ?string $invoiceNumber;
    public ?string $poNumber;
    public ?DateTime $invoiceDate;
    public ?DateTime $dueDate;
    public ?Amount $amountDue;
    public ?Amount $amountPaid;
    public ?Amount $taxTotal;
    public ?Amount $total;
    public ?Currency $currency;
    public ?float $exchangeRate;
    /** @var InvoiceItem[]  */
    public ?array $items;
    public ?string $memo;
    public ?string $footer;
    public ?bool $disableCreditCardPayments;
    public ?bool $disableBankPayments;
    public ?bool $disableAmexPayments;
    public ?string $itemTitle;
    public ?string $unitTitle;
    public ?string $priceTitle;
    public ?string $amountTitle;
    public ?bool $hideName;
    public ?bool $hideDescription;
    public ?bool $hideUnit;
    public ?bool $hidePrice;
    public ?bool $hideAmount;
    public ?DateTime $lastSentAt;
    public ?string $lastSentVia;
    public ?DateTime $lastViewedAt;

    public function __construct(
        ?Business $business,
        ?Customer $customer,
        ?string $id,
        ?string $source,
        ?string $pdfUrl,
        ?string $viewUrl,
        ?string $status,
        ?string $title,
        ?string $subhead,
        ?string $invoiceNumber,
        ?string $poNumber,
        ?DateTime $invoiceDate,
        ?DateTime $dueDate,
        ?Amount $amountDue,
        ?Amount $amountPaid,
        ?Amount $taxTotal,
        ?Amount $total,
        ?Currency $currency,
        ?float $exchangeRate,
        ?array $items, // Array of InvoiceItem
        ?string $memo,
        ?string $footer,
        ?bool $disableCreditCardPayments,
        ?bool $disableBankPayments,
        ?bool $disableAmexPayments,
        ?string $itemTitle,
        ?string $unitTitle,
        ?string $priceTitle,
        ?string $amountTitle,
        ?bool $hideName,
        ?bool $hideDescription,
        ?bool $hideUnit,
        ?bool $hidePrice,
        ?bool $hideAmount,
        ?DateTime $lastSentAt,
        ?string $lastSentVia,
        ?DateTime $lastViewedAt

    )
    {
        $this->business = $business;
        $this->customer = $customer;
        $this->id = $id;
        $this->source = $source;
        $this->pdfUrl = $pdfUrl;
        $this->viewUrl = $viewUrl;
        $this->status = $status;
        $this->title = $title;
        $this->subhead = $subhead;
        $this->invoiceNumber = $invoiceNumber;
        $this->poNumber = $poNumber;
        $this->invoiceDate = $invoiceDate;
        $this->dueDate = $dueDate;
        $this->amountDue = $amountDue;
        $this->amountPaid = $amountPaid;
        $this->taxTotal = $taxTotal;
        $this->total = $total;
        $this->currency = $currency;
        $this->exchangeRate = $exchangeRate;
        $this->items = $items;
        $this->memo = $memo;
        $this->footer = $footer;
        $this->disableCreditCardPayments = $disableCreditCardPayments;
        $this->disableBankPayments = $disableBankPayments;
        $this->disableAmexPayments = $disableAmexPayments;
        $this->itemTitle = $itemTitle;
        $this->unitTitle = $unitTitle;
        $this->priceTitle = $priceTitle;
        $this->amountTitle = $amountTitle;
        $this->hideName = $hideName;
        $this->hideDescription = $hideDescription;
        $this->hideUnit = $hideUnit;
        $this->hidePrice = $hidePrice;
        $this->hideAmount = $hideAmount;
        $this->lastSentAt = $lastSentAt;
        $this->lastSentVia = $lastSentVia;
        $this->lastViewedAt = $lastViewedAt;
    }

    public function toCreateArray(): array
    {
        $items = [];
        foreach ($this->items as $item){
            $items[] = $item->toCreateArray();
        }
        return [
            'businessId' => $this->business?->id,
            'customerId' => $this->customer?->id,
            'status' => $this->status,
            'currency' => $this->currency?->code,
            'title' => $this->title,
            'subhead' => $this->subhead,
            'invoiceNumber' => $this->invoiceNumber,
            'poNumber' => $this->poNumber,
            'invoiceDate' => $this->invoiceDate->format('Y-m-d'),
            'exchangeRate' => $this->exchangeRate,
            'dueDate' => $this->dueDate->format('Y-m-d'),
            'items' => $items,
            'memo' => $this->memo,
            'footer' => $this->footer,
            'itemTitle' => $this->itemTitle,
            'unitTitle' => $this->unitTitle,
            'priceTitle' => $this->priceTitle,
            'amountTitle' => $this->amountTitle,
            'hideName' => $this->hideName,
            'hideDescription' => $this->hideDescription,
            'hideUnit' => $this->hideUnit,
            'hidePrice' => $this->hidePrice,
            'hideAmount' => $this->hideAmount
        ];
    }

    #[ArrayShape(['invoiceId' => "string"])]
    public function toCloneArray(): array
    {
        return ['invoiceId' => $this->id];
    }

    #[ArrayShape(['invoiceId' => "string"])]
    public function toDeleteArray(): array
    {
        return ['invoiceId' => $this->id];
    }

    #[ArrayShape(['invoiceId' => "string"])]
    public function toInvoiceApproveArray(): array
    {
        return ['invoiceId' => $this->id];
    }

    #[ArrayShape(['invoiceId' => "string", 'sendMethod' => "string", 'sentAt' => "DateTime"])]
    public function toInvoiceMarkSentArray(): array
    {
        return [
            'invoiceId' => $this->id,
            'sendMethod' => null,
            'sentAt' => null
        ];
    }

    #[ArrayShape(['invoiceId' => "string", 'to' => "string", 'subject' => "string", 'message' => "string", 'attachPdf' => "bool", 'fromAddress' => "string", 'ccMyself' => "bool"])]
    public function toInvoiceSendArray(): array
    {
        return [
            'invoiceId' => $this->id,
            'to' => null,
            'subject' => null,
            'message' => null,
            'attachPdf' => null,
            'fromAddress' => null,
            'ccMyself' => null
        ];
    }
}
