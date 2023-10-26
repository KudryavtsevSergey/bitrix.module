<?php

declare(strict_types=1);

namespace Sun\BitrixModule\HighLoad;

use Sun\BitrixModule\Enum\LanguageEnum;

class LanguageValue
{
    public function __construct(
        private readonly string $language,
        private readonly string $value
    ) {
        LanguageEnum::checkAllowedValue($language);
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
