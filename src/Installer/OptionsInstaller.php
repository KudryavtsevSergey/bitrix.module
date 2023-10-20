<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Installer;

use Bitrix\Main\Application;
use CMain;
use Sun\BitrixModule\Option\OptionGroup;
use Sun\BitrixModule\Option\OptionService;
use Sun\BitrixModule\Option\OptionValue;

class OptionsInstaller extends AbstractStepInstaller
{
    public const STEP_VALUE = 'options';

    /**
     * @param string $moduleId
     * @param OptionGroup[] $optionGroups
     * @param OptionService $optionService
     * @param CMain $application
     * @param InstallerInterface $installer
     */
    public function __construct(
        private string $moduleId,
        private array $optionGroups,
        private OptionService $optionService,
        private CMain $application,
        InstallerInterface $installer
    ) {
        parent::__construct($installer);
    }

    protected function shouldBeInstalled(): bool
    {
        $request = Application::getInstance()->getContext()->getRequest();
        return check_bitrix_sessid() && $request->isPost() && $request->get(self::STEP_FIELD) === self::STEP_VALUE;
    }

    protected function makeInstall(): void
    {
        $request = Application::getInstance()->getContext()->getRequest();
        foreach ($this->optionGroups as $optionGroup) {
            foreach ($optionGroup->getOptions() as $option) {
                $optionName = $option->getName();
                if ($value = $request->get($optionName) ?? $option->getDefault()) {
                    $value = $option->isMultiple() ? json_encode($value, JSON_THROW_ON_ERROR) : $value;
                    $this->optionService->setOption($this->moduleId, $optionName, $value);
                } else {
                    $this->optionService->unsetOption($this->moduleId, $optionName);
                }
            }
        }
    }

    protected function showInstall(): void
    {
        $GLOBALS['moduleId'] = $this->moduleId;
        $GLOBALS['optionGroups'] = $this->optionGroups;
        $GLOBALS['optionValues'] = $this->getOptionValues();

        $this->application->IncludeAdminFile(
            sprintf('Setting the %s module', $this->moduleId),
            sprintf('%s/../../views/options.php', __DIR__)
        );
    }

    protected function makeUninstall(): void
    {
        foreach ($this->getOptionValues() as $optionValue) {
            $this->optionService->unsetOption($this->moduleId, $optionValue->getName());
        }
    }

    /**
     * @return OptionValue[]
     */
    private function getOptionValues(): array
    {
        $options = $this->optionService->getOptions($this->moduleId);

        $result = [];
        foreach ($this->optionGroups as $optionGroup) {
            foreach ($optionGroup->getOptions() as $option) {
                $optionName = $option->getName();
                $value = $options[$optionName] ?? null;
                $formattedValue = !empty($value) && $option->isMultiple() ?
                    json_decode($value, true, flags: JSON_THROW_ON_ERROR) : $value;
                $result[] = new OptionValue($optionName, $formattedValue);
            }
        }
        return $result;
    }

    protected function stepValue(): string
    {
        return self::STEP_VALUE;
    }
}
