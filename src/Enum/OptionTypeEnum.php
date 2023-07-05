<?php

namespace Sun\BitrixModule\Enum;

class OptionTypeEnum extends AbstractEnum
{
    public const TEXT = 'TEXT';
    public const SELECT = 'SELECT';
    public const HIDDEN = 'HIDDEN';

    public static function getValues(): array
    {
        return [
            self::TEXT,
            self::SELECT,
            self::HIDDEN,
        ];
    }
}
