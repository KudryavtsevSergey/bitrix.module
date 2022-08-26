<?php

namespace Sun\BitrixModule\Option;

use Sun\BitrixModule\Enum\OptionTypeEnum;

class HiddenOption extends AbstractOption
{
    public function getType(): string
    {
        return OptionTypeEnum::HIDDEN;
    }
}
