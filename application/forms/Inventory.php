<?php

class Inventory_Update_Form extends Zend_Form
{
	public function init()
	{
		$this->setName('inventory');
		
		$itemName = new Zend_Form_Element_Text('itemName');
		$itemName->setLabel('Item')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
			
		$itemDescription = new Zend_Form_Element_Password('itemDescription');
		$itemDescription->setLabel('Item Description')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
			
			$itemName = new Zend_Form_Element_Text('itemName');
		$itemName->setLabel('Item')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
$submit = new Zend_Form_Element_Submit('submit');
$submit->setAttrib('id', 'submitbutton')
->setLabel('Login');
$this->addElements(array($email, $password, $submit));
}
}
