<?php
/**
 * Created by PhpStorm.
 * User: Tyler
 * Date: 10/26/14
 * Time: 11:30 AM
 */

class Application_Model_DbTable_ItemBrowse extends Zend_Db_Table_Abstract
{

    protected $_name = 'inventory';

    /**
     * Return one page of order entries
     *
     * @param int $page page number
     * @return Zend_Paginator Zend_Paginator
     */
    public function getPageOfItems($page=1) {

        $query = $this->select()->order('id ASC');
        $paginator = new Zend_Paginator( new Zend_Paginator_Adapter_DbTableSelect($query));
        $paginator->setItemCountPerPage(5);
        $paginator->setCurrentPageNumber($page);
        return $paginator;
    }

    public function getPricedPageOfItems($page=1) {

        $query = $this->select()->order('price ASC');
        $paginator = new Zend_Paginator( new Zend_Paginator_Adapter_DbTableSelect($query));
        $paginator->setItemCountPerPage(5);
        $paginator->setCurrentPageNumber($page);
        return $paginator;
    }
    public function getItemsByCategory($page=1) {

        $query = $this->select()->order('categoryID ASC');
        $paginator = new Zend_Paginator( new Zend_Paginator_Adapter_DbTableSelect($query));
        $paginator->setItemCountPerPage(5);
        $paginator->setCurrentPageNumber($page);
        return $paginator;
    }
} 