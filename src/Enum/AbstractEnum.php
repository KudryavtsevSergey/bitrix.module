<?php

namespace Sun\BitrixModule\Enum;

use Sun\BitrixModule\Exception\InvalidValueException;

abstract class AbstractEnum
{
    public static function checkAllowedValue(string|int|null $value, bool $isAllowNull = false): void
    {
        $isAllow = $isAllowNull && $value === null;
        if (!$isAllow && !static::isContainValue($value)) {
            throw self::invalidValue($value);
        }
    }

    public static function invalidValue(string|int|null $value): InvalidValueException
    {
        return new InvalidValueException($value, static::getValues());
    }

    public static function isContainValue(string|int|null $value): bool
    {
        return in_array($value, static::getValues(), true);
    }

    abstract public static function getValues(): array;
}
