<?php

namespace Sun\BitrixModule\HighLoad;

use Sun\BitrixModule\Enum\LanguageEnum;

class LanguageValue
{
    private string $language;
    private string $value;

    public function __construct(string $language, string $value)
    {
        LanguageEnum::checkAllowedValue($language);
        $this->language = $language;
        $this->value = $value;
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
