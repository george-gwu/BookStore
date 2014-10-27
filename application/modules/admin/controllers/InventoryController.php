<?php
/**
 * Inventory Management (required) 
1) A separate part of the site must contain a interface for administrators to manage the inventory 
of the site. Each item in the inventory must contain at least the following attributes: 
 Item Name 
 Item Description 
 Price 
 Date Added 
 Category 
2) Administrators must be able to perform the following functions: 
 Add a new item 
 Edit an existing item 
 Delete an existing item 
 */
class Admin_InventoryController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $inventories = new Application_Model_DbTable_Inventories();
        $this->view->inventories = $inventories->fetchAll();          
    }

    public function addAction()
    {
        $form = new Inventory_Update_Form();
        $form->submit->setLabel('Add');
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $itemName = $form->getValue('itemName');
                $itemDescription = $form->getValue('itemDescription');
                $price = $form->getValue('price');
                $dateCreated=getdate();
                $quantity=getValue('quantity');
                $category=getValue('category');
                $InventoryDb = new Application_Model_DbTable_Inventory();
                $InventoryDb->addInventory($itemName, $itemDescription, $price, $dateCreated, $quantity,$category);
                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        $form = new Inventory_Update_Form();
        $form->submit->setLabel('Save');
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $itemID = (int)$form->getValue('itemID');
                $itemName = $form->getValue('itemName');
                $itemDescription = $form->getvalue('itemDescription');
                $price = $form->getValue('price');
                $quantity = $form->getValue('quantity');
                $category = $form->getValue('category');
                
                $inventoryDb = new Application_Model_DbTable_Inventories();
                $inventoryDb->updateCategory($itemID, $itemName, $itemDescription, $price, $quantity, $category);
                
                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        } else {
            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                $inventoryDb = new Application_Model_DbTable_Inventories();
                $form->populate($inventoryDb->getInventory($itemID));
            }
        }
        
    }
       public function deleteAction()
    {
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Yes') {
                $itemID = $this->getRequest()->getParam('itemID');
                
                $inventoryDb = new Application_Model_DbTable_Inventories();
                $inventoryDb->deleteCategory($itemID);
            }
            $this->_helper->redirector('index');
        } else {
            $itemID = $this->_getParam('itemID', 0);
            $inventoryDb = new Application_Model_DbTable_Inventories();
            $this->view->inventory = $inventoryDb->getInventory($itemID);
        }
    }

}