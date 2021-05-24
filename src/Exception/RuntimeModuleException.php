<?php

namespace Sun\BitrixModule\Exception;

use Throwable;

class RuntimeModuleException extends AbstractInternalException
{
    public function __construct(string $message, ?Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
