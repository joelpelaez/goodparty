<?php
namespace User\Service;

use Zend\Authentication\Result;

class AuthManager
{
    private $authService;
    private $sessionManager;
    
    public function __construct($authService, $sessionManager)
    {
        $this->authService = $authService;
        $this->sessionManager = $sessionManager;
    }
    
    /**
     * Performs a login attempt. If $rememberMe argument is true, it forces the session
     * to last for one month (otherwise the session expires on one hour).
     */
    public function login($username, $password, $rememberMe)
    {
        // Check if user has already logged in. If so, do not allow to log in
        // twice.
        if ($this->authService->getIdentity()!=null) {
            throw new \Exception('Already logged in');
        }
        
        // Authenticate with login/password.
        $authAdapter = $this->authService->getAdapter();
        $authAdapter->setUsername($username);
        $authAdapter->setPassword($password);
        $result = $this->authService->authenticate();
        
        // If user wants to "remember him", we will make session to expire in
        // one month. By default session expires in 1 hour (as specified in our
        // config/global.php file).
            if ($result->getCode()==Result::SUCCESS && $rememberMe) {
                // Session cookie will expire in 1 month (30 days).
                $this->sessionManager->rememberMe(60*60*24*30);
            }
            
            return $result;
    }
    
    /**
     * Performs user logout.
     */
    public function logout()
    {
        // Allow to log out only when user is logged in.
        if ($this->authService->getIdentity()==null) {
            throw new \Exception('The user is not logged in');
        }
        
        // Remove identity from session.
        $this->authService->clearIdentity();
    }
}