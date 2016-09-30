<?php
/*   AddEditProduct for PHP-SRePS - used to Add or Edit a Product
     Creation Date: 24/09/2016
     version: 1.0           */

    include_once('product.php');

    //Get parameters
    $productId = $_GET['ProductId'];
    $productGroupId = $_GET['ProductGroupId'];
    $name = $_GET['Name'];
    $price = $_GET['Price'];
    $quantityOnHand = $_GET['QuantityOnHand'];

    //check the price is numeric & greater than 0
    if(!is_numeric($price) OR $price < 0)
    {
        return false;
    }

    //check the qty is numeric & equal to or greater than 0
    if (!is_numeric($quantityOnHand) OR $qty < 0)
    {
        return false;
    }

    //Create a new Product Object, and add it to the Database.  QtySold, QtyToOrder & QtyRequested should be set to 0
    $product = new Product($productId, $productGroupId, $name, $price, $quantityOnHand, '0', '0', '0');
    if ($productId > 0){
        //Product already exists! Update it
        $product->updateProduct();
    }
    else{
        $product->addNewProduct();
    }
?>
