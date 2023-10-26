<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Option;

class OptionGroup
{
    /**
     * @param string $name
     * @param AbstractOption[] $options
     */
    public function __construct(
        private readonly string $name,
        private readonly array $options,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return AbstractOption[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
