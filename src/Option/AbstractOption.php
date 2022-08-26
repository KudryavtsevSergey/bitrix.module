<?php

namespace Sun\BitrixModule\Option;

abstract class AbstractOption
{
    private string $name;
    /**
     * @var mixed|null
     */
    private $default;
    private bool $isMultiple;

    /**
     * @param string $name
     * @param mixed|null $default
     * @param bool $isMultiple
     */
    public function __construct(string $name, $default = null, bool $isMultiple = false)
    {
        $this->name = $name;
        $this->default = $default;
        $this->isMultiple = $isMultiple;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getInputName(): string
    {
        return $this->isMultiple ? sprintf('%s[]', $this->name) : $this->name;
    }

    /**
     * @return mixed|null
     */
    public function getDefault()
    {
        return $this->default;
    }

    public abstract function getType(): string;

    public function isMultiple(): bool
    {
        return $this->isMultiple;
    }
}
