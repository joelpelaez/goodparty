<?php

namespace Api\Controller;

use Database\Entity\Model;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class ModelController extends AbstractRestfulController
{
    
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getList()
    {
        $data = $this->em->getRepository(Model::class)->findAll();
        return new JsonModel($data);
    }

    public function get($id)
    {
        $model = $this->em->find(Model::class, $id);
        if ($model === null)
            return new JsonModel(null);
        else
            return new JsonModel([$model]);
    }
}