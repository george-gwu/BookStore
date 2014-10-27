<?php

class App_Controller_Plugin_ACL extends Zend_Controller_Plugin_Abstract {
    protected $_defaultRole = 'guest';
 
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        
        $auth = Zend_Auth::getInstance();
        $acl = new App_Acl();
        $session = new Zend_Session_Namespace('session');
 
        if($auth->hasIdentity()) {
            $user = $auth->getIdentity();
            switch($user->roleType){
                case App_Acl::ROLE_ADMIN:
                    $role='admin';
                    break;
                case App_Acl::ROLE_USER:
                    $role='user';
                    break;
                default:
                    $role='guest';
            }
            if(!$acl->isAllowed($role, $request->getModuleName())) {
                $session->destination_url = $request->getPathInfo();
                return Zend_Controller_Action_HelperBroker::getStaticHelper('redirector')->setGotoSimple('noauth', 'auth', 'default');
            }
        } else {
            if(!$acl->isAllowed($this->_defaultRole, $request->getModuleName())) {
       
                $this->_request->setModuleName('default');
                $this->_request->setControllerName('auth');
                $this->_request->setActionName('login');
                $this->_request->setParam('next', $request->getPathInfo());
                
            }
        }
    }
}