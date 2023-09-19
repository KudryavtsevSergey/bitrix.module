<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Installer;

interface InstallerInterface
{
    public function install(): void;

    public function getPostInstallCommands(): array;

    public function uninstall(): void;
}
