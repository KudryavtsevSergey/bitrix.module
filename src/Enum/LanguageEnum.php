<?php

namespace Sun\BitrixModule\Enum;

class LanguageEnum extends AbstractEnum
{
    const RUSSIAN = 'ru';
    const ENGLISH = 'en';

    public static function getValues(): array
    {
        return [
            self::RUSSIAN,
            self::ENGLISH,
        ];
    }
}
