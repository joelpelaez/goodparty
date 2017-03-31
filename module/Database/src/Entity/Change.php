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
    
    public function exchangeArray(array $data)
    {
        $this->id             = !empty($data['id']) ? $data['id'] : null;
        $this->element_name   = !empty($data['element_name']) ? $data['element_change'] : null;
        $this->element_change = !empty($data['element_change']) ? $data['element_change'] : null;
    }
}