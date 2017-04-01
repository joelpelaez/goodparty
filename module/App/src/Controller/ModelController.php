<?php

namespace App\Controller;

use Database\Entity\Model;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;

class ModelController extends AbstractActionController
{
    
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function indexAction()
    {
        $data = $this->em->getRepository(Model::class)->createNamedQuery("activated")->getResult();
        return ['models' => $data];
    }

    public function showAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id <= 0) 
            $this->redirect()->toRoute('app/model', 'index');

        $data = $this->em->find(Model::class, $id);

        if ($data == null)
            return $this->redirect()->toRoute('app/model');
        return ['model' => $data];
    }
}