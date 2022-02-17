<?php

namespace Evotodi\WaveBundle\Dto;

class Country
{

    public ?string $code;
    public ?string $name;
    public ?Currency $currency;
    public ?string $nameWithArticle;
    public ?array $province;

    /**
     * @param Province[] $province
     */
    public function __construct(?string $code, ?string $name, ?Currency $currency, ?string $nameWithArticle, ?array $province)
    {
        $this->code = $code;
        $this->name = $name;
        $this->currency = $currency;
        $this->nameWithArticle = $nameWithArticle;
        $this->province = $province;
    }
}
