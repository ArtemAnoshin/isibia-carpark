<?php

namespace Isibia\Carpark\Entity\Employee;

use Isibia\Carpark\Entity\EventTrait;
use Isibia\Carpark\Entity\RealiseEventsInterface;
use Isibia\Carpark\Entity\Employee\Id;
use Isibia\Carpark\Entity\Employee\Name;
use Isibia\Carpark\Entity\Employee\Address;
use Isibia\Carpark\Entity\Employee\Phones;
use Isibia\Carpark\Entity\Employee\Status;
use Isibia\Carpark\Entity\Employee\Events;

class Employee implements RealiseEventsInterface
{
    use EventTrait;

    /**
     * @var Status[]
     */
    private $statuses = [];

    public function __construct(
        private Id $id,
        private Name $name,
        private Address $address,
        private Phones $phones,
        private \DateTimeImmutable $createDate
    ) {
        $this->addStatus(Status::ACTIVE, $createDate);
        $this->recordEvent(new Events\EmployeeCreated($this->id));
    }

    public function rename(Name $name): void
    {
        $this->name = $name;
        $this->recordEvent(new Events\EmployeeRenamed($this->id, $name));
    }

    public function changeAddress(Address $address): void
    {
        $this->address = $address;
        $this->recordEvent(new Events\EmployeeAddressChanged($this->id, $address));
    }

    public function addPhone(Phone $phone): void
    {
        $this->phones->add($phone);
        $this->recordEvent(new Events\EmployeePhoneAdded($this->id, $phone));
    }

    public function removePhone($index): void
    {
        $phone = $this->phones->remove($index);
        $this->recordEvent(new Events\EmployeePhoneRemoved($this->id, $phone));
    }

    public function archive(\DateTimeImmutable $date): void
    {
        if ($this->isArchived()) {
            throw new \DomainException('Employee is already archived.');
        }

        $this->addStatus(Status::ARCHIVED, $date);
        $this->recordEvent(new Events\EmployeeArchived($this->id, $date));
    }

    public function reinstate(\DateTimeImmutable $date): void
    {
        if (!$this->isArchived()) {
            throw new \DomainException('Employee is not archived.');
        }

        $this->addStatus(Status::ACTIVE, $date);
        $this->recordEvent(new Events\EmployeeReinstated($this->id, $date));
    }

    public function remove(): void
    {
        if (!$this->isArchived()) {
            throw new \DomainException('Cannot remove active employee.');
        }

        $this->recordEvent(new Events\EmployeeRemoved($this->id));
    }

    public function isActive(): bool
    {
        return $this->getCurrentStatus()->isActive();
    }

    public function isArchived(): bool
    {
        return $this->getCurrentStatus()->isArchived();
    }

    private function getCurrentStatus(): Status
    {
        return end($this->statuses);
    }

    private function addStatus($value, \DateTimeImmutable $date): void
    {
        $this->statuses[] = new Status($value, $date);
    }

    public function getId(): Id { return $this->id; }
    public function getName(): Name { return $this->name; }
    public function getPhones(): array { return $this->phones->getAll(); }
    public function getAddress(): Address { return $this->address; }
    public function getCreateDate(): \DateTimeImmutable { return $this->createDate; }
    public function getStatuses(): array { return $this->statuses; }
}
