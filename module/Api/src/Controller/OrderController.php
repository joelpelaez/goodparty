<?php

namespace Api\Controller;

use Database\Entity\Change;
use Database\Entity\Client;
use Database\Entity\Model;
use Database\Entity\Order;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class OrderController extends AbstractRestfulController
{
    
    private $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getList()
    {
        $data = $this->em->getRepository(Order::class)->findAll();
        return new JsonModel($data);
    }
    
    public function get($id)
    {
        $model = $this->em->find(Order::class, $id);
        if ($model === null)
            return new JsonModel(null);
            else
                return new JsonModel([$model]);
    }
    
    public function create($data)
    {
        // First create the new order;
        $order = new Order();
        $order->order_date = date_create($data['order_date']);
        
        if (!empty($data['client_id'])) {
            // Check if exists the specified client.
            $client = $this->em->find(Client::class, (int) $data['client_id']);
            if (is_null($client)) {
                return new JsonModel(['success' => false, 'reason' => 'bad_client']);
            }
            $order->client = $client;
        } else if (!empty($data['client'])) {
            // Create a new client
            $client_data = $data['client'];
            $client = new Client();
            $client->exchangeArray($client_data);
            $this->em->persist($client);
            $order->client = $client;
        } else {
            return new JsonModel(['success' => false, 'reason' => 'non_client']);
        }
        
        if (!empty($data['model_id'])) {
            // add existent model
            $model = $this->em->find(Model::class, (int) $data['model_id']);
            if (is_null($model)) {
                return new JsonModel(['success' => false, 'reason' => 'bad_model']);
            }
            $order->model = $model;
        } else {
            return new JsonModel(['success' => false, 'reason' => 'non_model']);
        }
        
        if (!empty($data['changes']) && is_array($data['changes'])) {
            $data_changes = $data['changes'];
            foreach ($data_changes as $dc) {
                $change = new Change();
                $change->exchangeArray($dc);
                $this->em->persist($change);
                $order->changes->add($change);
            }
        } else {
            return new JsonModel(['success' => false, 'reason' => 'bad_changes']);
        }
        
        $this->em->persist($order);
        $this->em->flush();
        return new JsonModel(['success' => true, transaction_id => $order->id]);
    }
}