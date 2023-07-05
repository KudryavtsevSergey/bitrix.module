<?php

namespace Sun\BitrixModule\Installer;

abstract class AbstractInstallerDecorator implements InstallerInterface
{
    public function __construct(
        private InstallerInterface $installer,
    ) {
    }

    public function install(): void
    {
        $this->installer->install();
    }

    public function uninstall(): void
    {
        $this->installer->uninstall();
    }

    public function getPostInstallCommands(): array
    {
        return $this->installer->getPostInstallCommands();
    }
}
