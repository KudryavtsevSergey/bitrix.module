<?php

namespace Sun\BitrixModule\Option;

class SelectOptionItem
{
    public function __construct(
        private string $name,
        private int|string $value,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): int|string
    {
        return $this->value;
    }
}
