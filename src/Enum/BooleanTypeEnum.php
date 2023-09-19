<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Enum;

class BooleanTypeEnum extends AbstractEnum
{
    public const YES = 'Y';
    public const NO = 'N';

    public static function getValues(): array
    {
        return [
            self::YES,
            self::NO,
        ];
    }
}
