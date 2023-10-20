<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Installer;

use Bitrix\Main\Application;
use CMain;
use Sun\BitrixModule\Command\ChangeDirectoryCommand;
use Sun\BitrixModule\FilePath\FilePathInterface;
use Sun\BitrixModule\Utils\DirUtils;

abstract class AbstractFilesCopyInstaller extends AbstractStepInstaller
{
    public const IS_COPY_FILES_FIELD_NAME = 'IS_COPY_FILES';
    public const IS_DELETE_FILES_INPUT_NAME = 'IS_DELETE_FILES';

    /**
     * @param string $moduleId
     * @param FilePathInterface[] $items
     * @param CMain $application
     * @param InstallerInterface $installer
     */
    public function __construct(
        protected string $moduleId,
        private array $items,
        private CMain $application,
        InstallerInterface $installer,
    ) {
        parent::__construct($installer);
    }

    protected function shouldBeInstalled(): bool
    {
        $request = Application::getInstance()->getContext()->getRequest();
        return check_bitrix_sessid() && $request->isPost() && $request->get(self::STEP_FIELD) === $this->stepValue();
    }

    protected function makeInstall(): void
    {
        $request = Application::getInstance()->getContext()->getRequest();
        if ($request->get(self::IS_COPY_FILES_FIELD_NAME) === null) {
            return;
        }

        array_walk($this->items, function (FilePathInterface $item): void {
            $pathFrom = $this->getPathFrom($item->getName());
            $pathTo = $this->getPathTo($item->getName());

            DirUtils::copyDirectory($pathFrom, $pathTo);
        });
    }

    protected function showInstall(): void
    {
        $_SESSION['STEP'] = $this->stepValue();
        $GLOBALS['moduleId'] = $this->moduleId;
        $GLOBALS['stepValue'] = $this->stepValue();

        $this->application->IncludeAdminFile(
            sprintf('Setting the %s module', $this->moduleId),
            sprintf('%s/../../views/files_copy_install.php', __DIR__)
        );
    }

    protected function shouldBeUninstalled(): bool
    {
        $request = Application::getInstance()->getContext()->getRequest();
        return check_bitrix_sessid() && $request->isPost() && $request->get(self::STEP_FIELD) === $this->stepValue();
    }

    protected function makeUninstall(): void
    {
        $request = Application::getInstance()->getContext()->getRequest();
        if ($request->get(self::IS_DELETE_FILES_INPUT_NAME) === null) {
            return;
        }

        array_walk($this->items, function (FilePathInterface $item): void {
            $pathTo = $this->getPathTo($item->getName());
            DirUtils::removeDirectory($pathTo);
        });

        $searchPattern = $this->getPathTo('*');
        if (!glob($searchPattern)) {
            $deleteNamespacePath = $this->getPathTo('');
            DirUtils::removeDirectory($deleteNamespacePath);
        }
    }

    protected function showUninstall(): void
    {
        $GLOBALS['moduleId'] = $this->moduleId;
        $GLOBALS['stepValue'] = $this->stepValue();

        $this->application->IncludeAdminFile(
            sprintf('Setting the %s module', $this->moduleId),
            sprintf('%s/../../views/files_copy_uninstall.php', __DIR__)
        );
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
        return array_merge($parentCommands, [array_filter($commands)]);
    }

    protected abstract function getPathFrom(string $name): string;

    protected abstract function getPathTo(string $name): string;
}
