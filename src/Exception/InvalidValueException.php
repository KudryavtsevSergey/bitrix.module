<?php

namespace Sun\BitrixModule\Exception;

class InvalidValueException extends AbstractInternalException
{
    private $value;
    private array $allowedValues;

    public function __construct($value, array $allowedValues)
    {
        $message = sprintf(
            'Value "%s" is not allowed. Allowed values are: %s',
            $value,
            implode(', ', $allowedValues)
        );
        parent::__construct($message);
        $this->value = $value;
        $this->allowedValues = $allowedValues;
    }
}
