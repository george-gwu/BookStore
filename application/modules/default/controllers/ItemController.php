<?php
/**
 1) Customers must be able to browse the inventory of items to purchase. When looking for an 
item the customer should be presented with a listing (at least 3 items per screen) of at least the 
following attributes: 
 Item Name 
 Price  Add to cart button
2) The listing of item must also be filterable/sortable by at least the following attributes:
 Category (filter) 
 Price (sortable, low to high) 
 Name (text search) 
3) Each item should be a link (or have a link) to a details page which shows all relevant item 
attributes and includes a button to add the item to the shopping cart. 
 * 
 * 
 * Item Reviews by Customers (required) 
2) The item detail page (from the first set of requirements) should contain all the customer 
comments as a listing. 

 */
class ItemController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function browseAction()
    {
        $form = new Application_Form_Browse();
        $this->view->form = $form;

        // Create an array with numbers 1 to 100
        $data = range(1, 100);

        // Get a Paginator object using Zend_Paginator's built-in factory.
        $paginator = Zend_Paginator::factory($data);

        //Configure Paginator
        $paginator->setDefaultItemCountPerPage( 5 );
        $paginator->setCurrentPageNumber(1);


        //Item Name , Price , Add to cart button

        // Render each item for the current page in a list-item
        foreach ($paginator as $item) {
            echo '<li>' . $item . '</li>';
            echo '<li>' . 'NAME' . '</li>';
            echo '<li>' . 'Price' . '</li>';
            echo '<li>' . '<input type="button" value="Add to Cart" alt="Add to Cart">'.'</li>';


        }

    }
    
}




