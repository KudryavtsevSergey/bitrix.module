<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Installer;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;
use CUserTypeEntity;
use Sun\BitrixModule\Exception\InternalError;
use Sun\BitrixModule\HighLoad\UserFieldManager;
use Sun\BitrixModule\HighLoad\HighLoadTable;
use Sun\BitrixModule\Option\OptionService;
use Sun\BitrixModule\Utils\BitrixPropertyUtils;

class HighLoadBlockInstaller extends AbstractInstallerDecorator
{
    private UserFieldManager $userFieldManager;

    /**
     * @param string $moduleId
     * @param HighLoadTable[] $blocks
     * @param OptionService $optionService
     * @param InstallerInterface $installer
     */
    public function __construct(
        private readonly string $moduleId,
        private readonly array $blocks,
        private readonly OptionService $optionService,
        InstallerInterface $installer
    ) {
        parent::__construct($installer);
        Loader::includeModule('highloadblock');
        $this->userFieldManager = new UserFieldManager(new CUserTypeEntity());
    }

    public function install(): void
    {
        foreach ($this->blocks as $block) {
            $name = $block->getName();
            $highLoadBlockId = $this->createHighLoadBlock($name);
            $this->optionService->setOption($this->moduleId, $name, (string)$highLoadBlockId);
            $this->userFieldManager->createFields(
                BitrixPropertyUtils::getHighLoadBlockId($highLoadBlockId),
                $block->getFields()
            );
        }
        parent::install();
    }

    public function uninstall(): void
    {
        foreach ($this->blocks as $block) {
            $name = $block->getName();
            $highLoadBlockId = $this->optionService->getOption($this->moduleId, $name);
            if ($highLoadBlockId) {
                $this->userFieldManager->deleteFields(
                    BitrixPropertyUtils::getHighLoadBlockId((int)$highLoadBlockId),
                    $block->getFields()
                );
                $this->deleteHighLoadBlock((int)$highLoadBlockId);
            }
            $this->optionService->unsetOption($this->moduleId, $name);
        }
        parent::uninstall();
    }

    private function deleteHighLoadBlock(int $highLoadBlockId): void
    {
        $result = HighloadBlockTable::delete($highLoadBlockId);
        if (!$result->isSuccess()) {
            throw new InternalError(sprintf(
                'Error deleting highload %s with errors %s',
                $highLoadBlockId,
                $result->getErrorMessages()
            ));
        }
    }

    private function createHighLoadBlock(string $highLoadBlockName): int
    {
        $result = HighloadBlockTable::add([
            'NAME' => $highLoadBlockName,
            'TABLE_NAME' => strtolower($highLoadBlockName),
        ]);
        if (!$result->isSuccess()) {
            throw new InternalError(sprintf(
                'Error creating highload %s with errors %s',
                $highLoadBlockName,
                implode(', ', $result->getErrorMessages())
            ));
        }
        return $result->getId();
    }
}
