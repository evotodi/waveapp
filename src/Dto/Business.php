<?php

namespace Evotodi\WaveBundle\Dto;

use DateTime;

class Business
{
    public string $id;
    public string $name;
    public bool $isPersonal;
    public ?string $organizationalType;
    public ?BusinessType $type;
    public ?BusinessType $subType;
    public ?Currency $currency;
    public ?string $timezone;
    public ?Address $address;
    public ?string $phone;
    public ?string $fax;
    public ?string $mobile;
    public ?string $tollFree;
    public ?string $website;
    public bool $isClassicAccounting;
    public bool $isClassicInvoicing;
    public bool $isArchived;
    public ?DateTime $createdAt;
    public ?DateTime $modifiedAt;

    public function __construct(
        string $id,
        string $name,
        bool $isPersonal,
        ?string $organizationalType,
        ?BusinessType $type,
        ?BusinessType $subType,
        ?Currency $currency,
        ?string $timezone,
        ?Address $address,
        ?string $phone,
        ?string $fax,
        ?string $mobile,
        ?string $tollFree,
        ?string $website,
        bool $isClassicAccounting,
        bool $isClassicInvoicing,
        bool $isArchived,
        ?DateTime $createdAt,
        ?DateTime $modifiedAt,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->isPersonal = $isPersonal;
        $this->organizationalType = $organizationalType;
        $this->type = $type;
        $this->subType = $subType;
        $this->currency = $currency;
        $this->timezone = $timezone;
        $this->address = $address;
        $this->phone = $phone;
        $this->fax = $fax;
        $this->mobile = $mobile;
        $this->tollFree = $tollFree;
        $this->website = $website;
        $this->isClassicAccounting = $isClassicAccounting;
        $this->isClassicInvoicing = $isClassicInvoicing;
        $this->isArchived = $isArchived;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
    }
}
