<?php
namespace Appointment;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface {

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig() {
        return [
            'factories' => [
                Model\AppointmentTable::class => function($container) {
                    $tableGateway = $container->get(Model\AppointmentTableGateway::class);
                    return new Model\AppointmentTable($tableGateway);
                },
                Model\AppointmentTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Appointment());
                    return new TableGateway('appointment', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig() {
        return [
            'factories' => [
                Controller\AppointmentController::class => function($container) {
                    return new Controller\AppointmentController(
                        $container->get(Model\AppointmentTable::class)
                    );
                },
            ],
        ];
    }

}