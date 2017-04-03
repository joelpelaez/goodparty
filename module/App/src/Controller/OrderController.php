<?php
namespace App\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;
use Database\Entity\Order;

class OrderController extends AbstractActionController
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function indexAction()
    {
        $orders = $this->em->getRepository(Order::class)->createNamedQuery("list")->execute();
        
        return [
            'orders' => $orders
        ];
    }

    public function showAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if ($id <= 0) {
            return $this->redirect()->toRoute('order', [
                'action' => 'index'
            ]);
        }
        
        $order = $this->em->find(Order::class, $id);
        
        if (is_null($order))
            return $this->redirect()->toRoute('order', [
                'action' => 'index'
            ]);
        
        return ['order' => $order];
    }
}