<?php

namespace Isibia\Carpark\Entity\Employee;

use Assert\Assertion;
use Ramsey\Uuid\Uuid;

/**
 * Value-object. Генерирует уникальный ID для сущности Employee
 * Использует Ramsey\Uuid\Uuid для генерации.
 * Создание объекта происходит через статический метод next,
 * который вернет новый объект с уникальным id.
 */
class Id
{
    public function __construct(
        private string $id
    ) {
        Assertion::notEmpty($id);
    }

    public static function next(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function isEqualTo(self $other): bool
    {
        return $this->getId() === $other->getId();
    }
}
