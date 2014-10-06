<?php

class Application_Form_Register extends Zend_Form
{
    public function init()
    {
        $this->setName('register');        

        $firstName = new Zend_Form_Element_Text('firstName');
        $firstName->setLabel('First Name')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->addValidator('StringLength', false, array(null,128));
        
        $lastName = new Zend_Form_Element_Text('lastName');
        $lastName->setLabel('Last Name')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->addValidator('StringLength', false, array(null,128));
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('EmailAddress')
              ->addValidator('StringLength', false, array(null,128));
        
        $password1 = new Zend_Form_Element_Password('password1');
        $password1->setLabel('Password')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('StringLength', false, array(6,128));
        
        $password2 = new Zend_Form_Element_Password('password2');
        $password2->setLabel('Password (Again)')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('StringLength', false, array(6,128))
              ->addValidator('Identical', false, array('token' => 'password1'))
              ->addErrorMessage('Passwords must match!');             

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
               ->setLabel('Register');

        $this->addElements(array($firstName, $lastName, $email, $password1, $password2, $submit));
    }
}