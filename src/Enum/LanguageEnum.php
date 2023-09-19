<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Enum;

class LanguageEnum extends AbstractEnum
{
    public const RUSSIAN = 'ru';
    public const ENGLISH = 'en';

    public static function getValues(): array
    {
        return [
            self::RUSSIAN,
            self::ENGLISH,
        ];
    }
}
