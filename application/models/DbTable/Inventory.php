<?php

    class Application_Model_DbTable_Inventory extends Zend_Db_Table_Abstract
    {
        /**
         * Allows an admin to add a book to the inventory.
         * Q:  Need a key like item Number, is that itemID?   
         * A:  it is just ID. since the table is inventory, that is like inventoryID
         */

        protected $_name = 'inventory';

        public function registerItem($itemName, $itemDescription, $price, $quantity, $categoryID){
            $data = array(
                'itemName'          => $itemName,
                'itemDescription'   => $itemDescription,
                'price'             => $price,
                'quantity'          => $quantity,
                'categoryID'        => $categoryID,
                'dateCreated'       => Zend_Date::now()->get(Zend_Date::ISO_8601)
            );
            $this->insert($data);
            $itemID = $this->getAdapter()->lastInsertId();
            return $itemID;
        }
        
        /**
         * Update Item Inventory Quantity by Reducing by Order Quantity
         * @param type $ItemID
         * @param type $orderquantity
         */
        public function updateInventory($ItemID, $orderquantity){
            $data = array(
                    'quantity' => new Zend_Db_Expr(
                                $this->getAdapter()->quoteInto('quantity - ?', $orderquantity)
                            )
                    );
            
            $where = $this->getAdapter()->quoteInto('ID = ?', $ItemID);
            $this->update($data, $where);            
        }
        
        
        
        /**  
         * Given a partial string of the title the function
         * will return the full title and the number of quantities available.
         * Q:   Can I just return the item Name on file with the quantity; not the entire record?
        */
        
        public function getInvetoryStatus($itemID, $itemName){
            $select = $this->select()->where ('itemName like "%?%"', $itemName);
            $dbResult = $this->fetchRow($select);
            $data = array (
                'itemName' => $dbResult['itemName'],
                'itemDescription' => $dbResult['itemDescription'],
                'price' => $dbResult['price'],
                'quantity' => $dbResult['quantity']
                );
            
            return $data;
        }
        
        /**
         * Gets an inventory item by ID
         * @param type $itemID
         * @return array
         */
        public function getInventoryItemById($itemID){
            
            $select = $this->select()->where ('id = ?', $itemID);
            $dbResult = $this->fetchRow($select);
            
            return $dbResult->toArray();                    
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
