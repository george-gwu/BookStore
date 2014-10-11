<?php

    class Application_Model_DbTable_Inventory extends Zend_Db_Table_Abstract
    {
        protected $_name = 'inventory';

        public function registerItem($itemName, $itemDescription, $price, $dateCreated, $quantity, $categoryID){
        $data = array(
        'roleType' => App_Acl::CATEGORY,
            'itemName' => $itemName,
            'itemDescription' => $itemDescription,
            'price' => $price,
            'quantity' => $quantity,
            'dateCreated' => $dateCreated
    );
    $this->insert($data);
    $itemID = $this->getAdapter()->lastInsertId();
    return $itemID;
    }
    
   
/***

* CREATE TABLE `inventory` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `itemName` varchar(128) NOT NULL,
  `itemDescription` text NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `quantity` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

*/
}
