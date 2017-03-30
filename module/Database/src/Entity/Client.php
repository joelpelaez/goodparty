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
     * @ORM\Column(type="string", length=20)
     */
    public $phone;
    
    /**
     * @ORM\Column(type="string", length=30)
     */
    public $email;
    
    
}