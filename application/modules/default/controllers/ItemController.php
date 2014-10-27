<?php
/**
 * Created by PhpStorm.
 * User: Tyler
 * Date: 10/26/14
 * Time: 11:30 AM
 */
/**
 1) Customers must be able to browse the inventory of items to purchase. When looking for an 
item the customer should be presented with a listing (at least 3 items per screen) of at least the 
following attributes: 
 Item Name 
 Price  Add to cart button
2) The listing of item must also be filterable/sortable by at least the following attributes:
 Category (filter) 
 Price (sortable, low to high) 
 Name (text search) 
3) Each item should be a link (or have a link) to a details page which shows all relevant item 
attributes and includes a button to add the item to the shopping cart. 
 * 
 * 
 * Item Reviews by Customers (required) 
2) The item detail page (from the first set of requirements) should contain all the customer 
comments as a listing. 

 */
class ItemController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function browseAction()
    {
        //$form = new Application_Form_Browse();
        //$this->view->form = $form;

        $items = new Application_Model_DbTable_ItemBrowse();

        $page = $this->_request->getParam('page');
        if (empty($page)) { $page = 1; }

        $paginator = $items->getPageOfItems($page);
        $this->view->paginator = $paginator;

    }
    public function priceAction()
    {

        $items = new Application_Model_DbTable_ItemBrowse();

        $page = $this->_request->getParam('page');
        if (empty($page)) { $page = 1; }

        $paginator = $items->getPricedPageOfItems($page);
        $this->view->paginator = $paginator;

    }
    public function categoryAction()
    {
        $items = new Application_Model_DbTable_ItemBrowse();

        $page = $this->_request->getParam('page');
        if (empty($page)) { $page = 1; }

        $paginator = $items->getItemsByCategory($page);
        $this->view->paginator = $paginator;

    }
    public function detailAction()
    {
        $pid = $this->_request->getParam('pid');
        
        $inventoryDb = new Application_Model_DbTable_Inventories();
        $this->view->item = $inventoryDb->getItemById($pid);
    }
    
}




