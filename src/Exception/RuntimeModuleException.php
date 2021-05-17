<?php

namespace Sun\BitrixModule\Exception;

use RuntimeException;
use Throwable;

class RuntimeModuleException extends RuntimeException
{
    public function __construct(Throwable $previous)
    {
        parent::__construct($previous->getMessage(), 0, $previous);
    }
}
