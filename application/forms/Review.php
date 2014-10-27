<?php
/**
 * Created by PhpStorm.
 * User: Tyler
 * Date: 10/26/14
 * Time: 9:36 PM
 */
class Application_Form_Review extends Zend_Form
{
    public function init()
    {
        $this->setName('review');

        $reviewHeader = new Zend_Form_Element_Note("Customer Reviews");
        $reviewHeader->setLabel('Customer Reviews');

        $this->addElement($reviewHeader);

    }
}