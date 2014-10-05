<?php

class Application_Model_DbTable_Customers extends Zend_Db_Table_Abstract
{
    protected $_name = 'customers';
    
    const ROLE_ADMIN = 9;
    const ROLE_USER = 0;

    
    public function registerCustomer($email, $firstName, $lastName, $password){
        $data = array(
            'roleType'      => self::ROLE_USER,
            'email'         => $email,
            'firstName'     => $firstName,
            'lastName'      => $lastName,
            'password'      => $password
        );
        $this->insert($data);
        
        $userID = $this->getAdapter()->lastInsertId();
        return $userID;        
    }

    /*** 
     * CREATE TABLE  `bookstore`.`customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `roleType` int(1) unsigned NOT NULL DEFAULT '0',
  `email` varchar(128) NOT NULL COMMENT 'username',
  `firstName` varchar(128) NOT NULL,
  `lastName` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `shippingAddress1` varchar(128) DEFAULT NULL,
  `shippingAddress2` varchar(128) DEFAULT NULL,
  `shippingCity` varchar(64) DEFAULT NULL,
  `shippingState` varchar(2) DEFAULT NULL,
  `shippingCountry` varchar(4) DEFAULT NULL,
  `shippingZipcode` varchar(16) DEFAULT NULL,
  `billingAddress1` varchar(128) DEFAULT NULL,
  `billingAddress2` varchar(128) DEFAULT NULL,
  `billingCity` varchar(64) DEFAULT NULL,
  `billingState` varchar(2) DEFAULT NULL,
  `billingCountry` varchar(4) DEFAULT NULL,
  `billingZipcode` varchar(16) DEFAULT NULL,
  `encryptedCardName` varchar(255) DEFAULT NULL,
  `encryptedCardNumber` varchar(255) DEFAULT NULL,
  `encryptedCardExpiration` varchar(255) DEFAULT NULL,
  `encryptedCardSecurityCode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
     */

}

