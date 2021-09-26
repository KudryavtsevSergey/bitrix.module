<?php

namespace Sun\BitrixModule\Installer;

use Sun\BitrixModule\Command\ChangeDirectoryCommand;
use Sun\BitrixModule\FilePath\FilePathInterface;
use Sun\BitrixModule\Utils\DirUtils;

abstract class FilesCopyInstaller extends AbstractInstallerDecorator
{
    /**
     * @var FilePathInterface[]
     */
    private array $items;

    /**
     * @param FilePathInterface[] $items
     * @param InstallerInterface $installer
     */
    public function __construct(array $items, InstallerInterface $installer)
    {
        parent::__construct($installer);
        $this->items = $items;
    }

    public function install(): void
    {
        array_walk($this->items, function (FilePathInterface $item): void {
            $pathFrom = $this->getPathFrom($item->getName());
            $pathTo = $this->getPathTo($item->getName());

            DirUtils::copyDirectory($pathFrom, $pathTo);
        });

        parent::install();
    }

    protected abstract function getPathFrom(string $name): string;

    protected abstract function getPathTo(string $name): string;

    public function uninstall(): void
    {
        array_walk($this->items, function (FilePathInterface $item): void {
            $pathTo = $this->getPathTo($item->getName());
            DirUtils::removeDirectory($pathTo);
        });

        $searchPattern = $this->getPathTo('*');
        if (!glob($searchPattern)) {
            $deleteNamespacePath = $this->getPathTo('');
            DirUtils::removeDirectory($deleteNamespacePath);
        }
        parent::uninstall();
    }

    public function getPostInstallCommands(): array
    {
        $parentCommands = parent::getPostInstallCommands();
        $commands = array_map(function (FilePathInterface $item): array {
            $commands = $item->getCommands();
            if (empty($commands)) {
                return [];
            }
            $pathTo = $this->getPathTo($item->getName());

            return array_merge([
                new ChangeDirectoryCommand($pathTo)
            ], $commands);
        }, $this->items);
        $commands = array_filter($commands);
        return array_merge($parentCommands, [$commands]);
    }
}
