<?php

namespace Sun\BitrixModule;

use CModule;
use Sun\BitrixModule\Enum\BooleanTypeEnum;
use Throwable;

abstract class BitrixModule extends CModule implements Module
{
    function __construct()
    {
        $this->MODULE_ID = $this->getId();
        $this->MODULE_NAME = $this->getName();
        $this->MODULE_NAME = $this->getDescription();
        $this->PARTNER_NAME = $this->getNamespace();
        $moduleGroupRights = $this->getModuleGroupRights();
        BooleanTypeEnum::checkAllowedValue($moduleGroupRights);
        $this->MODULE_GROUP_RIGHTS = $moduleGroupRights;

        $version = $this->getVersion();
        $this->MODULE_VERSION = $version->getVersion();
        $this->MODULE_VERSION_DATE = $version->getDate();
    }

    public function DoInstall(): void
    {
        $installer = $this->getInstaller();
        try {
            $installer->install();
        } catch (Throwable $exception) {
            $GLOBALS['moduleException'] = $exception;
            $installer->uninstall();
        }
    }

    public function DoUninstall(): void
    {
        $installer = $this->getInstaller();
        $installer->uninstall();
    }

    public function getModuleGroupRights(): string
    {
        return BooleanTypeEnum::NO;
    }
}
