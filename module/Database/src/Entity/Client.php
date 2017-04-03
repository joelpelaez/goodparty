<?php

namespace Database\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="clients")
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    public $id;
    
    /**
     * @ORM\Column(type="string", length=40)
     */
    public $firstname;
    
    /**
     * @ORM\Column(type="string", length=40)
     */
    public $lastname;
    
    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    public $phone;
    
    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    public $email;
    
    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->firstname = !empty($data['firstname']) ? $data['firstname'] : null;
        $this->lastname = !empty($data['lastname']) ? $data['lastname'] : null;
        $this->phone = !empty($data['phone']) ? $data['phone'] : null;
        $this->email = !empty($data['email']) ? $data['email'] : null;
    }
}