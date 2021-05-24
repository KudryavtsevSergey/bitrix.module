<?php

namespace Sun\BitrixModule\HighLoad\FieldSetting;

class StringFieldSettings extends AbstractFieldSettings
{
    /**
     * @var mixed|null
     */
    private $default;
    private int $size;
    private int $rows;
    private int $minLength;
    private int $maxLength;
    private ?string $regexp;

    /**
     * @param mixed|null $default
     * @param int $size
     * @param int $rows
     * @param int $minLength
     * @param int $maxLength
     * @param string|null $regexp
     */
    public function __construct($default = null, int $size = 20, int $rows = 1, int $minLength = 0, int $maxLength = 0, ?string $regexp = null)
    {
        $this->default = $default;
        $this->size = $size;
        $this->rows = $rows;
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
        $this->regexp = $regexp;
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
