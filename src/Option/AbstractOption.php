<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Option;

abstract class AbstractOption
{
    public function __construct(
        private readonly string $name,
        private readonly array|string|null $default = null,
        private readonly bool $isMultiple = false
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getInputName(): string
    {
        return $this->isMultiple ? sprintf('%s[]', $this->name) : $this->name;
    }

    public function getDefault(): array|string|null
    {
        return $this->default;
    }

    public abstract function getType(): string;

    public function isMultiple(): bool
    {
        return $this->isMultiple;
    }
}
