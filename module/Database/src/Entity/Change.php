<?php 

namespace Database\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="changes")
 */
class Change
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    public $id;
    
    /**
     * @ORM\Column(type="string")
     */
    public $element_name;
    
    /**
     * @ORM\Column(type="string")
     */
    public $element_change;
}