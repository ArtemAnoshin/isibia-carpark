<?php

namespace Isibia\Carpark\Entity\Employee\Events;

use Isibia\Carpark\Entity\Employee\Id;

class EmployeeRemoved
{
    public function __construct(
        public Id $employee,
    ) {
    }
}