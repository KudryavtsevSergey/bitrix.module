<?php

namespace Sun\BitrixModule;

use Sun\BitrixModule\Installer\InstallerInterface;

interface Module
{
    public function getId(): string;

    public function getName(): string;

    public function getNamespace(): string;

    public function getModuleGroupRights(): string;

    public function getDescription(): string;

    public function getVersion(): Version;

    public function getInstaller(): InstallerInterface;
}
