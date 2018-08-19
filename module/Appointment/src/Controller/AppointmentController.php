<?php
namespace Appointment\Controller;

use Appointment\Form\AppointmentForm;
use Appointment\InputFilter\FormAppointmentFilter;
use Appointment\Model\AppointmentTable;
use Appointment\Model\Appointment;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 * ZF's AbstractRestfulController provides an interface for quick implementation of basic HTTP methods 
 * (e.g. GET, POST, PUT, DELETE) by using controller actions
 */

class AppointmentController extends AbstractRestfulController 
{
    //instance of AppointmentTable that allows interfacing with data in database
    private $table;

    public function __construct(AppointmentTable $table) 
    {
        $this->table = $table;
    }

    // associated with GET request without identifier
    public function getList() 
    {
        $appointments = $this->table->fetchAll();
        $data = array();

        foreach($appointments as $appointment) {
            $data[] = $appointment;
        }

        if(empty($data)){
            return $this->createResponse("success", "Appointments not found!", []);
        }

        return $this->createResponse("success", "Appointments available", $data);
    }

    // associated with GET request with identifier
    public function get($id) 
    {
        $id = (int) $id;

        $appointment = $this->table->getAppointment($id);
        
        if (!$appointment) {
            return $this->createResponse("error", "Appointment does not exist", []);
        }

        return $this->createResponse("success", "Appointments details are available", $appointment);
    }

    // associated with POST request
    public function create($data) 
    {    
        $appointment = new Appointment();
        $form = new AppointmentForm();

        //validate data using zend forms
        $form->setInputFilter($appointment->getInputFilter());
        $form->setData($data);

        if (! $form->isValid()) {
            $formErrors = $form->getMessages();
            return $this->createResponse("error", "Invalid data not added!", $formErrors);
        }

        $appointment->exchangeArray($form->getData());
        $this->table->saveAppointment($appointment);

        return $this->createResponse("success", "Appointment added successfully!", $data);
    }

    // associated with PUT request
    public function update($id, $data) 
    {
        $id = (int) $id;

        $appointment = $this->table->getAppointment($id);
        if (!$appointment) {
            return $this->createResponse("error", "Appointment does not exist", []);
        }

        $data['id'] = $id;

        $appointment = new Appointment();
        $form = new AppointmentForm();

        //validate data using zend forms
        $form->setInputFilter($appointment->getInputFilter());
        $form->setData($data);

        if (! $form->isValid()) {
            $formErrors = $form->getMessages();
            return $this->createResponse("error", "Invalid Form Data Update Failed!", $formErrors);
        }
   
        $appointment->exchangeArray($form->getData());        
        $this->table->saveAppointment($appointment);

        return $this->createResponse("success", "Appointment updated successfully!", $data);
    }

    // associated with DELETE request
    public function delete($id) 
    {    
        $id = (int) $id;

        $appointment = $this->table->getAppointment($id);
        if (!$appointment) {
            return $this->createResponse("error", "Appointment does not exist", []);
        }

        $this->table->deleteAppointment($id);

        return $this->createResponse("success", "Appointment deleted successfully!", $id);
    }

    private function createResponse($status, $message, $data)
    {
        return new JsonModel(array( array("status"=>$status, "message"=>$message, "data"=>$data)));
    }
}