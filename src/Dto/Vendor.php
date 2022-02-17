<?php

namespace Evotodi\WaveBundle\Dto;

class Vendor
{
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
    public ?bool $isArchived;
    public ?\DateTime $createdAt;
    public ?\DateTime $modifiedAt;

    public function __construct(
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
        ?bool $isArchived,
        ?\DateTime $createdAt,
        ?\DateTime $modifiedAt
    )
    {
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
        $this->isArchived = $isArchived;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
    }
}
