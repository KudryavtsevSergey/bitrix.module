<?php

namespace Sun\BitrixModule\Installer;

use CMain;

class SuccessLogInstaller implements Installer
{
    private string $moduleId;
    private CMain $application;
    private string $documentRoot;

    public function __construct(string $moduleId)
    {
        $this->moduleId = $moduleId;
        global $APPLICATION, $DOCUMENT_ROOT;
        $this->application = $APPLICATION;
        $this->documentRoot = $DOCUMENT_ROOT;
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
