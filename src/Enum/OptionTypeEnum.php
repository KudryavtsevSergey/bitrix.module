<?php

namespace Sun\BitrixModule\Enum;

class OptionTypeEnum extends AbstractEnum
{
    const TEXT = 'TEXT';
    const SELECT = 'SELECT';

    public static function getValues(): array
    {
        return [
            self::TEXT,
            self::SELECT,
        ];
    }
}
