<?php

namespace Api;

use Zend\Router\Http\Segment;
use Zend\Router\Http\Literal;

return [
    'router' => [
        'routes' => [
            'api' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/api',
                    'defaults' => [
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'model' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/model[/:id][/]',
                            'constraints' => [
                                'id' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\ModelController::class,
                            ],
                        ],
                    ],
                    'character' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/character[/:id][/]',
                            'constraints' => [
                                'id' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\CharacterController::class,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    // View setup for this module
    'view_manager' => [
        'template_path_stack' => [
            'api' => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];