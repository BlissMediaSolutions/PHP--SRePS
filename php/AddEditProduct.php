<?php
/*   AddEditProduct for PHP-SRePS - used to Add or Edit a Product
     Creation Date: 24/09/2016
     version: 1.0           */

    include_once('product.php');

    //Get parameters
    $prodGroupID = $_GET['ProductGroupId'];
    $name = $_GET['Name'];
    $price = $_GET['Price'];
    $qty = $_GET['Qty'];

    //check the price is numeric & greater than 0
    if(!is_numeric($price) OR $price < 1)
    {
        return false;
    }

    //check the qty is numeric & equal to or greater than 0
    if (!is_numeric($qty) OR $qty < 0)
    {
        return false;
    }

    //Create a new Product Object, and add it to the Database.  QtySold, QtyToOrder & QtyRequested should be set to 0
    $newProduct = new Product('1', $prodGroupID, $name, $price, $qty, '0', '0', '0');
    $newProduct->addNewProduct();








?>
