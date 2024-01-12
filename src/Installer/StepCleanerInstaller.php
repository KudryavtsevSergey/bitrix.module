<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Installer;

class StepCleanerInstaller implements InstallerInterface
{
    public function __construct(
        private readonly AbstractStepInstaller $installer,
    ) {
    }

    public function install(): void
    {
        if (!$this->installer->isCurrentStep()) {
            $this->installer->saveCurrentStep();
        }
        $this->installer->install();
    }

    public function uninstall(): void
    {
        if (!$this->installer->isCurrentStep()) {
            $this->installer->saveCurrentStep();
        }
        $this->installer->uninstall();
    }

    public function getPostInstallCommands(): array
    {
        return $this->installer->getPostInstallCommands();
    }
}
