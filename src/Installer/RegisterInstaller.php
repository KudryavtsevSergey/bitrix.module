<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Installer;

class RegisterInstaller extends AbstractInstallerDecorator
{
    public function __construct(
        private string $moduleId,
        InstallerInterface $installer,
    ) {
        parent::__construct($installer);
    }

    public function install(): void
    {
        RegisterModule($this->moduleId);
        parent::install();
    }

    public function uninstall(): void
    {
        UnRegisterModule($this->moduleId);
        parent::uninstall();
    }
}
