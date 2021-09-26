<?php

namespace Sun\BitrixModule\Installer;

interface InstallerInterface
{
    public function install(): void;

    public function getPostInstallCommands(): array;

    public function uninstall(): void;
}
