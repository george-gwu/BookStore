<?php

class Application_Form_Category extends Zend_Form
{
    public function init()
    {
        $this->setName('category');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $categoryName = new Zend_Form_Element_Text('categoryName');
        $categoryName->setLabel('Category Name')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id, $categoryName, $submit));
    }
}