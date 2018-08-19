<?php
namespace AppointmentTest\Model;

use Appointment\Model\Appointment;
use PHPUnit_Framework_TestCase as TestCase;

class AppointmentTest extends TestCase
{
    public function testInitialAppointmentValuesAreNull()
    {
        $appointment = new Appointment();

        $this->assertNull($appointment->id, '"id" should be null by default');
        $this->assertNull($appointment->firstname, '"firstname" should be null by default');
        $this->assertNull($appointment->lastname, '"lastname" should be null by default');
        $this->assertNull($appointment->email, '"email" should be null by default');
        $this->assertNull($appointment->phone, '"phoneno" should be null by default');
        $this->assertNull($appointment->address, '"address" should be null by default');
        $this->assertNull($appointment->reason, '"reason" should be null by default');
        $this->assertNull($appointment->starttime, '"starttime" should be null by default');
        $this->assertNull($appointment->endtime, '"endtime" should be null by default');
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $appointment = new Appointment();
        $data  = [
            'id'     => 123,
            'firstname' => 'jennifer',
            'lastname'  => 'chen',
            'email'  => 'jenchen87@gmail.com',
            'phone'  => '16041234567',
            'address'  => '14056 45a ave surrey bc',
            'reason' => 'thyroid issues',
            'starttime'  => '2018-08-15 10:00:00',
            'endtime'  => '2018-08-15 11:00:00'
        ];

        $appointment->exchangeArray($data);

        $this->assertSame($data['id'], $appointment->id, '"id" was not set correctly');
        $this->assertSame($data['firstname'], $appointment->firstname, '"firstname" was not set correctly');
        $this->assertSame($data['lastname'], $appointment->lastname, '"lastname" was not set correctly');
        $this->assertSame($data['email'], $appointment->email, '"email" was not set correctly');
        $this->assertSame($data['phone'], $appointment->phone, '"phone" was not set correctly');
        $this->assertSame($data['address'], $appointment->address, '"address" was not set correctly');
        $this->assertSame($data['reason'], $appointment->reason, '"reason" was not set correctly');
        $this->assertSame($data['starttime'], $appointment->starttime, '"starttime" was not set correctly');
        $this->assertSame($data['endtime'], $appointment->endtime, '"endtime" was not set correctly');
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $appointment = new Appointment();

        $appointment->exchangeArray([
            'id'     => 123,
            'firstname' => 'harneet',
            'lastname'  => 'deol',
            'email'  => 'hkdeol87@gmail.com',
            'phone'  => '16041234567',
            'address'  => '15678 89a ave surrey bc',
            'reason'  => 'throat infection',
            'starttime'  => '2018-08-15 10:00:00',
            'endtime'  => '2018-08-15 11:00:00'
        ]);

        $appointment->exchangeArray([]);

        $this->assertNull($appointment->id, '"id" should default to null');
        $this->assertNull($appointment->firstname, '"firstname" should default to null');
        $this->assertNull($appointment->lastname, '"lastname" should default to null');
        $this->assertNull($appointment->email, '"email" should default to null');
        $this->assertNull($appointment->phone, '"phone" should default to null');
        $this->assertNull($appointment->address, '"address" should default to null');
        $this->assertNull($appointment->reason, '"reason" should default to null');
        $this->assertNull($appointment->starttime, '"starttime" should default to null');
        $this->assertNull($appointment->endtime, '"endtime" should default to null');
    }

    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
          $appointment = new Appointment();
          $data  = [
            'id'     => 123,
            'firstname' => 'harneet',
            'lastname'  => 'deol',
            'email'  => 'hkdeol87@gmail.com',
            'phone'  => '16041234567',
            'address'  => '15678 89a ave surrey bc',
            'reason'  => 'throat infection',
            'starttime'  => '2018-08-15 10:00:00',
            'endtime'  => '2018-08-15 11:00:00'
        ];

        $appointment->exchangeArray($data);
        $copyArray = $appointment->getArrayCopy();

        $this->assertSame($data['id'], $copyArray['id'], '"id" was not set correctly');
        $this->assertSame($data['firstname'], $copyArray['firstname'], '"firstname" was not set correctly');
        $this->assertSame($data['lastname'], $copyArray['lastname'], '"lastname" was not set correctly');
        $this->assertSame($data['email'], $copyArray['email'], '"email" was not set correctly');
        $this->assertSame($data['phone'], $copyArray['phone'], '"phone" was not set correctly');
        $this->assertSame($data['address'], $copyArray['address'], '"address" was not set correctly');
        $this->assertSame($data['reason'], $copyArray['reason'], '"reason" was not set correctly');
        $this->assertSame($data['starttime'], $copyArray['starttime'], '"starttime" was not set correctly');
        $this->assertSame($data['endtime'], $copyArray['endtime'], '"endtime" was not set correctly');
    }

    public function testInputFiltersAreSetCorrectly()
    {
        $appointment = new Appointment();

        $inputFilter = $appointment->getInputFilter();

        $this->assertSame(9, $inputFilter->count());
        $this->assertTrue($inputFilter->has('firstname'));
        $this->assertTrue($inputFilter->has('lastname'));
        $this->assertTrue($inputFilter->has('email'));
        $this->assertTrue($inputFilter->has('phone'));
        $this->assertTrue($inputFilter->has('address'));
        $this->assertTrue($inputFilter->has('reason'));
        $this->assertTrue($inputFilter->has('starttime'));
        $this->assertTrue($inputFilter->has('endtime'));
    }
}
