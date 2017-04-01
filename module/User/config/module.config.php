<?php

namespace User;

use Zend\Router\Http\Segment;
use Zend\Router\Http\Literal;

return [
    'router' => [
        'routes' => [
            'user' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/user',
                    'constraints' => [
                    ],
                    'defaults' => [
                    ]
                ],
                'child_routes' => [
                    'auth' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route' => '/auth[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\AuthController::class,
                                'action' => 'login',
                            ],
                        ],
                    ],
                ],
            ],
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];