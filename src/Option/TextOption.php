<?php

namespace Sun\BitrixModule\Option;

class TextOption extends AbstractOption
{
    public function getType(): string
    {
        return OptionType::TEXT;
    }
}
