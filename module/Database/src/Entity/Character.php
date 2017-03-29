<?php

namespace Database\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="characters")
 */
class Character {
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
     * @ORM\Column(type="string")
     */
    public $image_url;

    /**
     * @ORM\ManyToMany(targetEntity="Category")
     */
    public $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function exchangeArray(array $data)
    {
        $this->id         = !empty($data['id']) ? $data['id'] : null;
        $this->name       = !empty($data['name']) ? $data['name'] : null;
        $this->image_url  = !empty($data['image_url']) ? $data['image_url'] : null;
        $this->categories = !empty($data['categories']) ? $data['categories'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image_url' => $this->image_url,
            'categories' => $this->categories,
        ];
    }
}