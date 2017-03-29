<?php

namespace Api\Controller;

use Database\Entity\Character;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class CharacterController extends AbstractRestfulController
{
    
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getList()
    {
        $data = $this->em->getRepository(Character::class)->findAll();
        return new JsonModel($data);
    }

    public function get($id)
    {
        $model = $this->em->find(Character::class, $id);
        if ($model === null)
            return new JsonModel(null);
        else
            return new JsonModel([$model]);
    }
}