<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $categories = new Application_Model_DbTable_Categories();
        $this->view->categories = $categories->fetchAll();
    }

    public function addAction()
    {
        $form = new Application_Form_Category();
        $form->submit->setLabel('Add');
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $categoryName = $form->getValue('categoryName');
                $categories = new Application_Model_DbTable_Categories();
                $categories->addCategory($categoryName);
                
                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        }
            
    }

    public function editAction()
    {
        $form = new Application_Form_Category();
        $form->submit->setLabel('Save');
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = (int)$form->getValue('id');
                $categoryName = $form->getValue('categoryName');
                $categories = new Application_Model_DbTable_Categories();
                $categories->updateCategory($id, $categoryName);
                
                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        } else {
            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                $categories = new Application_Model_DbTable_Categories();
                $form->populate($categories->getCategory($id));
            }
        }
        
    }

    public function deleteAction()
    {
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Yes') {
                $id = $this->getRequest()->getParam('id');
                $categories = new Application_Model_DbTable_Categories();
                $categories->deleteCategory($id);
            }
            $this->_helper->redirector('index');
        } else {
            $id = $this->_getParam('id', 0);
            $categories = new Application_Model_DbTable_Categories();
            $this->view->category = $categories->getCategory($id);
        }
    }


}







