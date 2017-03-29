<?php

namespace Admin\Controller;

use Admin\Form\ModelForm;
use Database\Entity\Model;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Item Controller class.
 *
 * This class manage all events in items, including add, edit, delete and show them.
 *
 * @since First version
 */
class ModelController extends AbstractActionController
{
    public $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function indexAction()
    {
        $list = $this->em->getRepository(Model::class)->findAll();
        return ['models' => $list];
    }

    public function showAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id <= 0) 
            $this->redirect()->toRoute('admin/model', 'index');

        $data = $this->em->find(Model::class, $id);

        if ($data == null)
            return $this->redirect()->toRoute('admin/model');
        return ['model' => $data];
    }

    public function addAction()
    {
        // Initialize a new Form and change the submit button
        // and set the categories to select's options.
        $form = new ModelForm();
        $form->get('submit')->setValue('Add');

        // Check the request.
        $request = $this->getRequest();

        // Return a the form if it's GET request.
        if (!$request->isPost()) {
            return ['form' => $form];
        }

        // Create a new Item object and use its InputFilter.
        $model = new Model();
        $form->setInputFilter($form->getInputFilter());

        // Merge POST and FILES arrays.
        $post = array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
        
        // Set the request data to the Form for validation.
        $form->setData($post);

        // If the form data isn't valid, return to the add view with errors.
        if (!$form->isValid()) {
            return ['form' => $form];
        }

        // Apply change to $items using 
        $model->exchangeArray($form->getData());
        $model->model_url = basename($model->model['tmp_name']);
        $model->interface_url = basename($model->interface['tmp_name']);
        $this->em->persist($model);
        $this->em->flush();

        return $this->redirect()->toRoute('admin/model');
    }

    public function editAction()
    {
        // Get the id param.
        $id = (int) $this->params()->fromRoute('id', 0);

        // If it's not gotten, add a new item.
        if ($id === 0) {
            return $this->redirect()->toRoute('admin/model', ['action' => 'add']);
        }

        // Get the item
        $model = $this->em->find(Model::class, $id);

        if (is_null($model)) {
            return $this->redirect()->toRoute('admin/model', ['action' => 'index']);
        }

        // Initialize a new Form and change the submit button
        // and set the categories to select's options.
        $form = new ModelForm();
        $form->bind($model);
        $form->get('submit')->setValue('Edit');

        // Check the request.
        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        // Return a the form if it's GET request.
        if (!$request->isPost()) {
            return $viewData;
        }

        $filter = $form->getInputFilter();
        $filter->get('model')->setRequired(false);
        $filter->get('interface')->setRequired(false);
        $form->setInputFilter($filter);

        // Merge POST and FILES arrays.
        $post = array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
        
        // Set the request data to the Form for validation.
        $form->setData($post);

        // If the form data isn't valid, return to the add view with errors.
        if (!$form->isValid()) {
            return $viewData;
        }

        // If the model is changed, save the new name and delete old.
        if ($model->model['size'] !== 0 && $model->model['error'] === 0) {
            if (!empty($model->model_url))
                unlink(getcwd() . '/public/uploads/' . basename($model->model_url));

            $model->model_url = basename($model->model['tmp_name']);
        }

        // If the interface is changed, save the new name and delete old.
        if ($model->interface['size'] !== 0 && $model->interface['error'] === 0) {
            if (!empty($model->interface_url))
                unlink(getcwd() . '/public/uploads/' . basename($model->interface_url));

            $model->interface_url = basename($model->interface['tmp_name']);
        }
        $this->em->flush();

        return $this->redirect()->toRoute('admin/model');
    }
    
}