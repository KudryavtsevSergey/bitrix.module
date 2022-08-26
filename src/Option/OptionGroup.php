<?php

namespace Sun\BitrixModule\Option;

class OptionGroup
{
    private string $name;
    /**
     * @var AbstractOption[]
     */
    private array $options;

    /**
     * @param string $name
     * @param AbstractOption[] $options
     */
    public function __construct(string $name, array $options)
    {
        $this->name = $name;
        $this->options = $options;
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
