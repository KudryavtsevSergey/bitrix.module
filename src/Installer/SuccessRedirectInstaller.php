<?php

namespace Sun\BitrixModule\Installer;

use CMain;

class SuccessRedirectInstaller implements Installer
{
    const SUCCESS = 'Y';

    private string $moduleId;
    private CMain $application;

    public function __construct(string $moduleId)
    {
        $this->moduleId = $moduleId;
        global $APPLICATION;
        $this->application = $APPLICATION;
    }

    public function install(): void
    {
        $_SESSION[$this->moduleId] = self::SUCCESS;
        $url = sprintf('%s?mid=%s&lang=%s', $this->application->GetCurPage(), urlencode($this->moduleId), urlencode(LANGUAGE_ID));
        LocalRedirect($url);
    }

    public function uninstall(): void
    {
    }
}
