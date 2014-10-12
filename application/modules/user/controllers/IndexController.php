<?php
/**
 *  * Save Checkout Information to Profile 
1) Customers can save checkout information to their profile. They should be able to store: 
a. Shipping Address 
b. Credit Card Information 
i. Card Holder’s Name (as it appears on the card) 
ii. Card Account Number 
iii. Expiration Date 
iv. Billing Address 
2) When checking out items the customer should be able to use the saved checkout information 
instead of retyping it. 
 * 
 * 
 *  * 
 * Item Reviews by Customers (required) 
1) Customers can leave reviews of the items you sell. They should be able to leave a message and 
a rating. 
a. The message should be able to hold at least 1000 characters. 
b. The rating system is up to you 
2) The item detail page (from the first set of requirements) should contain all the customer 
comments as a listing. 
 */
class User_IndexController extends Zend_Controller_Action
{

    public function init()
    {        
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()) {
            $user = $auth->getIdentity();
            $this->userID = $user->id;
        } else { // failed, but shouldn't ever be possible since this module is authenticated
            $this->_helper->redirector('index', 'index', 'default'); 
            exit;
        }         
    }

    public function indexAction(){
        $customersDb = new Application_Model_DbTable_Customers();
        
        if(Zend_Registry::isRegistered('creditcardform')){
            $creditCardForm = Zend_Registry::get('creditcardform');
        } else {
            $creditCardForm = new Application_Form_CreditCard();
            $creditCardForm->populate($customersDb->getCreditCard($this->userID));            
            $creditCardForm->setAction($this->_helper->url('savecreditcard'));
        }
        $this->view->creditCardForm = $creditCardForm;                      
                        
        if(Zend_Registry::isRegistered('shippingform')){
            $shipAddressForm = Zend_Registry::get('shippingform');
        } else {
            $shipAddressForm = new Application_Form_Address();            
            $shipAddressForm->populate($customersDb->getShippingAddress($this->userID));            
            $shipAddressForm->setAction($this->_helper->url('saveshipping'));
        }
        $this->view->shippingAddressForm = $shipAddressForm;      
        
        if(Zend_Registry::isRegistered('billingform')){
            $billingAddressForm = Zend_Registry::get('billingform');
        } else {
            $billingAddressForm = new Application_Form_Address();            
            $billingAddressForm->populate($customersDb->getBillingAddress($this->userID));            
            $billingAddressForm->setAction($this->_helper->url('savebilling'));
        }
        $this->view->billingAddressForm = $billingAddressForm;          
        
        if(Zend_Registry::isRegistered('passwordform')){
            $passwordForm = Zend_Registry::get('passwordform');
        } else {
            $passwordForm = new Application_Form_Password();
            $passwordForm->setAction($this->_helper->url('savepassword'));
        }
        $this->view->passwordForm = $passwordForm;       
        
        
    }
    
    public function savebillingAction(){        
        $billingAddressForm = new Application_Form_Address();
                
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($billingAddressForm->isValid($formData)) {                                            
                $customersDb = new Application_Model_DbTable_Customers();
                $customersDb->updateAddress($this->userID, 
                                            'BILLING',
                                            $billingAddressForm->getValue('address1'), 
                                            $billingAddressForm->getValue('address2'), 
                                            $billingAddressForm->getValue('city'), 
                                            $billingAddressForm->getValue('state'),                        
                                            $billingAddressForm->getValue('zipcode'), 
                                            $billingAddressForm->getValue('country') 
                                        );                                
            } else {
                $billingAddressForm->populate($formData);
                Zend_Registry::set('billingform', $billingAddressForm);
            }
        }   
        
        $this->_forward('index');
    }    
    
    public function saveshippingAction(){        
        $shippingAddressForm = new Application_Form_Address();
                
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($shippingAddressForm->isValid($formData)) {                                            
                $customersDb = new Application_Model_DbTable_Customers();
                $customersDb->updateAddress($this->userID, 
                                            'SHIPPING',
                                            $shippingAddressForm->getValue('address1'), 
                                            $shippingAddressForm->getValue('address2'), 
                                            $shippingAddressForm->getValue('city'), 
                                            $shippingAddressForm->getValue('state'),                        
                                            $shippingAddressForm->getValue('zipcode'), 
                                            $shippingAddressForm->getValue('country') 
                                        );                                
            } else {
                $shippingAddressForm->populate($formData);
                Zend_Registry::set('shippingform', $shippingAddressForm);
            }
        }   
        
        $this->_forward('index');
    }
        
    
    public function savecreditcardAction(){        
        $creditCardForm = new Application_Form_CreditCard();
                
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($creditCardForm->isValid($formData)) {                                            
                $customersDb = new Application_Model_DbTable_Customers();
                $customersDb->updateCreditCard( $this->userID, 
                                                $creditCardForm->getValue('cardname'), 
                                                $creditCardForm->getValue('cardnumber'), 
                                                $creditCardForm->getValue('cardexpiration'), 
                                                $creditCardForm->getValue('cardsecurity')
                                            );                                
            } else {
                $creditCardForm->populate($formData);
                Zend_Registry::set('creditcardform', $creditCardForm);
            }
        }   
        
        $this->_forward('index');
    }
    
    public function savepasswordAction(){        
        $passwordForm = new Application_Form_Password();
                
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($passwordForm->isValid($formData)) {                                            
                $customersDb = new Application_Model_DbTable_Customers();
                $customersDb->updatePassword( $this->userID, 
                                                $passwordForm->getValue('password1')                                                
                                            );           
                $passwordForm = "Password changed!";
            }
            Zend_Registry::set('passwordform', $passwordForm);            
        }   
        
        
        $this->_forward('index');
    }
    

}







