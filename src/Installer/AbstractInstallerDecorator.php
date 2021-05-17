<?php

namespace Sun\BitrixModule\Installer;

abstract class AbstractInstallerDecorator implements Installer
{
    private Installer $installer;

    public function __construct(Installer $installer)
    {
        $this->installer = $installer;
    }

    public function install(): void
    {
        $this->installer->install();
    }

    public function uninstall(): void
    {
        $this->installer->uninstall();
    }
}
