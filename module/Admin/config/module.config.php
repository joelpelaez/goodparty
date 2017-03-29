<?php

namespace Admin;

use Zend\Router\Http\Segment;
use Zend\Router\Http\Literal;

return [
    'router' => [
        'routes' => [
            'admin' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/admin',
                    'constraints' => [
                    ],
                    'defaults' => [
                    ]
                ],
                'child_routes' => [
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
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'admin' => __DIR__ . '/../view',
        ]
    ],
];