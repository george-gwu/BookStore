<?php
/**
 * Custom Sign Up and Login/Logout (required) 
[X] 1) Customers must be able to create an account to maintain an identity on your site. Record at 
    least the following items: Username, First Name, Last Name, Email Address, Password
[X] 2) Customers must be able to login to the site and be given a session. Once logged in customers 
    should be able to logout by clicking a link or button labeled “logout”. 
 */
class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
    }
   
    
    public function loginAction(){
        
        $form = new Application_Form_Login();
        $this->view->form = $form;       
        
        if ($this->getRequest()->isPost()) {
            $rawFormData = $this->getRequest()->getPost();
            if ($form->isValid($rawFormData)) {
                $validatedData = $form->getValidValues($rawFormData);                                                                
                $passwordHash = $this->_getPasswordHash($rawFormData['password']);

                $dbAdapter = Zend_Db_Table::getDefaultAdapter();
                $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

                $authAdapter->setTableName('customers')
                            ->setIdentityColumn('email')
                            ->setCredentialColumn('password');
                $authAdapter->setIdentity($validatedData['email']);
                $authAdapter->setCredential($passwordHash);
                
                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);
                if ($result->isValid()) {
                    $user = $authAdapter->getResultRowObject();
                    $auth->getStorage()->write($user);                    
                    
                    $this->_helper->layout()->disableLayout(); 
                    $this->_helper->viewRenderer->setNoRender(true);
                    $this->_helper->getHelper('Redirector')->setCode(303)
                        ->setExit(true)
                        ->setGotoSimple('index', 'index', 'default');
                    
                } else {
                    $form->getElement('password')->addErrors($result->getMessages());
                }
            } else {
                $form->populate($rawFormData);
            }
        }                               
    }    
    
    public function logoutAction(){
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $auth->clearIdentity();
        }
        
        $this->_helper->layout()->disableLayout(); 
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->getHelper('Redirector')->setCode(303)
                        ->setExit(true)
                        ->setGotoSimple('index', 'index', 'default');                        
        
    }
    
     public function registerAction(){
         
        $form = new Application_Form_Register();
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $rawFormData = $this->getRequest()->getPost();
            if ($form->isValid($rawFormData)) {
                $validatedData = $form->getValidValues($rawFormData);
                $customerDB = new Application_Model_DbTable_Customers();
                
                $passwordHash = $this->_getPasswordHash($validatedData['password1']);
                
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
    
    protected function _getPasswordHash($password){
        $hmac = new Zend_Crypt_Hmac();
        return $hmac->compute(Bootstrap::HMAC_KEY, 'sha256', $password);
    }

}




