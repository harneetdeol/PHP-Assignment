<?php

namespace AppointmentTest\Model;

use Appointment\Model\AppointmentTable;
use Appointment\Model\Appointment;
use PHPUnit_Framework_TestCase as TestCase;
use RuntimeException;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\TableGateway\TableGatewayInterface;

class AppointmentTableTest extends TestCase
{
    private $appointmentData;
    protected function setUp()
    {
        $this->appointmentData  = [
            'id'        => 123,
            'firstname' => 'jennifer',
            'lastname'  => 'chen',
            'email'     => 'jenchen87@gmail.com',
            'phone'     => '16041234567',
            'address'   => '14056 45a ave surrey bc',
            'reason'    => 'thyroid issues',
            'starttime' => '2018-08-15 10:00:00',
            'endtime'   => '2018-08-15 11:00:00'
        ];

        $this->tableGateway = $this->prophesize(TableGatewayInterface::class);
        $this->appointmentTable = new AppointmentTable($this->tableGateway->reveal());
    }

    public function testFetchAllReturnsAllAppointments()
    {
        $resultSet = $this->prophesize(ResultSetInterface::class)->reveal();
        $this->tableGateway->select()->willReturn($resultSet);

        $this->assertSame($resultSet, $this->appointmentTable->fetchAll());
    }

    public function testCanRetrieveAnAppointmentByItsId()
    {
        $appointment = new Appointment();
        $appointment->exchangeArray($this->appointmentData);

        $resultSet = $this->prophesize(ResultSetInterface::class);
        $resultSet->current()->willReturn($appointment);
        $this->tableGateway->select(['id' => 123])->willReturn($resultSet->reveal());

        $this->assertSame($appointment, $this->appointmentTable->getAppointment(123));
    }

    public function testCanDeleteAnAppointmentByItsId()
    {
        $this->tableGateway->delete(['id' => 123])->shouldBeCalled();
        $this->appointmentTable->deleteAppointment(123);
    }

    public function testSaveAppointmentWillInsertNewAppointmentsIfTheyDontAlreadyHaveAnId()
    {
        $appointmentData  = [
            'firstname' => 'jennifer',
            'lastname'  => 'chen',
            'email'  => 'jenchen87@gmail.com',
            'phone'  => '16041234567',
            'address'  => '14056 45a ave surrey bc',
            'reason' => 'thyroid issues',
            'starttime'  => '2018-08-15 10:00:00',
            'endtime'  => '2018-08-15 11:00:00'
        ];
        $appointment = new Appointment();
        $appointment->exchangeArray($appointmentData);

        $this->tableGateway->insert($appointmentData)->shouldBeCalled();
        $this->appointmentTable->saveAppointment($appointment);
    }

    public function testSaveAppointmentWillUpdateExistingAppointmentsIfTheyAlreadyHaveAnId()
    {
        $appointment = new Appointment();
        $appointment->exchangeArray($this->appointmentData);

        $resultSet = $this->prophesize(ResultSetInterface::class);
        $resultSet->current()->willReturn($appointment);

        $this->tableGateway->select(['id' => 123])->willReturn($resultSet->reveal());

        $this->tableGateway
            ->update(array_filter($this->appointmentData, function ($key) {
                return in_array($key, ['firstname', 'lastname','email','phone','address','reason','starttime','endtime']);
            }, ARRAY_FILTER_USE_KEY),
            ['id' => 123]
        )->shouldBeCalled();

        $this->appointmentTable->saveAppointment($appointment);
    }
}
