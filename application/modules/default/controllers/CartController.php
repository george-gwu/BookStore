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
   

}




