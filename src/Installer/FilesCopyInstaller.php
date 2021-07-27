<?php

namespace Sun\BitrixModule\Installer;

abstract class FilesCopyInstaller extends AbstractInstallerDecorator
{
    /**
     * @var string[]
     */
    private array $items;

    /**
     * @param string[] $items
     * @param Installer $installer
     */
    public function __construct(array $items, Installer $installer)
    {
        parent::__construct($installer);
        $this->items = $items;
    }

    public function install(): void
    {
        array_walk($this->items, function (string $item): void {
            $pathFrom = $this->getPathFrom($item);
            $pathTo = $this->getPathTo($item);

            CopyDirFiles($pathFrom, $pathTo, true, true);
        });

        parent::install();
    }

    protected abstract function getPathFrom(string $item): string;
    protected abstract function getPathTo(string $item): string;

    public function uninstall(): void
    {
        array_walk($this->items, function (string $item): void {
            $pathTo = $this->getPathTo($item);
            DeleteDirFilesEx($pathTo);
        });

        $searchPattern = $this->getPathTo('*');
        if (!glob($searchPattern)) {
            $deleteNamespacePath = $this->getPathTo('');
            DeleteDirFilesEx($deleteNamespacePath);
        }
        parent::uninstall();
    }
}
