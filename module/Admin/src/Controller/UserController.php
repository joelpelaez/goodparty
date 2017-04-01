<?php

namespace Admin\Controller;

use Admin\Form\UserForm;
use User\Service\UserManager;
use Database\Entity\User;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Item Controller class.
 *
 * This class manage all events in items, including add, edit, delete and show them.
 *
 * @since First version
 */
class UserController extends AbstractActionController
{
    private $em;
    private $um;
    
    public function __construct(EntityManager $em, UserManager $um)
    {
        $this->em = $em;
        $this->um = $um;
    }
    
    public function indexAction()
    {
        $list = $this->em->getRepository(User::class)->findAll();
        return ['users' => $list];
    }
    
    public function showAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id <= 0)
            $this->redirect()->toRoute('admin/user', 'index');
            
            $data = $this->em->find(User::class, $id);
            
            if ($data == null)
                return $this->redirect()->toRoute('admin/user');
            return ['user' => $data];
    }
    
    public function addAction()
    {
        // Initialize a new Form and change the submit button
        // and set the categories to select's options.
        $form = new UserForm();
        $form->get('submit')->setValue('Add');
        
        // Check the request.
        $request = $this->getRequest();
        
        // Return a the form if it's GET request.
        if (!$request->isPost()) {
            return ['form' => $form];
        }
        
        $form->setInputFilter($form->getInputFilter());
        
        // Set the request data to the Form for validation.
        $form->setData($request->getPost());
        
        // If the form data isn't valid, return to the add view with errors.
        if (!$form->isValid()) {
            return ['form' => $form];
        }
        
        // Apply change to $items using
        $this->um->addUser($form->getData());
        
        return $this->redirect()->toRoute('admin/user');
    }
    
    public function editAction()
    {
        // Get the id param.
        $id = (int) $this->params()->fromRoute('id', 0);
        
        // If it's not gotten, add a new item.
        if ($id === 0) {
            return $this->redirect()->toRoute('admin/user', ['action' => 'add']);
        }
        
        // Get the item
        $user = $this->em->find(User::class, $id);
        
        if (is_null($user)) {
            return $this->redirect()->toRoute('admin/user', ['action' => 'index']);
        }
        
        // Initialize a new Form and change the submit button
        // and set the categories to select's options.
        $form = new UserForm();
        $form->get('submit')->setValue('Edit');
        
        // Check the request.
        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];
        
        // Return a the form if it's GET request.
        if (!$request->isPost()) {
            return $viewData;
        }
        
        $filter = $form->getInputFilter();
        $filter->get('password')->setRequired(false);
        $form->setInputFilter($filter);
        
        $post = $request->getPost();
        
        // Set the request data to the Form for validation.
        $form->setData($post);
        
        // If the form data isn't valid, return to the add view with errors.
        if (!$form->isValid()) {
            return $viewData;
        }
        
        $this->um->editUser($form->getData());
        return $this->redirect()->toRoute('admin/model');
    }
    
}