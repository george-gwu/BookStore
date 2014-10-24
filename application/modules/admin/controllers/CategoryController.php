<?php

class Admin_CategoryController extends Zend_Controller_Action
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
                
                $categoriesDb = new Application_Model_DbTable_Categories();
                $categoriesDb->addCategory($categoryName);
                
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
                
                $categoriesDb = new Application_Model_DbTable_Categories();
                $categoriesDb->updateCategory($id, $categoryName);
                
                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        } else {
            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                $categoriesDb = new Application_Model_DbTable_Categories();
                $form->populate($categoriesDb->getCategory($id));
            }
        }
        
    }

    public function deleteAction()
    {
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Yes') {
                $id = $this->getRequest()->getParam('id');
                
                $categoriesDb = new Application_Model_DbTable_Categories();
                $categoriesDb->deleteCategory($id);
            }
            $this->_helper->redirector('index');
        } else {
            $id = $this->_getParam('id', 0);
            $categoriesDb = new Application_Model_DbTable_Categories();
            $this->view->category = $categoriesDb->getCategory($id);
        }
    }


}







