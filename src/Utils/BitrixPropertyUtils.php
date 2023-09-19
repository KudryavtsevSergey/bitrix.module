<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Utils;

use Sun\BitrixModule\Enum\BooleanTypeEnum;
use Sun\BitrixModule\HighLoad\LanguageValue;

class BitrixPropertyUtils
{
    public static function getHighLoadBlockId(int $id): string
    {
        return sprintf('HLBLOCK_%s', $id);
    }

    public static function getBooleanType(bool $value): string
    {
        return $value ? BooleanTypeEnum::YES : BooleanTypeEnum::NO;
    }

    public static function generateLanguageValues(array $languageValues): array
    {
        $result = [];
        /** @var LanguageValue $languageValue */
        foreach ($languageValues as $languageValue) {
            $result[$languageValue->getLanguage()] = $languageValue->getValue();
        }
        return $result;
    }
}
