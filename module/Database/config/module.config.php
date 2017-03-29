<?php

return [
    'doctrine' => [
        'driver' => [
            'my_annotation_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity'],
            ],
            'orm_default' => [
                'drivers' => [
                    'Database\Entity' => 'my_annotation_driver',
                ],
            ],
        ],
    ]
];