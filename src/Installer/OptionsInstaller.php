<?php

namespace Sun\BitrixModule\Installer;

use Bitrix\Main\Application;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\Config\Option;
use Bitrix\Main\HttpRequest;
use CMain;
use Sun\BitrixModule\Exception\RuntimeModuleException;
use Sun\BitrixModule\Option\OptionGroup;
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
    private CMain $application;

    /**
     * @param string $moduleId
     * @param OptionGroup[] $optionGroups
     * @param Installer $installer
     */
    public function __construct(string $moduleId, array $optionGroups, Installer $installer)
    {
        parent::__construct($installer);
        $this->moduleId = $moduleId;
        $this->optionGroups = $optionGroups;
        global $APPLICATION;
        $this->application = $APPLICATION;
    }

    public function install(): void
    {
        try {
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
        } catch (ArgumentOutOfRangeException $e) {
            throw new RuntimeModuleException($e);
        }
    }

    public function uninstall(): void
    {
        try {
            $this->unsetOptions();
            parent::uninstall();
        } catch (ArgumentNullException $e) {
            throw new RuntimeModuleException($e);
        }
    }

    /**
     * @return OptionValue[]
     */
    private function getOptionValues(): array
    {
        try {
            $options = Option::getForModule($this->moduleId);

            $result = [];
            foreach ($this->optionGroups as $optionGroup) {
                foreach ($optionGroup->getOptions() as $option) {
                    $optionName = $option->getName();
                    $optionValue = $options[$optionName] ?? $option->getDefault();
                    $result[] = new OptionValue($optionName, $optionValue);
                }
            }
            return $result;
        } catch (ArgumentNullException $e) {
            throw new RuntimeModuleException($e);
        }
    }

    /**
     * @param HttpRequest $request
     * @throws ArgumentOutOfRangeException
     */
    private function setOptions(HttpRequest $request): void
    {
        foreach ($this->getOptionValues() as $optionValue) {
            $optionName = $optionValue->getName();
            $value = $request->get($optionName) ?? $optionValue->getValue();
            $this->setOption($optionName, $value);
        }
    }

    /**
     * @throws ArgumentNullException
     */
    private function unsetOptions(): void
    {
        foreach ($this->getOptionValues() as $optionValue) {
            $this->unsetOption($optionValue->getName());
        }
    }

    /**
     * @param string $name
     * @param string $value
     * @throws ArgumentOutOfRangeException
     */
    private function setOption(string $name, string $value): void
    {
        Option::set($this->moduleId, $name, $value);
    }

    /**
     * @param string $name
     * @throws ArgumentNullException
     */
    private function unsetOption(string $name): void
    {
        Option::delete($this->moduleId, ['name' => $name]);
    }
}
