<?php

namespace Sun\BitrixModule\Installer;

use Sun\BitrixModule\FilePath\ComponentPath;

class ComponentsInstaller extends FilesCopyInstaller
{
    /**
     * @param string $documentRoot
     * @param string $moduleId
     * @param string $namespace
     * @param ComponentPath[] $components
     * @param InstallerInterface $installer
     */
    public function __construct(
        private string $documentRoot,
        private string $moduleId,
        private string $namespace,
        array $components,
        InstallerInterface $installer,
    ) {
        parent::__construct($components, $installer);
    }

    protected function getPathFrom(string $name): string
    {
        return sprintf('%s/local/modules/%s/install/components/%s', $this->documentRoot, $this->moduleId, $name);
    }

    protected function getPathTo(string $name): string
    {
        return sprintf('%s/local/components/%s/%s', $this->documentRoot, $this->namespace, $name);
    }
}
