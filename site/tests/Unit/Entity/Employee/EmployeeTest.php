<?php

namespace Isibia\Tests\Unit\Entity\Employee;

use Isibia\Carpark\Entity\Employee\Address;
use PHPUnit\Framework\TestCase;
use Isibia\Carpark\Entity\Employee\Employee;
use Isibia\Carpark\Entity\Employee\Events\EmployeeCreated;
use Isibia\Carpark\Entity\Employee\Id;
use Isibia\Carpark\Entity\Employee\Name;
use Isibia\Carpark\Entity\Employee\Phone;
use Isibia\Carpark\Entity\Employee\Phones;

class EmployeeTest extends TestCase
{
    public function testCreateNewEmployeeSuccess(): void
    {
        $id = Id::next();
        $name = new Name(
            first: 'Artem',
            middle: 'Vladimirovitch',
            last: 'Anoshin',
        );
        $address = new Address(
            country: 'Russia',
            region: 'Saratovskaya oblast',
            city: 'Balakovo',
            street: 'Lenina',
            house: '50',
            appartment: '25',
        );
        $phones = new Phones(
            [
                new Phone(
                    country: '+7',
                    code: '958',
                    number: '965 87 45',
                ),
                new Phone(
                    country: '+7',
                    code: '937',
                    number: '974 64 02',
                ),
            ],
        );
        $createdDate = new \DateTimeImmutable();

        $employee = new Employee(
            id: $id,
            name: $name,
            address: $address,
            phones: $phones,
            createDate: $createdDate,
        );

        $statuses = $employee->getStatuses();
        $events = $employee->releaseEvents();

        $this->assertEquals($id, $employee->getId());
        $this->assertEquals($name, $employee->getName());
        $this->assertEquals($address, $employee->getAddress());
        $this->assertEquals($phones->getAll(), $employee->getPhones());
        $this->assertEquals($createdDate, $employee->getCreateDate());

        $this->assertNotNull($employee->getCreateDate());
        $this->assertTrue($employee->isActive());
        $this->assertCount(1, $statuses);
        $this->assertTrue(end($statuses)->isActive());

        $this->assertNotEmpty($events);
        $this->assertInstanceOf(EmployeeCreated::class, end($events));
    }

    public function testCreateNewUserWithoutPhone()
    {
        $this->expectExceptionMessage('Employee must contain at least one phone.');

        new Phones(
            [],
        );
    }

    public function testCreateNewUserWithTheSamePhones()
    {
        $this->expectExceptionMessage('Phone already exists.');

        new Phones(
            [
                new Phone(
                    country: '+7',
                    code: '958',
                    number: '965 87 45',
                ),
                new Phone(
                    country: '+7',
                    code: '958',
                    number: '965 87 45',
                ),
            ],
        );
    }
}
