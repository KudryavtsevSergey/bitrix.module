<?php

namespace Sun\BitrixModule\Installer;

use CMain;

class SuccessLogInstaller implements Installer
{
    private string $moduleId;
    private CMain $application;

    public function __construct(string $moduleId, CMain $application)
    {
        $this->moduleId = $moduleId;
        $this->application = $application;
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
}
