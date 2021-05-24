<?php

namespace Sun\BitrixModule\Installer;

class ComponentsInstaller extends AbstractInstallerDecorator
{
    private string $documentRoot;
    private string $moduleId;
    private string $namespace;
    /**
     * @var string[]
     */
    private array $components;

    /**
     * @param string $documentRoot
     * @param string $moduleId
     * @param string $namespace
     * @param string[] $components
     * @param Installer $installer
     */
    public function __construct(string $documentRoot, string $moduleId, string $namespace, array $components, Installer $installer)
    {
        parent::__construct($installer);
        $this->documentRoot = $documentRoot;
        $this->moduleId = $moduleId;
        $this->namespace = $namespace;
        $this->components = $components;
    }

    public function install(): void
    {
        array_walk($this->components, function (string $component): void {
            $pathFrom = sprintf('%s/local/modules/%s/install/components/%s', $this->documentRoot, $this->moduleId, $component);
            $pathTo = sprintf('%s/local/components/%s/%s', $this->documentRoot, $this->namespace, $component);

            CopyDirFiles($pathFrom, $pathTo, true, true);
        });

        parent::install();
    }

    public function uninstall(): void
    {
        array_walk($this->components, function (string $component): void {
            $deleteComponentPath = sprintf('%s/local/components/%s/%s', $this->documentRoot, $this->namespace, $component);
            DeleteDirFilesEx($deleteComponentPath);
        });

        $searchPattern = sprintf('%s/local/components/%s/*', $this->documentRoot, $this->namespace);
        if (!glob($searchPattern)) {
            $deleteNamespacePath = sprintf('%s/local/components/%s', $this->documentRoot, $this->namespace);
            DeleteDirFilesEx($deleteNamespacePath);
        }
        parent::uninstall();
    }
}
