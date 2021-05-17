<?php

namespace Sun\BitrixModule\Option;

class OptionValue
{
    private string $name;
    /**
     * @var mixed|null
     */
    private $value;

    /**
     * @param string $name
     * @param mixed|null $value
     */
    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->value;
    }
}
