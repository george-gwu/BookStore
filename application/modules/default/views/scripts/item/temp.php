<?php
/**
 * Created by PhpStorm.
 * User: ind
 * Date: 10/25/14
 * Time: 4:37 PM
 */

<ul><?php

    // Create a select query. $db is a Zend_Db_Adapter object, which we assume
    // already exists in your script.
    //$db = Zend_Registry::get('bookstore');
    //$select = $db->select('*')->from('inventory');
    // Get a Paginator object using Zend_Paginator's built-in factory.
    //$paginator = Zend_Paginator::factory($select);

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

    ?></ul>