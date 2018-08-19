<?php

namespace AppointmentTest\Controller;

use Appointment\Controller\AppointmentController;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Appointment\Model\AppointmentTable;
use Zend\ServiceManager\ServiceManager;
use Appointment\Model\Appointment;
use Prophecy\Argument;
use Appointment\Form\AppointmentForm;
use Appointment\InputFilter\FormAppointmentFilter;

class AppointmentControllerTest extends AbstractHttpControllerTestCase
{
    //set to true to throw MVC exceptions during test execution
    protected $traceError = true;
    protected $appointmentTable; 
    private $id;
    private $firstname;
    private $lastname;
    private $email;
    private $phone;
    private $address;
    private $reason;
    private $starttime;
    private $endtime;

    public function setUp()
    {
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            // full application configuration:
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));
        parent::setUp();

        $this->configureServiceManager($this->getApplicationServiceLocator());
        $this->populateFormFieldsWithDefaultValues();
    }
    
    private function populateFormFieldsWithDefaultValues()
    {
        $this->id = 123;
        $this->firstname = "jennifer";
        $this->lastname = "chen";
        $this->email = "jenchen87@gmail.com";
        $this->phone = "1234567890";
        $this->address = "12345 abc ave surrey";
        $this->reason = "thyroid issues";
        $this->starttime = "2018-09-18 10:00:00";
        $this->endtime = "2018-09-18 10:30:00";
    } 

    protected function configureServiceManager(ServiceManager $services)
    {
        $services->setAllowOverride(true);

        $services->setService('config', $this->updateConfig($services->get('config')));
        $services->setService(AppointmentTable::class, $this->mockAppointmentTable()->reveal());

        $services->setAllowOverride(false);
    }

    protected function updateConfig($config)
    {
        $config['db'] = [];
        return $config;
    }

    protected function mockAppointmentTable()
    {
        $this->appointmentTable = $this->prophesize(AppointmentTable::class);
        return $this->appointmentTable;
    }

    public function testGetListCanBeAccessed()
    {
        $this->appointmentTable->fetchAll()->willReturn([]);

        $this->dispatch('/appointment');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Appointment');
        $this->assertControllerName(AppointmentController::class);
        $this->assertControllerClass('AppointmentController');
        $this->assertMatchedRouteName('appointment');
    }

    public function testGetCanBeAccessed()
    {
        $this->dispatch('/', 'GET', array('id' => '1'));
        $a = $this->getResponse();
        
        $this->assertResponseStatusCode(200);
    }

    public function testCreateCanBeAccessedWithCorrectPath()
    { 
        $postData  = [
            'firstname' => 'jennifer',
            'lastname'  => 'chen',
            'email'  => 'jenchen87@gmail.com',
            'phone'  => '16041234567',
            'address'  => '14056 45a ave surrey bc',
            'reason' => 'thyroid issues',
            'starttime'  => '2018-08-15 10:00:00',
            'endtime'  => '2018-08-15 11:00:00'
        ];
         
        $this->dispatch('/', 'POST', $postData);
         
        $this->assertResponseStatusCode(200);
    }

    public function testUpdateCanBeAccessed()
    { 
        $putData  = [
            'id'        => 123,
            'firstname' => 'jennifer',
            'lastname'  => 'chen',
        ];

        $this->dispatch('/', 'PUT', $putData);
        $this->assertResponseStatusCode(200);
    }
 
    public function testDeleteCanBeAccessed()
    {
        $this->dispatch('/', 'DELETE', array('id' => '1'));
        $this->assertResponseStatusCode(200);
    }

    public function testGetFilterWorksForHappyPath()
    {
        $data  = $this->getDataForForm();

        $valid = $this->setFormData($data);

        $this->assertTrue($valid);
    }
    
    public function testGetFilterWorksForIncorrectEmail()
    {
        $this->email = "jennifer87@@gmail.com";
        $data  = $this->getDataForForm();

        $valid = $this->setFormData($data);

        $this->assertFalse($valid);
    }

    public function testGetFilterWorksForIncorrectPhone()
    {
        $this->phone = "12345ggg";
        $data  = $this->getDataForForm();

        $valid = $this->setFormData($data);

        $this->assertFalse($valid);
    }
    
    public function testGetFilterWorksForNullFirstname()
    {
        $this->firstname = null;
        $data  = $this->getDataForForm();

        $valid = $this->setFormData($data);

        $this->assertFalse($valid);
    }

    public function testGetFilterWorksForNullLastname()
    {
        $this->lastname = null;
        $data  = $this->getDataForForm();

        $valid = $this->setFormData($data);

        $this->assertFalse($valid);
    }

    public function testGetFilterWorksForNullEmail()
    {
        $this->email = null;
        $data  = $this->getDataForForm();

        $valid = $this->setFormData($data);

        $this->assertFalse($valid);
    }

    public function testGetFilterWorksForNullPhone()
    {
        $this->phone = null;
        $data  = $this->getDataForForm();

        $valid = $this->setFormData($data);

        $this->assertFalse($valid);
    }

    public function testGetFilterWorksForNullAddress()
    {
        $this->address = null;
        $data  = $this->getDataForForm();

        $valid = $this->setFormData($data);

        $this->assertFalse($valid);
    }

    public function testGetFilterWorksForNullReason()
    {
        $this->reason = null;
        $data  = $this->getDataForForm();

        $valid = $this->setFormData($data);

        $this->assertFalse($valid);
    }

    public function testGetFilterWorksForNullStarttime()
    {
        $this->starttime = null;
        $data  = $this->getDataForForm();

        $valid = $this->setFormData($data);

        $this->assertFalse($valid);
    }

    public function testGetFilterWorksForNullEndtime()
    {
        $this->endtime = null;
        $data  = $this->getDataForForm();

        $valid = $this->setFormData($data);

        $this->assertFalse($valid);
    }

    private function getDataForForm()
    {
        $data  = [
            'id'     => $this->id,
            'firstname' => $this->firstname,
            'lastname'  => $this->lastname,
            'email'  => $this->email,
            'phone'  => $this->phone,
            'address'  => $this->address,
            'reason' => $this->reason,
            'starttime'  => $this->starttime,
            'endtime'  => $this->endtime,
        ];
        return $data;
    }

    private function setFormData($data)
    {
        $appointment = new Appointment();
        $appointment->exchangeArray($data);

        $form = new AppointmentForm();
        $form->setInputFilter($appointment->getInputFilter());
        $form->setData($data);

        return $form->isValid();
    }
}

