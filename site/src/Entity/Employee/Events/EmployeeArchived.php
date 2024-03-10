<?php

namespace Isibia\Carpark\Entity\Employee\Events;

use Isibia\Carpark\Entity\Employee\Id;

class EmployeeArchived
{
    public function __construct(
        public Id $employee,
        public \DateTimeImmutable $date
    ) {
    }
}