<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Option;

use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\Config\Option;
use Sun\BitrixModule\Exception\InternalError;

class OptionService
{
    public function getOptions(string $moduleId): array
    {
        try {
            return Option::getForModule($moduleId);
        } catch (ArgumentNullException $e) {
            $message = sprintf('Error get options for module %s', $moduleId);
            throw new InternalError($message, $e);
        }
    }

    public function getOption(string $moduleId, string $name): string
    {
        try {
            return Option::get($moduleId, $name);
        } catch (ArgumentOutOfRangeException|ArgumentNullException $e) {
            $message = sprintf('Error get option %s for module %s', $name, $moduleId);
            throw new InternalError($message, $e);
        }
    }

    public function setOption(string $moduleId, string $name, string $value): void
    {
        try {
            Option::set($moduleId, $name, $value);
        } catch (ArgumentOutOfRangeException $e) {
            $message = sprintf('Error set option %s with value %s for module %s', $name, $value, $moduleId);
            throw new InternalError($message, $e);
        }
    }

    public function unsetOption(string $moduleId, string $name): void
    {
        try {
            Option::delete($moduleId, ['name' => $name]);
        } catch (ArgumentNullException $e) {
            $message = sprintf('Error unset option %s for module %s', $name, $moduleId);
            throw new InternalError($message, $e);
        }
    }
}
