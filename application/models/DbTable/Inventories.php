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
        
        /**
         * Get an item by inventory ID
         * @param type $id
         * @return type
         */
        public function getItemById($id){
            $select = $this->select()->where ('id = ?', (int)$id);
            $dbResult = $this->fetchRow($select);
            $data = array (
                'itemID'            => $dbResult['id'],
                'itemName'          => $dbResult['itemName'],
                'itemDescription'   => $dbResult['itemDescription'],
                'imageURL'          => $dbResult['imageURL'],
                'price'             => $dbResult['price'],
                'quantity'          => $dbResult['quantity']
                );
            return $data;
        }
        
        /**
         * Get a group of items by an array of IDs
         * @param array $idArray
         */
        public function getItemsById(array $idArray){            
            $data=array();
            
            if(count($idArray)<=0) return $data;
            
            $idList = array_map(function($i){ return (int)$i; }, $idArray);  // make the input safe, cast as int
            $idString = implode(',', $idList); // convert to comma separated list
            
            $select = $this->select()->where ('id in (?)', $idString);
            $rows = $this->fetchAll($select);
                        
            foreach($rows as $row){
                $id=$row['id'];
                $data[$id] = array ('itemID'             => $id,
                                    'itemName'          => $row['itemName'],
                                    'itemDescription'   => $row['itemDescription'],
                                    'imageURL'          => $row['imageURL'],
                                    'price'             => $row['price'],
                                    'quantity'          => $row['quantity']
                                    );
            }            
            
            return $data;
        }
        

    /***

CREATE TABLE  `bookstore`.`inventory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `itemName` varchar(128) NOT NULL,
  `itemDescription` text NOT NULL,
  `imageURL` varchar(255) DEFAULT NULL,
  `price` decimal(5,2) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `quantity` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8
    */
    
}
