<?php

namespace Sun\BitrixModule\Option;

class OptionValue
{
    public function __construct(
        private string $name,
        private array|string|null $value
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): array|string|null
    {
        return $this->value;
    }
}
