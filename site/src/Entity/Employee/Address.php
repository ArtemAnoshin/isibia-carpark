<?php

namespace Isibia\Carpark\Entity\Employee;

use Assert\Assertion;

class Address
{
    public function __construct(
        private string $country,
        private string $region,
        private string $city,
        private string $street,
        private string $house,
        private ?string $appartment,
    ) {
        Assertion::notEmpty($country);
        Assertion::notEmpty($region);
        Assertion::notEmpty($city);
        Assertion::notEmpty($street);
        Assertion::notEmpty($house);
    }

    public function getCountry(): string { return $this->country; }
    public function getRegion(): string { return $this->region; }
    public function getCity(): string { return $this->city; }
    public function getStreet(): string { return $this->street; }
    public function getHouse(): string { return $this->house; }
    public function getAppartment(): ?string { return $this->appartment; }
}
