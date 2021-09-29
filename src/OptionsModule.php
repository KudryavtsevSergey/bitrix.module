<?php

namespace Sun\BitrixModule;

use Sun\BitrixModule\Installer\InstallerInterface;

interface OptionsModule
{
    public function getOptionsInstaller(): InstallerInterface;
}
