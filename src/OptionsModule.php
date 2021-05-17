<?php

namespace Sun\BitrixModule;

use Sun\BitrixModule\Installer\OptionsInstaller;

interface OptionsModule extends Module
{
    public function getOptionsInstaller(): OptionsInstaller;
}
