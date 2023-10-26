<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Option;

class OptionValue
{
    public function __construct(
        private readonly string $name,
        private readonly array|string|null $value
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
