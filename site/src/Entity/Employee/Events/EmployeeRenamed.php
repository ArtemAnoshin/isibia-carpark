<?php

namespace Isibia\Carpark\Entity\Employee\Events;

use Isibia\Carpark\Entity\Employee\Id;
use Isibia\Carpark\Entity\Employee\Name;

class EmployeeRenamed
{
    public function __construct(
        public Id $employee,
        public Name $name,
    ) {
    }
}
