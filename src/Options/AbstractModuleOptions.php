<?php

namespace Sun\BitrixModule\Options;

use Sun\BitrixModule\Installer\OptionsInstaller;
use Sun\BitrixModule\Installer\SuccessRedirectInstaller;
use Sun\BitrixModule\Option\OptionService;

abstract class AbstractModuleOptions implements ModuleOptionsInterface
{
    public function installOptions(): void
    {
        global $APPLICATION;
        $moduleId = $this->getModuleId();

        $successRedirectInstaller = new SuccessRedirectInstaller($moduleId, $APPLICATION);
        $installer = new OptionsInstaller(
            $moduleId,
            $this->getOptionGroups(),
            new OptionService(),
            $APPLICATION,
            $successRedirectInstaller
        );

        $installer->install();
    }

    protected abstract function getModuleId(): string;

    protected abstract function getOptionGroups(): array;
}
