<?php
namespace User;

use Doctrine\ORM\EntityManager;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Session\SessionManager;

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
                Controller\AuthController::class => function ($container) {
                    $entityManager = $container->get(EntityManager::class);
                    $authService = $container->get(AuthenticationService::class);
                    $authManager = $container->get(Service\AuthManager::class);
                    $userManager = $container->get(Service\UserManager::class);
                    return new Controller\AuthController($entityManager, $authManager, $authService, $userManager);
                }
            ]
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Service\AuthAdapter::class => function ($container) {
                    $entityManager = $container->get(EntityManager::class);
                    return new Service\AuthAdapter($entityManager);
                },
                Service\AuthManager::class => function ($container) {
                    $authService = $container->get(AuthenticationService::class);
                    $sessionManager = $container->get(SessionManager::class);
                    // Get contents of 'access_filter' config key (the AuthManager service
                    // will use this data to determine whether to allow currently logged in user
                    // to execute the controller action or not.
                    $config = $container->get('Config');
                    if (isset($config['access_filter']))
                        $config = $config['access_filter'];
                    else
                        $config = [];
                    return new Service\AuthManager($authService, $sessionManager, $config);
                },
                Service\UserManager::class => function ($container) {
                    $em = $container->get(EntityManager::class);
                    return new Service\UserManager($em);
                }
            ]
        ];
    }
}