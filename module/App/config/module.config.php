<?php

namespace App;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'model' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/model[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ModelController::class,
                        'action' => 'index',
                    ]
                ],
            ],
            'order' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/order[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\OrderController::class,
                        'action' => 'index',
                    ]
                ],
            ],
        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'template_map' => [
            'layout/sales'           => __DIR__ . '/../view/layout/sales.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];