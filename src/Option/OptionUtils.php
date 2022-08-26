<?php

namespace Sun\BitrixModule\Option;

class OptionUtils
{
    private function __construct()
    {
    }

    /**
     * @param OptionValue[] $optionValues
     * @param AbstractOption $option
     * @return mixed|null
     */
    public static function getOptionValue(array $optionValues, AbstractOption $option)
    {
        /** @var OptionValue|null $optionValue */
        $optionValue = current(array_filter($optionValues, static fn(
            OptionValue $optionValue
        ): bool => $optionValue->getName() === $option->getName()));

        return $optionValue ? $optionValue->getValue() : $option->getDefault();
    }
}
