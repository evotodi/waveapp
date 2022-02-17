<?php

namespace Evotodi\WaveBundle\Dto;

class User
{
    public ?string $id;
    public ?string $defaultEmail;
    public ?string $firstName;
    public ?string $lastName;
    public ?\DateTime $createdAt;
    public ?\DateTime $modifiedAt;

    public function __construct(?string $id, ?string $defaultEmail, ?string $firstName, ?string $lastName, ?\DateTime $createdAt, ?\DateTime $modifiedAt)
    {
        $this->id = $id;
        $this->defaultEmail = $defaultEmail;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
    }
}
