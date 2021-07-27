<?php

namespace Sun\BitrixModule\Exception;

class ModuleNotFoundException extends AbstractInternalException
{
    public function __construct(string $moduleId)
    {
        $message = sprintf('Module with id %s not found', $moduleId);
        parent::__construct($message);
    }
}
