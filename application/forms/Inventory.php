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
			
		$price = new Zend_Form_Element_Text('price');
		$price->setLabel('Price')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
			
		$dateCreated = new Zend_Form_Element_Text('dateCreated');
		$dateCreated->setLabel('Date Stocked')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
			
		$quantity = new Zend_Form_Element_Text('quantity');
		$quantity->setLabel('Quantity')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
			
		$category = new Zend_Form_Element_Text('category');
		$category->setLabel('Item')
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
