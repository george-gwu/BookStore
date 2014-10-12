<?php

    class Application_Model_DbTable_Inventory extends Zend_Db_Table_Abstract
    {
        /**
         * Allows an admin to add a book or article to the inventory.
         * Q:  Need a key like item Number, is that itemID?   I need this for lookup and updates.
         */

        protected $_name = 'inventory';

        public function registerItem($itemName, $itemDescription, $price, $quantity, $categoryID){
            $data = array(
        /*        'roleType' => App_Acl::ROLEUSER,   May need admin accounts  */
                'itemName' => $itemName,
                'itemDescription' => $itemDescription,
                'price' => $price,
                'quantity' => $quantity
            );
            $this->insert($data);
            $itemID = $this->getAdapter()->lastInsertId();
            return $itemID;
        }
        /**
         * Fix $where ...getItem  
         */
         
        public function updateInventory($ItemID, $orderquantity){
            $data = array(
                'quantity' => $quantity - $orderquantity)
            );
            $where = $this->getItem()->('item = ?', $itemID);
            $this->update($data, $where);
            
        }
        
        
        /**  
         * Given a partial string of the title the function
         * will return the full title and the number of quantities available.
         * Q:   Can I just return the item Name on file with the quantity; not the entire record?
        */
        
        public function getInvetoryStatus($itemID, $itemName){
            $select = $this->select()->where ('item <= ?', $itemName)
            $dbResult = $this->fetchRow($select);
            $data = array (
                'itemName' => $dbResult['itemName'],
                'itemDescription' => $dbResult['itemDescription'],
                'price' => $dbResult['price']
                'quantity' => $dbResult['quantity']
                )
            return $data;
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

    public function updateInventory($userID, $cardName, $cardNumber, $expiration, $securityCode){
    
}
