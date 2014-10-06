<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    const HMAC_KEY = "P@p3rFr33B00ks!!";
    
    protected function _initPlugins(){
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('App_');
 
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new App_Controller_Plugin_ACL(), 1);
        
        return $front;
    }    

}

