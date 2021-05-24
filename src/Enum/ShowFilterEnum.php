<?php

namespace Sun\BitrixModule\Enum;

class ShowFilterEnum extends AbstractEnum
{
    const DO_NOT_SHOW = 'N';
    const EXACT_MATCH = 'I';
    const SEARCH_BY_MASK = 'E';
    const SEARCH_BY_SUBSTRING = 'S';

    public static function getValues(): array
    {
        return [
            self::DO_NOT_SHOW,
            self::EXACT_MATCH,
            self::SEARCH_BY_MASK,
            self::SEARCH_BY_SUBSTRING,
        ];
    }
}
