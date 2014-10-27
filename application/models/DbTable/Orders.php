<?php

class Application_Model_DbTable_Orders extends Zend_Db_Table_Abstract {

    protected $_name = 'orders';

    public function createOrder($cartData, $customerID){
        $data = array(
            'cartData'      => $cartData,
            'customerID'    => $customerID,
            'orderDate'     => new Zend_Db_Expr('NOW()')
        );
        $this->insert($data);
        
        $orderID = $this->getAdapter()->lastInsertId();
        return $orderID;       
    }
    
    public function updateOrderFileLocation($orderID, $orderFilePath){
        $data = array(
            'orderFilePath' => $orderFilePath
        );
     
        $where = $this->getAdapter()->quoteInto('id = ?', $orderID);
        
        $this->update($data, $where);  
    }
   
}

/*
CREATE TABLE  `bookstore`.`orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cartData` text NOT NULL,
  `customerID` int(10) unsigned NOT NULL,
  `orderDate` datetime NOT NULL,
  `orderFilePath` varchar(255) NOT NULL COMMENT 'Order Processing Location on File System',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 */

