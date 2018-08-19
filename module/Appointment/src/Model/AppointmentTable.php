<?php
namespace Appointment\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * AppointmentTable class consumes a Zend\Db\TableGateway\TableGateway providing implementation of 
 * Table Data Gateway design pattern to allow for interfacing with data in a database table
 */

class AppointmentTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway) 
    {
        $this->tableGateway = $tableGateway;
    }

    //retrieves all appointment rows from the database
    public function fetchAll() 
    {
        return $this->tableGateway->select();
    }

    //retrieves a single row as an Appointment object
    public function getAppointment($id) 
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        return $row;
    }
    
    //either creates a new row in the database or updates a row that already exists
    public function saveAppointment(Appointment $appointment) 
    {
        $data = [
            'firstname' => $appointment->firstname,
            'lastname'  => $appointment->lastname,
            'email'     => $appointment->email,
            'phone'     => $appointment->phone,
            'address'   => $appointment->address,
            'reason'    => $appointment->reason,
            'starttime' => $appointment->starttime,
            'endtime'   => $appointment->endtime,
        ];

        $id = (int) $appointment->id;

        if ($id == 0) {
            $this->tableGateway->insert($data);
            //$id = $this->tableGateway->getLastInsertValue();
        } else {
            if ($this->getAppointment($id)) {
                $this->tableGateway->update($data, ['id' => $id]);
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
        return $id;   
    }

    //removes the row from database
    public function deleteAppointment($id) 
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
