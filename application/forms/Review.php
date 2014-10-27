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

        $firstName = new Zend_Form_Element_Text('firstName');

    }
}