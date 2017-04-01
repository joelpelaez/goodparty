<?php
namespace User\Service;

use Doctrine\ORM\EntityManager;
use Database\Entity\User;
use Zend\Crypt\Password\Bcrypt;

class UserManager
{
    private $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function addUser($data)
    {
        $user = new User();
        $user->username = $data['username'];
        $user->fullname = $data['fullname'];
        $user->administrator = $data['administrator'];
        
        $bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create($data['password']);
        $user->password = $passwordHash;
        
        $this->em->persist($user);
        $this->em->flush();
    }
    
    public function validatePassword(User $user, $password)
    {
        $bcrypt = new Bcrypt();
        if ($bcrypt->verify($password, $user->password)) {
            return true;
        }
        return false;
    }
}