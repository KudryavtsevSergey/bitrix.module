<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Exception;

use Throwable;

class InternalError extends AbstractInternalException
{
    public function __construct(string $message, ?Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
