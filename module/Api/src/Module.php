<?php

namespace Api;

use Doctrine\ORM\EntityManager;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ModelController::class => function($container) {
                    $em = $container->get(EntityManager::class);
                    return new Controller\ModelController($em);
                },
                Controller\CharacterController::class => function($container) {
                    $em = $container->get(EntityManager::class);
                    return new Controller\CharacterController($em);
                },
            ]
        ];
    }
}