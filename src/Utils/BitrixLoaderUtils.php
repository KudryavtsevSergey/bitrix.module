<?php

namespace Sun\BitrixModule\Utils;

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\UI\Extension;
use Sun\BitrixModule\Exception\ModuleNotFoundException;
use Sun\BitrixModule\Exception\InternalError;

class BitrixLoaderUtils
{
    private function __construct()
    {
    }

    public static function loadModule(string $moduleId): void
    {
        try {
            if (!Loader::includeModule($moduleId)) {
                throw new ModuleNotFoundException($moduleId);
            }
        } catch (LoaderException $e) {
            $message = sprintf('Loader error when loading module %s', $moduleId);
            throw new InternalError($message, $e);
        }
    }

    public static function loadExtension(string $extensionId): void
    {
        try {
            Extension::load($extensionId);
        } catch (LoaderException $e) {
            $message = sprintf('Loader error when loading extension %s', $extensionId);
            throw new InternalError($message, $e);
        }
    }
}
