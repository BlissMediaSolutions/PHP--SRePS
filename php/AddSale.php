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
    }
?>
