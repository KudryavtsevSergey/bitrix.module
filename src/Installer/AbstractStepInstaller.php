<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Installer;

abstract class AbstractStepInstaller extends AbstractInstallerDecorator
{
    private const SESSION_STEP_KEY = 'STEP';

    public function __construct(InstallerInterface $installer)
    {
        parent::__construct($installer);
    }

    public function install(): void
    {
        if (!$this->isCurrentStep()) {
            parent::install();
            return;
        }

        if ($this->shouldBeInstalled()) {
            $this->makeInstall();
            $this->deleteCurrentStep();
            parent::install();
        } else {
            $this->saveCurrentStep();
            $this->showInstall();
        }
    }

    public function uninstall(): void
    {
        if (!$this->isCurrentStep()) {
            parent::uninstall();
            return;
        }

        if ($this->shouldBeUninstalled()) {
            $this->makeUninstall();
            $this->deleteCurrentStep();
            parent::uninstall();
        } else {
            $this->showUninstall();
            $this->saveCurrentStep();
        }
    }

    protected function shouldBeInstalled(): bool
    {
        return true;
    }

    protected abstract function makeInstall(): void;

    protected function showInstall(): void
    {
    }

    protected function shouldBeUninstalled(): bool
    {
        return true;
    }

    protected abstract function makeUninstall(): void;

    protected function showUninstall(): void
    {
    }

    public function isCurrentStep(): bool
    {
        $value = $_SESSION[self::SESSION_STEP_KEY] ?? null;
        return $value === null || $value === $this->stepValue();
    }

    public function saveCurrentStep(): void
    {
        $_SESSION[self::SESSION_STEP_KEY] = $this->stepValue();
    }

    public function deleteCurrentStep(): void
    {
        unset($_SESSION[self::SESSION_STEP_KEY]);
    }

    protected abstract function stepValue(): string;
}
