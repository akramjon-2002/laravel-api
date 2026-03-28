<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Debug\ShouldntReport;

class ApiResourceNotFoundException extends Exception implements ShouldntReport
{
    public function __construct(
        private readonly string $resource,
    ) {
        parent::__construct(sprintf('%s not found.', $resource));
    }

    public function resource(): string
    {
        return $this->resource;
    }
}
