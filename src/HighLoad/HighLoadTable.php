<?php

namespace Sun\BitrixModule\HighLoad;

use Sun\BitrixModule\Exception\InternalError;

class HighLoadTable implements BitrixPropertiesInterface
{
    /**
     * @param string $name
     * @param HighLoadField[] $fields
     */
    public function __construct(
        private string $name,
        private array $fields,
    ) {
        if (!preg_match('~^\p{Lu}~u', $name)) {
            throw new InternalError(sprintf('The name %s of the highload block must start with a capital letter', $name));
        }
        if (!preg_match('/[A-Za-z0-9]+/', $name)) {
            throw new InternalError(sprintf('The name %s of the highload block must consist only of latin letters and numbers', $name));
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProperties(): array
    {
        return array_map(static fn(
            HighLoadField $highLoadField
        ): array => $highLoadField->getProperties(), $this->fields);
    }
}
