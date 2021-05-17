<?php

namespace Sun\BitrixModule\Option;

abstract class AbstractOption
{
    private string $name;
    private ?string $default;

    public function __construct(string $name, ?string $default = null)
    {
        $this->name = $name;
        $this->default = $default;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDefault(): ?string
    {
        return $this->default;
    }

    public abstract function getType(): string;
}
