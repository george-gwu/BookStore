<?php

class Application_Form_CreditCard extends Zend_Form
{
    public function init()
    {
        $this->setName('creditcard');        
        
        $cardname = new Zend_Form_Element_Text('cardname');
        $cardname->setLabel('Name on Card')
              ->setAttrib('size', 40)
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addFilter('StringToUpper')
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
              ->addValidator(new Zend_Validate_Callback(
                    function($rawDate){ // Custom Validator (Expires in Future and Before Ten Years) 
                        // Check Format
                        $fmtValid = new Zend_Validate_Date(array('format'=>'MM/YYYY'));
                        if(!$fmtValid->isValid($rawDate)) return false;
                        // Check if expired
                        $exp = new Zend_Date($rawDate, 'MM/YYYY');
                        $exp->addMonth(1)->subSecond(1);
                        if($exp->isEarlier(Zend_Date::now())){ // if expiration is before current time
                            return false;
                        }                
                        // Check if too far in the future
                        $tenYears = Zend_Date::now();
                        $tenYears->addYear(10);
                        if($exp->isLater($tenYears)){
                            return false;
                        }
                        return true;
                    })
                );
        $cardsecurity = new Zend_Form_Element_Text('cardsecurity');
        $cardsecurity->setLabel('Card Security')
              ->setRequired(true)
              ->setAttrib('size', 4)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('Int')
              ->addValidator('StringLength', false, array(3,4));               
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
               ->setLabel('Save');

        $this->addElements(array($cardname, $cardnumber, $cardexpiration, $cardsecurity, $submit));
    }
}