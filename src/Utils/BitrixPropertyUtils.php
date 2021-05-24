<?php

namespace Sun\BitrixModule\Utils;

use Sun\BitrixModule\Enum\BooleanTypeEnum;

class BitrixPropertyUtils
{
    private function __construct()
    {
    }

    public static function getHighLoadBlockId(int $id): string
    {
        return sprintf('HLBLOCK_%s', $id);
    }

    public static function getFieldName(string $fieldName): string
    {
        return sprintf('UF_%s', $fieldName);
    }

    public static function getBooleanType(bool $value): string
    {
        return $value ? BooleanTypeEnum::YES : BooleanTypeEnum::NO;
    }

    public static function generateLanguageValues(array $languageValues): array
    {
        $result = [];
        foreach ($languageValues as $languageValue) {
            $result[$languageValue->getLanguage()] = $languageValue->getValue();
        }
        return $result;
    }
}
