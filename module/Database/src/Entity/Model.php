<?php

namespace Database\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="models")
 * @ORM\NamedQueries({
 *     @ORM\NamedQuery(name="activated", query="SELECT u FROM __CLASS__ u WHERE u.enabled = 1") 
 * })
 */
class Model {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    public $name;

    /**
     * @ORM\Column(type="string", length=120)
     */
    public $description;

    /**
     * @ORM\Column(type="string")
     */
    public $image_url;

    /**
     * @ORM\Column(type="string")
     */
    public $model_url;

    /**
     * @ORM\Column(type="string")
     */
    public $interface_url;

    /**
     * @ORM\Column(type="boolean")
     */
    public $enabled;
    
    /**
     * Files
     */
    public $model;
    public $interface;
    
    public function exchangeArray(array $data)
    {
        $this->id          = !empty($data['id']) ? $data['id'] : null;
        $this->name        = !empty($data['name']) ? $data['name'] : null;
        $this->description = !empty($data['description']) ? $data['description'] : null;
        $this->image_url   = !empty($data['image_url']) ? $data['image_url'] : null;
        $this->enabled     = !empty($data['enabled']) ? $data['enabled'] : null;
        $this->model       = !empty($data['model']) ? $data['model'] : null;
        $this->interface   = !empty($data['interface']) ? $data['interface'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'image_url'   => $this->image_url,
            'enabled'     => $this->enabled,
            'model'       => $this->model,
            'interface'   => $this->interface,
        ];
    }

}