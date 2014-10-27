<?php
/**
 * Created by PhpStorm.
 * User: Tyler
 * Date: 10/26/14
 * Time: 8:47 PM
 */

class Application_Model_DbTable_Reviews extends Zend_Db_Table_Abstract
{

    protected $_name = 'reviews';

    public function getReviews($itemID)
    {

    }

    public function addReview($categoryName)
    {

    }


 //DROP TABLE IF EXISTS `bookstore`.`reviews`;
//CREATE TABLE  `bookstore`.`reviews` (
//`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
// `itemID` int(10) unsigned NOT NULL,
//  `review` text NOT NULL,
//  `rating` int(2) NOT NULL,
//  PRIMARY KEY (`id`)
//) ENGINE=MyISAM DEFAULT CHARSET=utf8;
}








