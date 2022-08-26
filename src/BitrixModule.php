<?php

namespace Sun\BitrixModule;

use CModule;
use Sun\BitrixModule\Command\CommandInterface;
use Sun\BitrixModule\Enum\BooleanTypeEnum;
use Throwable;

abstract class BitrixModule extends CModule implements Module
{
    public function __construct()
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
            $GLOBALS['postInstallCommand'] = $this->generateCommand($installer->getPostInstallCommands());
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

    private function generateCommand(array $commands): ?string
    {
        $commands = array_filter($commands);
        if (empty($commands)) {
            return null;
        }
        $commands = array_map(static function (array $installerCommands): string {
            $installerCommands = array_map(static function (array $commands): string {
                $commands = array_map(static fn(
                    CommandInterface $command
                ): string => $command->getCommand(), $commands);

                return implode(" \\\n&& ", $commands);
            }, $installerCommands);

            return implode(" \\\n\\\n&& ", $installerCommands);
        }, $commands);

        return implode(" \\\n\\\n\\\n&& ", $commands);
    }
}
