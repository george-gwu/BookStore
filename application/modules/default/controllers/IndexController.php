<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
    }
    
     public function registerAction()
    {
         
        $form = new Application_Form_Register();
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $rawFormData = $this->getRequest()->getPost();
            if ($form->isValid($rawFormData)) {
                $validatedData = $form->getValidValues($rawFormData);
                $customerDB = new Application_Model_DbTable_Customers();
                
                $hmac = new Zend_Crypt_Hmac();
                $passwordHash = $hmac->compute(Bootstrap::HMAC_KEY, 'sha256', $validatedData['password1']);
                
                $userID = $customerDB->registerCustomer(    $validatedData['email'], 
                                                            $validatedData['firstName'], 
                                                            $validatedData['lastName'], 
                                                            $passwordHash
                                                        );
                
                $this->view->form = "You have registed! You are customer $userID";
                
            } else {
                $form->populate($rawFormData);
            }
        }        
        
    }

}




