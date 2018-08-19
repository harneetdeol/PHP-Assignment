<?php
namespace Appointment\Form;

use Zend\Form\Form;

/**
 * AppointmentForm class extends ZendForm to manages the various form inputs as well as their validation
 */

class AppointmentForm extends Form 
{
    public function __construct($name = null) 
    {
        parent::__construct('appointment');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'firstname',
            'type' => 'text',
            'options' => [
                'label' => 'First Name',
            ],
        ]);

        $this->add([
            'name' => 'lastname',
            'type' => 'text',
            'options' => [
                'label' => 'Last Name',
            ],
        ]);

        $this->add([
            'name' => 'email',
            'type' => 'text',
            'options' => [
                'label' => 'email',
            ],
        ]);

        $this->add([
            'name' => 'phone',
            'type' => 'text',
            'options' => [
                'label' => 'Phone Number',
            ],
        ]);

        $this->add([
            'name' => 'address',
            'type' => 'text',
            'options' => [
                'label' => 'Address',
            ],
        ]);

         $this->add([
            'name' => 'reason',
            'type' => 'text',
            'options' => [
                'label' => 'Reason',
            ],
        ]);

        $this->add([
            'name' => 'startime',
            'type' => 'text',
            'options' => [
                'label' => 'StartTime',
            ],
        ]);

        $this->add([
            'name' => 'endtime',
            'type' => 'text',
            'options' => [
                'label' => 'EndTime',
            ],
        ]);
    }
}