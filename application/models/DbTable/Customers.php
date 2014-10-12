<?php

class Application_Model_DbTable_Customers extends Zend_Db_Table_Abstract
{
    protected $_name = 'customers';   

    
    public function registerCustomer($email, $firstName, $lastName, $password){
        $data = array(
            'roleType'      => App_Acl::ROLE_USER,
            'email'         => $email,
            'firstName'     => $firstName,
            'lastName'      => $lastName,
            'password'      => $password
        );
        $this->insert($data);
        
        $userID = $this->getAdapter()->lastInsertId();
        return $userID;        
    }
    
    /**
     * Adds OTFE when persisting in DB
     * @param type $userID
     * @param type $cardName
     * @param type $cardNumber
     * @param type $expiration
     * @param type $securityCode
     */
    public function updateCreditCard($userID, $cardName, $cardNumber, $expiration, $securityCode){
        $cryptFilter = $this->_getEncryptFilter();
        
        $vector = $cryptFilter->getVector();
        
        $encryptedCardName = $cryptFilter->filter($cardName);
        $encryptedCardNumber = $cryptFilter->filter($cardNumber);
        $encryptedExpiration = $cryptFilter->filter($expiration);
        $encryptedSecurityCode = $cryptFilter->filter($securityCode);
        
        $data = array(
                    'encryptedCardName'         => $encryptedCardName,
                    'encryptedCardNumber'       => $encryptedCardNumber,
                    'encryptedCardExpiration'   => $encryptedExpiration,
                    'encryptedCardSecurityCode' => $encryptedSecurityCode,
                    'encryptVector'             => $vector
        );
        
        $where = $this->getAdapter()->quoteInto('id = ?', $userID);
        
        $this->update($data, $where);
    }
    
    /**
     *
     * @param type $userID userID 
     * @param type $password password to be hashed
     */
    public function updatePassword($userID, $password){        
        
        $hmac = new Zend_Crypt_Hmac();
        $hashedPassword = $hmac->compute(Bootstrap::HMAC_KEY, 'sha256', $password);
        
        $data = array(
                    'password' => $hashedPassword,
        );
        
        $where = $this->getAdapter()->quoteInto('id = ?', $userID);
        
        $this->update($data, $where);
    }
    
    /**
     * Uses OTFE when retrieving from DB
     * @param type $userID
     * @return type
     */
    public function getCreditCard($userID){
        $select = $this->select()->where('id <= ?', $userID);

	$dbResult = $this->fetchRow($select);
        
        if(empty($dbResult['encryptVector'])) return array(); //no stored card on file
        
        $cryptFilter = $this->_getDecryptFilter($dbResult['encryptVector']);

        $data = array(
            'cardname'         => $cryptFilter->filter($dbResult['encryptedCardName']),
            'cardnumber'       => $cryptFilter->filter($dbResult['encryptedCardNumber']),
            'cardexpiration'   => $cryptFilter->filter($dbResult['encryptedCardExpiration']),
            'cardsecurity'     => $cryptFilter->filter($dbResult['encryptedCardSecurityCode'])
        );
        
        return $data;
    }
    
    
    /**
     * @param type $userID
     * @return Shipping Address
     */
    public function getShippingAddress($userID){
        $select = $this->select()->where('id <= ?', $userID);

	$dbResult = $this->fetchRow($select);
               
        $data = array(
            'address1'  =>   $dbResult['shippingAddress1'],
            'address2'  =>   $dbResult['shippingAddress2'],
            'city'      =>   $dbResult['shippingCity'],
            'state'     =>   $dbResult['shippingState'],
            'country'   =>   $dbResult['shippingCountry'],
            'zipcode'   =>   $dbResult['shippingZipcode'],
        );

        return $data;
    }
    
    /**
     * @param type $userID
     * @return Billing Address
     */
    public function getBillingAddress($userID){
        $select = $this->select()->where('id <= ?', $userID);

	$dbResult = $this->fetchRow($select);
               
        $data = array(
            'address1'  =>   $dbResult['billingAddress1'],
            'address2'  =>   $dbResult['billingAddress2'],
            'city'      =>   $dbResult['billingCity'],
            'state'     =>   $dbResult['billingState'],
            'country'   =>   $dbResult['billingCountry'],
            'zipcode'   =>   $dbResult['billingZipcode'],
        );

        return $data;
    }    
    
    /**
     * 
     * @param type $userID 
     * @param type $type BILLING/SHIPPING/BOTH
     * @param type $address1
     * @param type $address2
     * @param type $city
     * @param type $state
     * @param type $country
     * @param type $zipcode
     */
    public function updateAddress($userID, $type, $address1, $address2, $city, $state, $country, $zipcode){
        $data=array();
        
        if($type=='SHIPPING' or $type=='BOTH'){
            $data['shippingAddress1'] = $address1;
            $data['shippingAddress2'] = $address2;
            $data['shippingCity'] = $city;
            $data['shippingState'] = $state;
            $data['shippingCountry'] = $country;
            $data['shippingZipcode'] = $zipcode;
        }
        
        if($type=='BILLING' or $type=='BOTH'){
            $data['billingAddress1'] = $address1;
            $data['billingAddress2'] = $address2;
            $data['billingCity'] = $city;
            $data['billingState'] = $state;
            $data['billingCountry'] = $country;
            $data['billingZipcode'] = $zipcode;
        }
        
        $where = $this->getAdapter()->quoteInto('id = ?', $userID);
        
        $this->update($data, $where);
    }
    
    /**
     * 
     * @param type $vector Optional Vector (Randomly generated if null, but needs to be persisted)
     * @return \Zend_Filter_Encrypt
     */
    protected function _getEncryptFilter($vector=null){
        return new Zend_Filter_Encrypt(array(   'adapter'             => 'mcrypt',
                                                'key'                 => Bootstrap::AES_KEY,
                                                'algorithm'           => 'rijndael-128',
                                                'mode'                => 'cbc',
                                                'salt'                => true,
                                                'vector'              => null 
                                    ));
    }
    /**
     * Get a decrypt filter chained with a Null Byte StringTrim Filter because CBC mode pads with null bytes.
     * @param type $vector
     * @return \Zend_Filter_Decrypt
     */
    protected function _getDecryptFilter($vector){
        $chainFilter = new Zend_Filter();
        
        $chainFilter->appendFilter(new Zend_Filter_Decrypt(array(   'adapter'             => 'mcrypt',
                                                'key'                 => Bootstrap::AES_KEY,
                                                'algorithm'           => 'rijndael-128',
                                                'mode'                => 'cbc',
                                                'salt'                => true,
                                                'vector'              => $vector 
                                    )));
        $chainFilter->appendFilter(new Zend_Filter_Callback(array('callback' => 'rtrim', 'options'  => array('key' => "\0"))));                 
        
        return $chainFilter;
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

