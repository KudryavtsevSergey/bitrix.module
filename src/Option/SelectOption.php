<?php

namespace Sun\BitrixModule\Option;

use Sun\BitrixModule\Enum\OptionTypeEnum;

class SelectOption extends AbstractOption
{
    /**
     * @var SelectOptionItem[]
     */
    private array $values;

    /**
     * @param string $name
     * @param SelectOptionItem[] $values
     * @param string|null $default
     * @param bool $isMultiple
     */
    public function __construct(
        string $name,
        array $values,
        ?string $default = null,
        bool $isMultiple = false
    ) {
        parent::__construct($name, $default, $isMultiple);
        $this->values = $values;
    }

    /**
     * @return SelectOptionItem[]
     */
    public function getValues(): array
    {
        return $this->values;
    }

    public function getType(): string
    {
        return OptionTypeEnum::SELECT;
    }
}
