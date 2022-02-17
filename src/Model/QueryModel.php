<?php

namespace Evotodi\WaveBundle\Model;

class QueryModel
{
    public ?string $query = null;
    public ?array  $variables = null;
    public ?string  $operationName = null;

    public function __construct(?string $query, ?array $variables, ?string $operationName)
    {
        $this->query = $query;
        $this->variables = $variables;
        $this->operationName = $operationName;
    }
}
