<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Installer;

use Sun\BitrixModule\Command\ChangeDirectoryCommand;
use Sun\BitrixModule\FilePath\NpmPath;
use Sun\BitrixModule\Utils\DirUtils;

class NpmProjectInstaller extends AbstractInstallerDecorator
{
    /**
     * @param string $documentRoot
     * @param string $moduleId
     * @param NpmPath[] $npmPaths
     * @param InstallerInterface $installer
     */
    public function __construct(
        private readonly string $documentRoot,
        private readonly string $moduleId,
        private array $npmPaths,
        InstallerInterface $installer,
    ) {
        parent::__construct($installer);
    }

    public function uninstall(): void
    {
        array_walk($this->npmPaths, function (NpmPath $npmPath): void {
            $deleteNamespacePath = $this->getNodeModulesPath($npmPath->getName());
            DirUtils::removeDirectory($deleteNamespacePath);
        });

        parent::uninstall();
    }

    public function getPostInstallCommands(): array
    {
        $parentCommands = parent::getPostInstallCommands();

        $commands = array_map(function (NpmPath $npmPath): array {
            $commands = $npmPath->getCommands();
            if (empty($commands)) {
                return [];
            }
            $pathTo = $this->getPath($npmPath->getName());

            return array_merge([
                new ChangeDirectoryCommand($pathTo)
            ], $commands);
        }, $this->npmPaths);
        return array_merge($parentCommands, [array_filter($commands)]);
    }

    private function getPath(string $name): string
    {
        return sprintf('%s/local/modules/%s/install/js/%s', $this->documentRoot, $this->moduleId, $name);
    }

    private function getNodeModulesPath(string $name): string
    {
        return sprintf('%s/node_modules', $this->getPath($name));
    }
}
