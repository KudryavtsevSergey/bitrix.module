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
    const STEP_FIELD = 'step';
    const STEP_VALUE = 'options';

    private string $moduleId;
    /**
     * @var OptionGroup[]
     */
    private array $optionGroups;
    private OptionService $optionService;
    private CMain $application;

    /**
     * @param string $moduleId
     * @param OptionGroup[] $optionGroups
     * @param OptionService $optionService
     * @param CMain $application
     * @param InstallerInterface $installer
     */
    public function __construct(
        string $moduleId,
        array $optionGroups,
        OptionService $optionService,
        CMain $application,
        InstallerInterface $installer
    ) {
        parent::__construct($installer);
        $this->moduleId = $moduleId;
        $this->optionGroups = $optionGroups;
        $this->optionService = $optionService;
        $this->application = $application;
    }

    public function install(): void
    {
        $request = Application::getInstance()->getContext()->getRequest();
        if (check_bitrix_sessid() && $request->isPost() && $request->get(self::STEP_FIELD) == self::STEP_VALUE) {
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
                $optionValue = $options[$optionName] ?? $option->getDefault();
                $result[] = new OptionValue($optionName, $optionValue);
            }
        }
        return $result;
    }

    private function setOptions(HttpRequest $request): void
    {
        foreach ($this->getOptionValues() as $optionValue) {
            $optionName = $optionValue->getName();
            $value = $request->get($optionName) ?? $optionValue->getValue();
            $this->optionService->setOption($this->moduleId, $optionName, $value);
        }
    }

    private function unsetOptions(): void
    {
        foreach ($this->getOptionValues() as $optionValue) {
            $this->optionService->unsetOption($this->moduleId, $optionValue->getName());
        }
    }
}
