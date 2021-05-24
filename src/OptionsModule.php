<?php

namespace Sun\BitrixModule;

use Sun\BitrixModule\Installer\OptionsInstaller;

interface OptionsModule
{
    public function getOptionsInstaller(): OptionsInstaller;
}
