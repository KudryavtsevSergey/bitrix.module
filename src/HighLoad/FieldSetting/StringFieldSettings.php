<?php

namespace Sun\BitrixModule\HighLoad\FieldSetting;

class StringFieldSettings extends AbstractFieldSettings
{
    public function __construct(
        private ?string $default = null,
        private int $size = 20,
        private int $rows = 1,
        private int $minLength = 0,
        private int $maxLength = 0,
        private ?string $regexp = null
    ) {
    }

    public function getProperties(): array
    {
        return [
            'DEFAULT_VALUE' => $this->default,
            'SIZE' => $this->size,
            'ROWS' => $this->rows,
            'MIN_LENGTH' => $this->minLength,
            'MAX_LENGTH' => $this->maxLength,
            'REGEXP' => $this->regexp,
        ];
    }
}
