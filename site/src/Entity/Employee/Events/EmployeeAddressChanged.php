<?php

namespace Isibia\Carpark\Entity\Employee\Events;

use Isibia\Carpark\Entity\Employee\Id;
use Isibia\Carpark\Entity\Employee\Address;

class EmployeeAddressChanged
{
    public function __construct(
        public Id $employee,
        public Address $address,
    ) {
    }
}
