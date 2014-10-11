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
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
    }
    
    public function profileAction(){
        $creditCardForm = new Application_Form_CreditCard();
        $creditCardForm->submit->setLabel('Save');
        $this->view->creditCardForm = $creditCardForm;
        
        $addressForm = new Application_Form_Address();
        $addressForm->submit->setLabel('Save');
        $this->view->addressForm = $addressForm;
        
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()) {
            $user = $auth->getIdentity();
            $userID = $user->id;
        } else { // failed, but shouldn't ever be possible since this module is authenticated
            $this->_helper->redirector('index'); 
            exit;
        } 
        
        $customersDb = new Application_Model_DbTable_Customers();
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($creditCardForm->isValid($formData)) {                                            
                $customersDb->updateCreditCard( $userID, 
                                                $creditCardForm->getValue('cardname'), 
                                                $creditCardForm->getValue('cardnumber'), 
                                                $creditCardForm->getValue('cardexpiration'), 
                                                $creditCardForm->getValue('cardsecurity')
                                            );                
                
//                $this->_helper->redirector('index');
            } else {
                $creditCardForm->populate($formData);
            }
        } else {
            $data = $customersDb->getCreditCard($userID);
            $creditCardForm->populate($data);            
        }
    }

}







