<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Installer;

use CMain;
use Sun\BitrixModule\FilePath\ExtensionPath;

class ExtensionsInstaller extends AbstractFilesCopyInstaller
{
    private const STEP_VALUE = 'extensions';

    /**
     * @param string $documentRoot
     * @param string $namespace
     * @param string $moduleId
     * @param ExtensionPath[] $extensions
     * @param CMain $application
     * @param InstallerInterface $installer
     */
    public function __construct(
        private readonly string $documentRoot,
        private readonly string $namespace,
        string $moduleId,
        array $extensions,
        CMain $application,
        InstallerInterface $installer,
    ) {
        parent::__construct($moduleId, $extensions, $application, $installer);
    }

    protected function getPathFrom(string $name): string
    {
        return sprintf('%s/local/modules/%s/install/js/%s', $this->documentRoot, $this->moduleId, $name);
    }

    protected function getPathTo(string $name): string
    {
        return sprintf('%s/local/js/%s/%s', $this->documentRoot, $this->namespace, $name);
    }

    protected function stepValue(): string
    {
        return self::STEP_VALUE;
    }
}
