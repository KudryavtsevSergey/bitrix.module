<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Installer;

use CMain;

class SuccessRedirectInstaller implements InstallerInterface
{
    public const SUCCESS = 'Y';

    public function __construct(
        private string $moduleId,
        private CMain $application,
    ) {
    }

    public function install(): void
    {
        $_SESSION[$this->moduleId] = self::SUCCESS;
        $url = sprintf(
            '%s?mid=%s&lang=%s',
            $this->application->GetCurPage(),
            urlencode($this->moduleId),
            urlencode(LANGUAGE_ID)
        );
        LocalRedirect($url);
    }

    public function uninstall(): void
    {
    }

    public function getPostInstallCommands(): array
    {
        return [];
    }
}
