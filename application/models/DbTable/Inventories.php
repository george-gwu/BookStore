<?php

    class Application_Model_DbTable_Inventories extends Zend_Db_Table_Abstract
    {
        /**
         * Allows an admin to add a book or article to the inventory.
         * Q:  Need a key like item Number, is that itemID?   I need this for lookup and updates.
         */

        protected $_name = 'inventory';

            public function addInventory($ItemName, $itemDescription, $price, $dateCreated, $quantity, $category){
            $data = array(
                'itemName' => $ItemName,
                'itemDescription' => $itemDescription,
                'price' => $price,
                'date' => $dateCreated,
                'quantity' => $quantity,
                'category' => $category
            );
            $this->insert($data);
            
            $itemID = $this->getAdapter()->lastInsertId();
            return $itemID;         
            }
        /**
         * Fix $where ...getItem  
         */
         
        public function updateInventory($itemID, $itemName, $itemDescription, $price, $quantity, $category){
            $data = array(
                'itemID' => $itemID,
                'itemName' => $itemName,
                'itemDescription' => $itemDescription,
                'price' => $price,
                'quantity' => $quantity,
                'category' => $category
            );
            $where = $this->getAdapter()->QuoteInto('item = ?', $itemID);
            
            $this->update($data, $where); 
        }
        
        public function deleteCategory($itemID)
        {
            $this->delete('id =' . (int)$itemID);
        }
        /**  
         * Given a partial string of the title the function
         * will return the full title and the number of quantities available.
         * Q:   Can I just return the item Name on file with the quantity; not the entire record?
        */
        
        public function getInvetoryStatus($itemID, $itemName){
            $select = $this->select()->where ('itemID <= ?', $itemName);
            $dbResult = $this->fetchRow($select);
            $data = array (
                'itemID' => $dbResult['itemID'],
                'itemName' => $dbResult['itemName'],
                'itemDescription' => $dbResult['itemDescription'],
                'price' => $dbResult['price'],
                'quantity' => $dbResult['quantity']
                );
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
    
}
