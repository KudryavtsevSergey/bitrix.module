<?php

namespace Sun\BitrixModule\Installer;

class RegisterInstaller extends AbstractInstallerDecorator
{
    private string $moduleId;

    public function __construct(string $moduleId, Installer $installer)
    {
        parent::__construct($installer);
        $this->moduleId = $moduleId;
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
