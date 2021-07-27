<?php

namespace Sun\BitrixModule\Installer;

class ExtensionsInstaller extends FilesCopyInstaller
{
    private string $documentRoot;
    private string $moduleId;
    private string $namespace;

    /**
     * @param string $documentRoot
     * @param string $moduleId
     * @param string $namespace
     * @param string[] $extensions
     * @param Installer $installer
     */
    public function __construct(string $documentRoot, string $moduleId, string $namespace, array $extensions, Installer $installer)
    {
        parent::__construct($extensions, $installer);
        $this->documentRoot = $documentRoot;
        $this->moduleId = $moduleId;
        $this->namespace = $namespace;
    }

    protected function getPathFrom(string $item): string
    {
        return sprintf('%s/local/modules/%s/install/js/%s', $this->documentRoot, $this->moduleId, $item);
    }

    protected function getPathTo(string $item): string
    {
        return sprintf('%s/local/js/%s/%s', $this->documentRoot, $this->namespace, $item);
    }
}
