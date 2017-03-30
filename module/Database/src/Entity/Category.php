<?php

namespace Database\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="categories")
 */
class Category {
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

    public function exchangeArray(array $data)
    {
        $this->id          = !empty($data['id']) ? $data['id'] : null;
        $this->name        = !empty($data['name']) ? $data['name'] : null;
        $this->description = !empty($data['description']) ? $data['description'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
        ];
    }
}