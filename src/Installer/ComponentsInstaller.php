<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Installer;

use CMain;
use Sun\BitrixModule\FilePath\ComponentPath;

class ComponentsInstaller extends AbstractFilesCopyInstaller
{
    private const STEP_VALUE = 'components';

    /**
     * @param string $documentRoot
     * @param string $namespace
     * @param string $moduleId
     * @param ComponentPath[] $components
     * @param CMain $application
     * @param InstallerInterface $installer
     */
    public function __construct(
        private string $documentRoot,
        private string $namespace,
        string $moduleId,
        array $components,
        CMain $application,
        InstallerInterface $installer,
    ) {
        parent::__construct($moduleId, $components, $application, $installer);
    }

    protected function getPathFrom(string $name): string
    {
        return sprintf('%s/local/modules/%s/install/components/%s', $this->documentRoot, $this->moduleId, $name);
    }

    protected function getPathTo(string $name): string
    {
        return sprintf('%s/local/components/%s/%s', $this->documentRoot, $this->namespace, $name);
    }

    protected function stepValue(): string
    {
        return self::STEP_VALUE;
    }
}
