<?php

namespace Evotodi\WaveBundle\Dto;

use DateTime;
use Evotodi\WaveBundle\Interfaces\CreateArrayInterface;
use Evotodi\WaveBundle\Interfaces\DeleteArrayInterface;
use Evotodi\WaveBundle\Interfaces\PatchArrayInterface;
use JetBrains\PhpStorm\ArrayShape;

class Customer implements CreateArrayInterface, PatchArrayInterface, DeleteArrayInterface
{
    public ?Business $business;
    public ?string $id;
    public ?string $name;
    public ?Address $address;
    public ?string $firstName;
    public ?string $lastName;
    public ?string $displayId;
    public ?string $email;
    public ?string $mobile;
    public ?string $phone;
    public ?string $fax;
    public ?string $tollFree;
    public ?string $website;
    public ?string $internalNotes;
    public ?Currency $currency;
    public ?ShippingDetails $shippingDetails;
    public ?bool $isArchived;
    public ?DateTime $createdAt;
    public ?DateTime $modifiedAt;

    public function __construct(
        ?Business $business,
        ?string $id,
        ?string $name,
        ?Address $address,
        ?string $firstName,
        ?string $lastName,
        ?string $displayId,
        ?string $email,
        ?string $mobile,
        ?string $phone,
        ?string $fax,
        ?string $tollFree,
        ?string $website,
        ?string $internalNotes,
        ?Currency $currency,
        ?ShippingDetails $shippingDetails,
        ?bool $isArchived,
        ?DateTime $createdAt,
        ?DateTime $modifiedAt,
    )
    {
        $this->business = $business;
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->displayId = $displayId;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->phone = $phone;
        $this->fax = $fax;
        $this->tollFree = $tollFree;
        $this->website = $website;
        $this->internalNotes = $internalNotes;
        $this->currency = $currency;
        $this->shippingDetails = $shippingDetails;
        $this->isArchived = $isArchived;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;

    }

    public function toCreateArray(): array
    {
        return [
            'businessId' => $this->business?->id,
            'name' => $this->name,
            "firstName" => $this->firstName,
            "lastName" => $this->lastName,
            "displayId" => $this->displayId,
            "email" => $this->email,
            "mobile" => $this->mobile,
            "phone" => $this->phone,
            "fax" => $this->fax,
            "tollFree" => $this->tollFree,
            "website" => $this->website,
            "internalNotes" => $this->internalNotes,
            'currency' => $this->currency?->code,
            'address' => $this->address?->toCreateArray(),
            'shippingDetails' => $this->shippingDetails?->toCreateArray(),
        ];
    }

    public function toPatchArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            "firstName" => $this->firstName,
            "lastName" => $this->lastName,
            "displayId" => $this->displayId,
            "email" => $this->email,
            "mobile" => $this->mobile,
            "phone" => $this->phone,
            "fax" => $this->fax,
            "tollFree" => $this->tollFree,
            "website" => $this->website,
            "internalNotes" => $this->internalNotes,
            'currency' => $this->currency?->code,
            'address' => $this->address?->toCreateArray(),
            'shippingDetails' => $this->shippingDetails?->toPatchArray(),
        ];
    }

    #[ArrayShape(['id' => "string"])]
    public function toDeleteArray(): array
    {
        return ['id' => $this->id];
    }
}
