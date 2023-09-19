<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Option;

class OptionUtils
{
    /**
     * @param OptionValue[] $optionValues
     * @param AbstractOption $option
     * @return array|string|null
     */
    public static function getOptionValue(array $optionValues, AbstractOption $option): array|string|null
    {
        /** @var OptionValue|null $optionValue */
        $optionValue = current(array_filter($optionValues, static fn(
            OptionValue $optionValue
        ): bool => $optionValue->getName() === $option->getName()));

        return $optionValue ? $optionValue->getValue() : $option->getDefault();
    }
}
