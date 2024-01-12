<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Options;

use Sun\BitrixModule\Installer\OptionsInstaller;
use Sun\BitrixModule\Installer\StepCleanerInstaller;
use Sun\BitrixModule\Installer\SuccessRedirectInstaller;
use Sun\BitrixModule\Option\OptionService;

abstract class AbstractModuleOptions implements ModuleOptionsInterface
{
    public function installOptions(): void
    {
        global $APPLICATION;
        $moduleId = $this->getModuleId();

        $successRedirectInstaller = new SuccessRedirectInstaller($moduleId, $APPLICATION);
        $optionsInstaller = new OptionsInstaller(
            $moduleId,
            $this->getOptionGroups(),
            new OptionService(),
            $APPLICATION,
            $successRedirectInstaller
        );
        $stepCleanerInstaller = new StepCleanerInstaller($optionsInstaller);

        $stepCleanerInstaller->install();
    }

    protected abstract function getModuleId(): string;

    protected abstract function getOptionGroups(): array;
}
