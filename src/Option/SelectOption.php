<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Option;

use Sun\BitrixModule\Enum\OptionTypeEnum;

class SelectOption extends AbstractOption
{
    /**
     * @param string $name
     * @param SelectOptionItem[] $values
     * @param array|string|null $default
     * @param bool $isMultiple
     */
    public function __construct(
        string $name,
        private array $values,
        array|string|null $default = null,
        bool $isMultiple = false
    ) {
        parent::__construct($name, $default, $isMultiple);
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
