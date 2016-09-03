<?php

    include_once('saleline.php');
    include_once('sale.php');

    //Get data that was POSTed
    $param = file_get_contents("php://input");
    $itemsArray = json_decode($param, true);

    require("settings.php");

    //Insert Sale and get ID
    $sale = new Sale(null, null, date("Y-m-d H:i:s"));
    $sale->addNewSale();

    //Convert data in the array to saleline objects
    $saleLines = array();
    foreach($itemsArray as $item){
        $saleLines[] = new SaleLine(null, $item["productId"], $sale->getId(), $item["qty"]);
    }

    //Insert them into the database
    foreach ($saleLines as $saleLine){
          $saleLine->addNewSaleLine();

        //Get the Product ID & create a new product
        $prodid = $saleLine->getProductId();
        $qty = $saleLine->getQuantity();

        // Get the Product Group ID for the relevant Product
        require("settings.php");
        $query = "SELECT ProductGroupId FROM Product WHERE Id = $prodid";
        $conn = mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$conn)
        {
            return false;
        } else {
            $result = mysql_query($conn, $query);
            //return $result;
        }
        mysqli_close($conn);

        // Create a new Product
        $thisProduct = new Product($result);
        
        //Update the Product table Qty's for the new Sale.
        $thisProduct->UpdateProductData($prodid, $qty);


    }
?>
