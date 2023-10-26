<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Installer;

use CMain;

class SuccessLogInstaller implements InstallerInterface
{
    public function __construct(
        private readonly string $moduleId,
        private readonly CMain $application,
    ) {
    }

    public function install(): void
    {
        $title = sprintf('The module %s installed', $this->moduleId);
        $filePath = sprintf('%s/../../views/install.php', __DIR__);
        $this->application->IncludeAdminFile($title, $filePath);
    }

    public function uninstall(): void
    {
        $title = sprintf('Uninstalling the module %s', $this->moduleId);
        $filePath = sprintf('%s/../../views/uninstall.php', __DIR__);
        $this->application->IncludeAdminFile($title, $filePath);
    }

    public function getPostInstallCommands(): array
    {
        return [];
    }
}
