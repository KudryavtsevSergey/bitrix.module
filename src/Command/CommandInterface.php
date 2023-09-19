<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Command;

interface CommandInterface
{
    public function getCommand(): string;
}
