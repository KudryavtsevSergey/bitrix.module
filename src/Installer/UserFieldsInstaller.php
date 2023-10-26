<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Installer;

use CUserTypeEntity;
use Sun\BitrixModule\HighLoad\UserField;
use Sun\BitrixModule\HighLoad\UserFieldManager;

class UserFieldsInstaller extends AbstractInstallerDecorator
{
    private UserFieldManager $userFieldManager;

    /**
     * @param string $entityId
     * @param UserField[] $userField
     * @param InstallerInterface $installer
     */
    public function __construct(
        private readonly string $entityId,
        private readonly array $userField,
        InstallerInterface $installer
    ) {
        parent::__construct($installer);
        $this->userFieldManager = new UserFieldManager(new CUserTypeEntity());
    }

    public function install(): void
    {
        $this->userFieldManager->createFields($this->entityId, $this->userField);
        parent::install();
    }

    public function uninstall(): void
    {
        $this->userFieldManager->deleteFields($this->entityId, $this->userField);

        parent::uninstall();
    }
}
