<?php

class Application_Form_CreditCard extends Zend_Form
{
    public function init()
    {
        $this->setName('creditcard');        
        
        $cardname = new Zend_Form_Element_Text('cardname');
        $cardname->setLabel('Name on Card')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
        
        
        $cardnumber = new Zend_Form_Element_Text('cardnumber');
        $cardnumber->setLabel('Card Number')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->addValidator('CreditCard');
        
        $cardexpiration = new Zend_Form_Element_Text('cardexpiration');
        $cardexpiration->setLabel('Card Expiration (MM/YYYY)')
              ->setRequired(true)
              ->setAttrib('size', 7)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator(new Zend_Validate_Date(array('format' => 'MM/YYYY')));
        
        $cardsecurity = new Zend_Form_Element_Text('cardsecurity');
        $cardsecurity->setLabel('Card Security')
              ->setRequired(true)
              ->setAttrib('size', 4)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('StringLength', false, array(3,4));
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
               ->setLabel('Login');

        $this->addElements(array($cardname, $cardnumber, $cardexpiration, $cardsecurity, $submit));
    }
}