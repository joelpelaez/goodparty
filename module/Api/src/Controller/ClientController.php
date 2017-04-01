<?php

namespace Api\Controller;

use Database\Entity\Client;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class ClientController extends AbstractRestfulController
{
    
    private $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getList()
    {
        $clients = $this->em->getRepository(Client::class)->findAll();
        return new JsonModel($clients);
    }
    
    public function get($id)
    {
        $client = $this->em->find(Client::class, $id);
        if ($client === null)
            return new JsonModel(null);
            else
                return new JsonModel([$client]);
    }
    
    public function create($data)
    {
        // Create a new client
        $client = new Client();
        $client->exchangeArray($data);
        
        $this->em->persist($client);
        $this->em->flush();
        
        return new JsonModel(['success' => true, transaction_id => $order->id]);
    }
}