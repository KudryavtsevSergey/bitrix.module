<?php

declare(strict_types=1);

namespace Sun\BitrixModule\HighLoad;

use CUserTypeEntity;
use Sun\BitrixModule\Exception\InternalError;

class UserFieldManager
{
    public function __construct(
        private CUserTypeEntity $userType,
    ) {
    }

    /**
     * @param string $entityId
     * @param UserField[] $userFields
     */
    public function createFields(string $entityId, array $userFields): void
    {
        foreach ($userFields as $field) {
            $properties = array_merge([
                'ENTITY_ID' => $entityId,
            ], $field->getProperties());
            if (!$this->userType->Add($properties)) {
                throw new InternalError(sprintf(
                    'Error creating highload field %s[%s] with errors %s',
                    $entityId,
                    $field->getFieldName(),
                    $this->userType->LAST_ERROR
                ));
            }
        }
    }

    /**
     * @param string $entityId
     * @param UserField[] $userFields
     */
    public function deleteFields(string $entityId, array $userFields): void
    {
        foreach ($userFields as $field) {
            $obHl = $this->userType->GetList([], ['ENTITY_ID' => $entityId, 'FIELD_NAME' => $field->getFieldName()]);
            while ($arHl = $obHl->Fetch()) {
                if (!$this->userType->Delete($arHl['ID'])) {
                    throw new InternalError(sprintf(
                        'Error deleting highload field %s[%s] with errors %s',
                        $entityId,
                        $field->getFieldName(),
                        $this->userType->LAST_ERROR
                    ));
                }
            }
        }
    }
}
