<?php

namespace Sun\BitrixModule\HighLoad;

use Sun\BitrixModule\Enum\ShowFilterEnum;
use Sun\BitrixModule\Exception\InternalError;
use Sun\BitrixModule\HighLoad\FieldSetting\AbstractFieldSettings;
use Sun\BitrixModule\Utils\BitrixPropertyUtils;

class HighLoadField implements BitrixPropertiesInterface
{
    const USER_FIELD_PREFIX = 'UF_';

    private string $fieldName;
    private string $userType;
    private bool $mandatory;
    private AbstractFieldSettings $fieldSetting;
    private bool $multiple;
    private string $xmlId;
    private int $sort;
    private string $showFilter;
    private bool $showInList;
    private bool $editInList;
    private bool $isSearchable;
    /**
     * @var LanguageValue[]
     */
    private array $editFormLabel;
    /**
     * @var LanguageValue[]
     */
    private array $listColumnLabel;
    /**
     * @var LanguageValue[]
     */
    private array $listFilterLabel;
    /**
     * @var LanguageValue[]
     */
    private array $errorMessage;
    /**
     * @var LanguageValue[]
     */
    private array $helpMessage;

    /**
     * @param string $fieldName
     * @param string $userType
     * @param bool $mandatory
     * @param AbstractFieldSettings $fieldSetting
     * @param bool $multiple
     * @param string $xmlId
     * @param int $sort
     * @param string $showFilter
     * @param bool $showInList
     * @param bool $editInList
     * @param bool $isSearchable
     * @param LanguageValue[] $editFormLabel
     * @param LanguageValue[] $listColumnLabel
     * @param LanguageValue[] $listFilterLabel
     * @param LanguageValue[] $errorMessage
     * @param LanguageValue[] $helpMessage
     */
    public function __construct(
        string $fieldName,
        string $userType,
        bool $mandatory,
        AbstractFieldSettings $fieldSetting,
        bool $multiple = false,
        string $xmlId = '',
        int $sort = 500,
        string $showFilter = ShowFilterEnum::DO_NOT_SHOW,
        bool $showInList = true,
        bool $editInList = true,
        bool $isSearchable = true,
        array $editFormLabel = [],
        array $listColumnLabel = [],
        array $listFilterLabel = [],
        array $errorMessage = [],
        array $helpMessage = []
    ) {
        ShowFilterEnum::checkAllowedValue($showFilter);
        if (stripos($fieldName, self::USER_FIELD_PREFIX) !== 0) {
            $message = sprintf('Field name %s must start with %s', $fieldName, self::USER_FIELD_PREFIX);
            throw new InternalError($message);
        }

        $this->fieldName = $fieldName;
        $this->userType = $userType;
        $this->mandatory = $mandatory;
        $this->fieldSetting = $fieldSetting;
        $this->multiple = $multiple;
        $this->xmlId = $xmlId;
        $this->sort = $sort;
        $this->showFilter = $showFilter;
        $this->showInList = $showInList;
        $this->editInList = $editInList;
        $this->isSearchable = $isSearchable;
        $this->editFormLabel = $editFormLabel;
        $this->listColumnLabel = $listColumnLabel;
        $this->listFilterLabel = $listFilterLabel;
        $this->errorMessage = $errorMessage;
        $this->helpMessage = $helpMessage;
    }

    public function getProperties(): array
    {
        return [
            'FIELD_NAME' => $this->fieldName,
            'USER_TYPE_ID' => $this->userType,
            'XML_ID' => $this->xmlId,
            'SORT' => $this->sort,
            'MULTIPLE' => BitrixPropertyUtils::getBooleanType($this->multiple),
            'MANDATORY' => BitrixPropertyUtils::getBooleanType($this->mandatory),
            'SHOW_FILTER' => $this->showFilter,
            'SHOW_IN_LIST' => $this->showInList,
            'EDIT_IN_LIST' => $this->editInList,
            'IS_SEARCHABLE' => BitrixPropertyUtils::getBooleanType($this->isSearchable),
            'SETTINGS' => $this->fieldSetting->getProperties(),
            'EDIT_FORM_LABEL' => BitrixPropertyUtils::generateLanguageValues($this->editFormLabel),
            'LIST_COLUMN_LABEL' => BitrixPropertyUtils::generateLanguageValues($this->listColumnLabel),
            'LIST_FILTER_LABEL' => BitrixPropertyUtils::generateLanguageValues($this->listFilterLabel),
            'ERROR_MESSAGE' => BitrixPropertyUtils::generateLanguageValues($this->errorMessage),
            'HELP_MESSAGE' => BitrixPropertyUtils::generateLanguageValues($this->helpMessage),
        ];
    }
}
