<?php

namespace Evotodi\WaveBundle\Dto;

use Evotodi\WaveBundle\Interfaces\CreateArrayInterface;
use JetBrains\PhpStorm\ArrayShape;

class Address implements CreateArrayInterface
{
    public ?string $addressLine1;
    public ?string $addressLine2;
    public ?string $city;
    public ?Province $province;
    public ?Country $country;
    public ?string $postalCode;

    public function __construct(?string $addressLine1, ?string $addressLine2, ?string $city, ?Province $province, ?Country $country, ?string $postalCode)
    {
        $this->addressLine1 = $addressLine1;
        $this->addressLine2 = $addressLine2;
        $this->city = $city;
        $this->province = $province;
        $this->country = $country;
        $this->postalCode = $postalCode;
    }

    #[ArrayShape(['addressLine1' => "string", 'addressLine2' => "string", 'city' => "string", 'provinceCode' => "string", 'countryCode' => "string", 'postalCode' => "string"])]
    public function toCreateArray(): array
    {
        return [
            'addressLine1' => $this->addressLine1,
            'addressLine2' => $this->addressLine2,
            'city' => $this->city,
            'provinceCode' => $this->province?->code,
            'countryCode' => $this->country?->code,
            'postalCode' => $this->postalCode
        ];
    }
}
