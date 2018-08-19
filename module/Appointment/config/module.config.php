<?php
namespace Appointment;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'appointment' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/appointment[/:id]',
                    'constraints' => [
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' =>  Controller\AppointmentController::class,
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'appointment' => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy'
        ],
    ],
];