<?php

namespace Isibia\Carpark\Entity\Employee;

use Assert\Assertion;

/**
 * Value-object. Имя работника.
 * Отчество необязательно. Метод getFull
 * вернет полное имя работника.
 */
class Name
{
    public function __construct(
        private string $last,
        private string $first,
        private ?string $middle
    ) {
        Assertion::notEmpty($last);
        Assertion::notEmpty($first);
    }

    public function getFull(): string
    {
        return trim($this->last . ' ' . $this->first . ' ' . $this->middle);
    }

    public function getFirst(): string { return $this->first; }
    public function getMiddle(): ?string { return $this->middle; }
    public function getLast(): string { return $this->last; }
}
