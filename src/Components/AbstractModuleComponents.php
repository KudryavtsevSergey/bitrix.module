<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Components;

use Sun\BitrixModule\Installer\ComponentsInstaller;
use Sun\BitrixModule\Installer\StepCleanerInstaller;
use Sun\BitrixModule\Installer\SuccessRedirectInstaller;

abstract class AbstractModuleComponents implements ModuleComponentsInterface
{
    public function installComponents(): void
    {
        global $APPLICATION, $DOCUMENT_ROOT;
        $moduleId = $this->getModuleId();

        $successRedirectInstaller = new SuccessRedirectInstaller($moduleId, $APPLICATION);
        $componentsInstaller = new ComponentsInstaller(
            $DOCUMENT_ROOT,
            $this->getNamespace(),
            $moduleId,
            $this->getComponents(),
            $APPLICATION,
            $successRedirectInstaller
        );
        $stepCleanerInstaller = new StepCleanerInstaller($componentsInstaller);

        $stepCleanerInstaller->install();
    }

    protected abstract function getModuleId(): string;

    protected abstract function getComponents(): array;

    protected abstract function getNamespace(): string;
}
