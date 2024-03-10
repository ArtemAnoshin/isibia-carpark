<?php

namespace Isibia\Carpark\Entity\Employee\Events;

use Isibia\Carpark\Entity\Employee\Id;
use Isibia\Carpark\Entity\Employee\Phone;

class EmployeePhoneRemoved
{
    public function __construct(
        public Id $employee,
        public Phone $phone,
    ) {
    }
}