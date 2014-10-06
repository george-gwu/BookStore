<?php

class App_Acl extends Zend_Acl {
    
    const ROLE_ADMIN = 9;
    const ROLE_USER = 1;
    const ROLE_GUEST = 0;
    
    public function __construct(){
        // Add a new role called "guest"
        $this->addRole(new Zend_Acl_Role('guest'));
        // Add a role called user, which inherits from guest
        $this->addRole(new Zend_Acl_Role('user'), 'guest');
        // Add a role called admin, which inherits from user
        $this->addRole(new Zend_Acl_Role('admin'), 'user');
 
        // Add some resources in the form controller::action
        $this->add(new Zend_Acl_Resource('default'));
        $this->add(new Zend_Acl_Resource('user'));
        $this->add(new Zend_Acl_Resource('admin'));
        
        // Allow guests to see the default module
        $this->allow('guest', 'default');
        // Allow users to access user module
        $this->allow('user', 'user');
        // Allow admin to access admin module
        $this->allow('admin', 'admin');
 
        // You will add here roles, resources and authorization specific to your application, the above are some examples
    }
}