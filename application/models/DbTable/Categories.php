<?php

class Application_Model_DbTable_Categories extends Zend_Db_Table_Abstract
{

    protected $_name = 'categories';

    public function getCategory($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    public function addCategory($categoryName)
    {
        $data = array(
            'categoryName' => $categoryName
        );
        $this->insert($data);
    }

    public function updateCategory($id, $categoryName)
    {
        $data = array(
            'categoryName' => $categoryName
        );
        $this->update($data, 'id = '. (int)$id);
    }

    public function deleteCategory($id)
    {
        $this->delete('id =' . (int)$id);
    }
/**
 * CREATE TABLE  `bookstore`.`categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8
 */
}

