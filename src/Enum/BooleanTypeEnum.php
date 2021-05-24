<?php

namespace Sun\BitrixModule\Enum;

class BooleanTypeEnum extends AbstractEnum
{
    const YES = 'Y';
    const NO = 'N';

    public static function getValues(): array
    {
        return [
            self::YES,
            self::NO,
        ];
    }
}
