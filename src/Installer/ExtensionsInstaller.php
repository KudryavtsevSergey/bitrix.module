<?php

namespace Sun\BitrixModule\Installer;

use Sun\BitrixModule\FilePath\ExtensionPath;

class ExtensionsInstaller extends FilesCopyInstaller
{
    private string $documentRoot;
    private string $moduleId;
    private string $namespace;

    /**
     * @param string $documentRoot
     * @param string $moduleId
     * @param string $namespace
     * @param ExtensionPath[] $extensions
     * @param InstallerInterface $installer
     */
    public function __construct(
        string $documentRoot,
        string $moduleId,
        string $namespace,
        array $extensions,
        InstallerInterface $installer
    ) {
        parent::__construct($extensions, $installer);
        $this->documentRoot = $documentRoot;
        $this->moduleId = $moduleId;
        $this->namespace = $namespace;
    }

    protected function getPathFrom(string $name): string
    {
        return sprintf('%s/local/modules/%s/install/js/%s', $this->documentRoot, $this->moduleId, $name);
    }

    protected function getPathTo(string $name): string
    {
        return sprintf('%s/local/js/%s/%s', $this->documentRoot, $this->namespace, $name);
    }
}
