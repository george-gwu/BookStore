
<?php
/**
 * Created by PhpStorm.
 * User: Tyler
 * Date: 10/26/14
 * Time: 11:30 AM
 */
class Application_Form_Browse extends Zend_Form
{
    public function init()
    {
        $this->setName('browse');
        $atc = new Zend_Form_Element_Submit('atcbutton');
        $atc->setAttrib('id', 'atcbutton')
            ->setLabel('Add to Cart');

        $this->addElements(array($atc));


    }
}









