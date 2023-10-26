<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Option;

class SelectOptionItem
{
    public function __construct(
        private readonly string $name,
        private readonly int|string $value,
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
