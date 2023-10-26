<?php

declare(strict_types=1);

namespace Sun\BitrixModule\HighLoad\FieldSetting;

class StringFieldSettings extends AbstractFieldSettings
{
    public function __construct(
        private readonly ?string $default = null,
        private readonly int $size = 20,
        private readonly int $rows = 1,
        private readonly int $minLength = 0,
        private readonly int $maxLength = 0,
        private readonly ?string $regexp = null
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
