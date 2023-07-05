<?php

namespace Sun\BitrixModule\Installer;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;
use CUserTypeEntity;
use Sun\BitrixModule\Exception\InternalError;
use Sun\BitrixModule\HighLoad\HighLoadTable;
use Sun\BitrixModule\Option\OptionService;
use Sun\BitrixModule\Utils\BitrixPropertyUtils;

class HighLoadBlockInstaller extends AbstractInstallerDecorator
{
    /**
     * @param string $moduleId
     * @param HighLoadTable[] $blocks
     * @param OptionService $optionService
     * @param InstallerInterface $installer
     */
    public function __construct(
        private string $moduleId,
        private array $blocks,
        private OptionService $optionService,
        InstallerInterface $installer
    ) {
        parent::__construct($installer);
        Loader::includeModule('highloadblock');
    }

    public function install(): void
    {
        foreach ($this->blocks as $block) {
            $name = $block->getName();
            $highLoadBlockId = $this->createHighLoadBlock($name);
            $this->optionService->setOption($this->moduleId, $name, (string)$highLoadBlockId);
            $this->createHighLoadFields($highLoadBlockId, $block->getProperties());
        }
        parent::install();
    }

    public function uninstall(): void
    {
        foreach ($this->blocks as $block) {
            $name = $block->getName();
            $highLoadBlockId = $this->optionService->getOption($this->moduleId, $name);
            if ($highLoadBlockId) {
                $this->deleteHighLoadFields((int)$highLoadBlockId);
                $this->deleteHighLoadBlock((int)$highLoadBlockId);
            }
            $this->optionService->unsetOption($this->moduleId, $name);
        }
        parent::uninstall();
    }

    private function deleteHighLoadFields(int $highLoadBlockId): void
    {
        $userType = $this->createUserType();
        $obHl = $userType->GetList([], ['ENTITY_ID' => BitrixPropertyUtils::getHighLoadBlockId($highLoadBlockId)]);
        while ($arHl = $obHl->Fetch()) {
            $userType = $this->createUserType();
            $userType->Delete($arHl['ID']);
        }
    }

    private function deleteHighLoadBlock(int $highLoadBlockId): void
    {
        $result = HighloadBlockTable::delete($highLoadBlockId);
        if (!$result->isSuccess()) {
            $message = sprintf(
                'Error deleting highload %s with errors %s',
                $highLoadBlockId,
                $result->getErrorMessages()
            );
            throw new InternalError($message);
        }
    }

    private function createHighLoadBlock(string $highLoadBlockName): int
    {
        $result = HighloadBlockTable::add([
            'NAME' => $highLoadBlockName,
            'TABLE_NAME' => strtolower($highLoadBlockName),
        ]);
        if (!$result->isSuccess()) {
            $message = sprintf(
                'Error creating highload %s with errors %s',
                $highLoadBlockName,
                implode(', ', $result->getErrorMessages())
            );
            throw new InternalError($message);
        }
        return $result->getId();
    }

    public function createHighLoadFields(int $id, array $highLoadFields): void
    {
        $userType = $this->createUserType();
        foreach ($highLoadFields as $highLoadField) {
            $field = array_merge([
                'ENTITY_ID' => BitrixPropertyUtils::getHighLoadBlockId($id),
            ], $highLoadField);
            if (!$userType->Add($field)) {
                $message = sprintf(
                    'Error creating highload field %s[%s] with errors %s',
                    $field['ENTITY_ID'],
                    $field['FIELD_NAME'],
                    $userType->LAST_ERROR
                );
                throw new InternalError($message);
            }
        }
    }

    private function createUserType(): CUserTypeEntity
    {
        return new CUserTypeEntity();
    }
}
