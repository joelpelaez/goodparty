<?php

namespace Admin;

use Doctrine\ORM\EntityManager;
use Zend\Session\SessionManager;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;
use User\Service\UserManager;

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
                Controller\UserController::class => function($container) {
                    $em = $container->get(EntityManager::class);
                    $um = $container->get(UserManager::class);
                    return new Controller\UserController($em, $um);
                },
            ],
        ];
    }
    
    /**
     * This method is called once the MVC bootstrapping is complete.
     */
    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $serviceManager = $application->getServiceManager();
        
        // The following line instantiates the SessionManager and automatically
        // makes the SessionManager the 'default' one.
        $sessionManager = $serviceManager->get(SessionManager::class);
    }

    public function init(ModuleManager $manager)
    {
        $events = $manager->getEventManager();
        $sharedEvents = $events->getSharedManager();
        $sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) {
            $controller = $e->getTarget();
            $controller->layout('layout/admin');
        }, 100);
    }
}