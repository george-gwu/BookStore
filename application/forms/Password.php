<?php

class Application_Form_Password extends Zend_Form
{
    public function init()
    {
        $this->setName('password');        
        
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
               ->setLabel('Change Password');

        $this->addElements(array($password1, $password2, $submit));
    }
}