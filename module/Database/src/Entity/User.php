<?php

namespace Database\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users", uniqueConstraints={
 * @ORM\UniqueConstraint(name="unique_user", columns={"username"})
 * })
 */
class User {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    public $id;
    
    /**
     * @ORM\Column(type="string", length=128)
     */
    public $username;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    public $fullname;
    
    /**
     * @ORM\Column(type="string", length=128)
     */
    public $password;
    
    /**
     * @ORM\Column(type="boolean")
     */
    public $administrator;
    
    public function exchangeArray(array $data)
    {
        $this->id       = !empty($data['id']) ? $data['id'] : null;
        $this->username = !empty($data['username']) ? $data['username'] : null;
        $this->fullname = !empty($data['fullname']) ? $data['fullname'] : null;
        $this->password = !empty($data['password']) ? $data['password'] : null;
    }
    
    public function getArrayCopy()
    {
        return [
            'id'       => $this->id,
            'username' => $this->username,
            'fullname' => $this->fullname,
            'password' => $this->password,
        ];
    }
}