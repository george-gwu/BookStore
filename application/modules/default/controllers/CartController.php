<?php

class CartController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
        $cart = new App_Cart();
        $this->view->cart = $cart;
        
        $inventoryDb = new Application_Model_DbTable_Inventories();
        $this->view->cartInfo = $inventoryDb->getItemsById($cart->getItemIDsArray());
        
    }    
    
    public function orderCompleteAction(){
        $cart = new App_Cart();
        $cart->clear();
    }
    
    public function addAction(){
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
        $productID = (int)$this->_getParam('pid');
        $next = $this->_getParam('next'); //nextURL (forwards you there)               
                
        $cart = new App_Cart();
        $cart->addItem($productID);                
        
        if(empty($next)) $next = $this->view->url(array('action'=>'index', 'controller'=>'cart'), null, true);
                
        $redir = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');        
        $redir->gotoUrl($next)->redirectAndExit();                
    }
    
    public function deleteAction(){
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
        $productID = (int)$this->_getParam('pid');
        $next = $this->_getParam('next'); //nextURL (forwards you there)               
        
        $cart = new App_Cart();
        $cart->deleteItem($productID);                
        
        if(empty($next)) $next = $this->view->url(array('action'=>'index', 'controller'=>'cart'), null, true);
                
        $redir = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');        
        $redir->gotoUrl($next)->redirectAndExit();                
    }    
    
    public function changeqtyAction(){
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
        $productID = (int)$this->_getParam('pid');
        $quantity = (int)$this->_getParam('qty');
        $next = $this->_getParam('next'); //nextURL (forwards you there)               
        
        $cart = new App_Cart();
        $cart->changeItemQuantity($productID, $quantity);
        
        if(empty($next)) $next = $this->view->url(array('action'=>'index', 'controller'=>'cart'), null, true);
                
        $redir = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');        
        $redir->gotoUrl($next)->redirectAndExit();                
    }       
   

}




