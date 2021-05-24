<?php

namespace Sun\BitrixModule\Enum;

class UserTypeEnum extends AbstractEnum
{
    const ENUMERATION = 'enumeration';
    const DOUBLE = 'double';
    const INTEGER = 'integer';
    const BOOLEAN = 'boolean';
    const STRING = 'string';
    const FILE = 'file';
    const VIDEO = 'video';
    const DATETIME = 'datetime';
    const IBLOCK_SECTION = 'iblock_section';
    const IBLOCK_ELEMENT = 'iblock_element';
    const STRING_FORMATTED = 'string_formatted';
    const CRM = 'crm';
    const CRM_STATUS = 'crm_status';

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
