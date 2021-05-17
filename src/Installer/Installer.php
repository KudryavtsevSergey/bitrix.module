<?php

namespace Sun\BitrixModule\Installer;

interface Installer
{
    public function install(): void;

    public function uninstall(): void;
}
