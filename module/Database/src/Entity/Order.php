<?php

namespace Database\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="date")
     */
    public $order_date;
    
    /**
     * @ORM\ManyToOne(targetEntity="Client")
     */
    public $client;

    /**
     * @ORM\ManyToOne(targetEntity="Model")
     */
    public $model;
    
    /**
     * @ORM\ManyToMany(targetEntity="Change")
     */
    public $changes;
    
    public function __construct()
    {
        $this->changes = new ArrayCollection();
    }
    
    public function exchangeArray(array $data)
    {
        $this->id         = !empty($data['id']) ? $data['id'] : null;
        $this->order_date = !empty($data['order_date']) ? $data['model'] : null;
        $this->client     = !empty($data['client']) ? $data['client'] : null;
        $this->model      = !empty($data['model']) ? $data['model'] : null;
        $this->changes    = !empty($data['changes']) ? $data['changes'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id'         => $this->id,
            'order_date' => $this->order_date,
            'client' 	 => $this->client,
            'model'   	 => $this->model,
            'changes'    => $this->changes,
        ];
    }

}