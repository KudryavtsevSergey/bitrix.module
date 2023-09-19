<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Enum;

class ShowFilterEnum extends AbstractEnum
{
    public const DO_NOT_SHOW = 'N';
    public const EXACT_MATCH = 'I';
    public const SEARCH_BY_MASK = 'E';
    public const SEARCH_BY_SUBSTRING = 'S';

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
