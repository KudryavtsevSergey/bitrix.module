<?php

namespace Sun\BitrixModule\Option;

class OptionUtils
{
    private function __construct()
    {
    }

    public static function getOptionValue(array $optionValues, AbstractOption $option)
    {
        /** @var OptionValue $optionValue */
        $optionValue = current(array_filter($optionValues, fn(OptionValue $optionValue): bool => $optionValue->getName() === $option->getName()));
        return $optionValue ? $optionValue->getValue() : $option->getDefault();
    }
}
