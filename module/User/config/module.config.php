<?php

namespace User;

use Zend\Router\Http\Literal;

return [
    'router' => [
        'routes' => [
            'login' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/login',
                    'constraints' => [
                    ],
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action' => 'login',
                    ]
                ],
            ],
            'logout' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/logout',
                    'constraints' => [
                    ],
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action' => 'logout',
                    ]
                ],
            ],
        ]
    ],
    'access_filter' => [
        'options' => [
            'mode' => 'restrictive',
        ],
        'controllers' => [
            \Admin\Controller\ModelController::class => [
                ['actions' => '*', 'allow' => '!'],
            ],
            \App\Controller\ModelController::class => [
                ['actions' => '*', 'allow' => '@'],
            ],
            \Api\Controller\CharacterController::class => [
                ['actions' => '*', 'allow' => '@'],
            ],
            \Api\Controller\ClientController::class => [
                ['actions' => '*', 'allow' => '@'],
            ],
            \Api\Controller\ModelController::class => [
                ['actions' => '*', 'allow' => '@'],
            ],
            \Api\Controller\OrderController::class => [
                ['actions' => '*', 'allow' => '@'],
            ]
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];