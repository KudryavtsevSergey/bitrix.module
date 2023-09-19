<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Option;

use Sun\BitrixModule\Enum\OptionTypeEnum;

class TextOption extends AbstractOption
{
    public function getType(): string
    {
        return OptionTypeEnum::TEXT;
    }
}
