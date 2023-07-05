<?php

namespace Sun\BitrixModule\Installer;

use Bitrix\Main\Application;
use Bitrix\Main\HttpRequest;
use CMain;
use Sun\BitrixModule\Option\OptionGroup;
use Sun\BitrixModule\Option\OptionService;
use Sun\BitrixModule\Option\OptionValue;

class OptionsInstaller extends AbstractInstallerDecorator
{
    public const STEP_FIELD = 'step';
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

    public function install(): void
    {
        $request = Application::getInstance()->getContext()->getRequest();
        if (check_bitrix_sessid() && $request->isPost() && $request->get(self::STEP_FIELD) === self::STEP_VALUE) {
            $this->setOptions($request);
            parent::install();
        } else {
            $title = sprintf('Setting the %s module', $this->moduleId);
            $filePath = sprintf('%s/../../views/options.php', __DIR__);
            $GLOBALS['moduleId'] = $this->moduleId;
            $GLOBALS['optionGroups'] = $this->optionGroups;
            $GLOBALS['optionValues'] = $this->getOptionValues();

            $this->application->IncludeAdminFile($title, $filePath);
        }
    }

    public function uninstall(): void
    {
        $this->unsetOptions();
        parent::uninstall();
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

    private function setOptions(HttpRequest $request): void
    {
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

    private function unsetOptions(): void
    {
        foreach ($this->getOptionValues() as $optionValue) {
            $this->optionService->unsetOption($this->moduleId, $optionValue->getName());
        }
    }
}
