<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Enum;

class UserTypeEnum extends AbstractEnum
{
    public const ENUMERATION = 'enumeration';
    public const DOUBLE = 'double';
    public const INTEGER = 'integer';
    public const BOOLEAN = 'boolean';
    public const STRING = 'string';
    public const FILE = 'file';
    public const VIDEO = 'video';
    public const DATETIME = 'datetime';
    public const IBLOCK_SECTION = 'iblock_section';
    public const IBLOCK_ELEMENT = 'iblock_element';
    public const STRING_FORMATTED = 'string_formatted';
    public const CRM = 'crm';
    public const CRM_STATUS = 'crm_status';

    public static function getValues(): array
    {
        return [
            self::ENUMERATION,
            self::DOUBLE,
            self::INTEGER,
            self::BOOLEAN,
            self::STRING,
            self::FILE,
            self::VIDEO,
            self::DATETIME,
            self::IBLOCK_SECTION,
            self::IBLOCK_ELEMENT,
            self::STRING_FORMATTED,
            self::CRM,
            self::CRM_STATUS,
        ];
    }
}
