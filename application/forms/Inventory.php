<?php

class Application_Form_Inventory extends Zend_Form
{
	public function init()
	{
		$this->setName('inventory');
		
		$itemName = new Zend_Form_Element_Text('itemName');
		$itemName->setLabel('Item')
			->setRequired(true)
			->addValidator('NotEmpty')
                        ->addValidator('stringLength', false, array(null,128));
			
		$itemDescription = new Zend_Form_Element_Text('itemDescription');
		$itemDescription->setLabel('Item Description')
			->setRequired(true)
			->addValidator('NotEmpty')
                        ->addValidator('stringLength', false, array(null,1000));
			
		$price = new Zend_Form_Element_Text('price');
		$price->setLabel('Price')
			->setRequired(true)
			->addValidator('Float')
			->addValidator('NotEmpty');
		 
		$dateCreated = new Zend_Date();
    		$dateCreated->get(Zend_Date::ISO_8601);	
			
		$quantity = new Zend_Form_Element_Text('quantity');
		$quantity->setLabel('Quantity')
			->setRequired(true)
			->addValidator('Digits')
			->addValidator('NotEmpty');

		# This should be a drop down based on the category table, right?	
		$category = new Zend_Form_Element_Text('category');
		$category->setLabel('Category')
			->addFilter('StringTrim');

	$submit = new Zend_Form_Element_Submit('submit');
	$submit->setAttrib('inv', 'submitbutton')
		->setLabel('Inventory Updates');
	$this->addElements(array($itemName, $itemDescription, $price, $dateCreated, $quantity, $category, $submit));
	}
}
