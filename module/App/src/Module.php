<?php
namespace App;

use Doctrine\ORM\EntityManager;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\ModuleManager;
use User\Controller\AuthController;
use Zend\Mvc\MvcEvent;
use User\Service\AuthManager;
use Zend\Mvc\Controller\AbstractActionController;

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
                Controller\ModelController::class => function ($container) {
                    $em = $container->get(EntityManager::class);
                    return new Controller\ModelController($em);
                },
            ],
        ];
    }

    public function init(ModuleManager $manager)
    {
        $events = $manager->getEventManager();
        $sharedEvents = $events->getSharedManager();
        $sharedEvents->attach(__NAMESPACE__, 'dispatch', function ($e) {
            $controller = $e->getTarget();
            $controller->layout('layout/sales');
        }, 100);
    }
    
    /**
     * This method is called once the MVC bootstrapping is complete.
     */
    public function onBootstrap(MvcEvent $event)
    {
        // Get event manager.
        $eventManager = $event->getApplication()->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        // Register the event listener method.
        $sharedEventManager->attach(AbstractActionController::class, MvcEvent::EVENT_DISPATCH, [
            $this,
            'onDispatch'
        ], 99);
    }
    
    /**
     * Event listener method for the 'Dispatch' event.
     * We listen to the Dispatch
     * event to call the access filter. The access filter allows to determine if
     * the current visitor is allowed to see the page or not. If he/she
     * is not authorized and is not allowed to see the page, we redirect the user
     * to the login page.
     */
    public function onDispatch(MvcEvent $event)
    {
        // Get controller and action to which the HTTP request was dispatched.
        $controller = $event->getTarget();
        $controllerName = $event->getRouteMatch()->getParam('controller', null);
        $actionName = $event->getRouteMatch()->getParam('action', null);
        
        // Convert dash-style action name to camel-case.
        $actionName = str_replace('-', '', lcfirst(ucwords($actionName, '-')));
        
        // Get the instance of AuthManager service.
        $authManager = $event->getApplication()
        ->getServiceManager()
        ->get(AuthManager::class);
        
        // Execute the access filter on every controller except AuthController
        // (to avoid infinite redirect).
        if ($controllerName != AuthController::class && ! $authManager->filterAccess($controllerName, $actionName)) {
            
            // Remember the URL of the page the user tried to access. We will
            // redirect the user to that URL after successful login.
            $uri = $event->getApplication()
            ->getRequest()
            ->getUri();
            // Make the URL relative (remove scheme, user info, host name and port)
            // to avoid redirecting to other domain by a malicious user.
            $uri->setScheme(null)
            ->setHost(null)
            ->setPort(null)
            ->setUserInfo(null);
            $redirectUrl = $uri->toString();
            
            // Redirect the user to the "Login" page.
            return $controller->redirect()->toRoute('login', [], [
                'query' => [
                    'redirectUrl' => $redirectUrl
                ]
            ]);
        }
    }
}