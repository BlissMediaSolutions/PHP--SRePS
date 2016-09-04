<?php
    
    include_once('saleline.php');
    include_once('sale.php');
    include_once('product.php');

    //Get data that was POSTed
    $param = file_get_contents("php://input");
    $paramObject = json_decode($param, true);
    $saleId = $paramObject['saleId'];
    $itemsArray = $paramObject['items'];
    
    require("settings.php");

    $conn = mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$conn)
    {
        return false;
    }

    //Insert Sale and get ID if sale doesn't exist
    if ($saleId == null || $saleId == 0){
        $sale = new Sale(null, null, date("Y-m-d H:i:s"));
        $sale->addNewSale();
        $saleId = $sale->getId();
    }
    
    //Convert data in the array to saleline objects
    $saleLines = array();
    $saleLineIds = array();
    foreach($itemsArray as $item){
        $saleLines[] = new SaleLine($item["id"], $item["productId"], $saleId, $item["qty"]);
        if ($item["id"] > 0){
            $saleLineIds[] = $item["id"];
        }
    }

    //Get SaleLine objects to delete
    $query = "SELECT * FROM SaleLine WHERE SaleId = $saleId";
    if (count($saleLineIds) > 0){
        $commaSeparatedSaleLineIds = implode(",", $saleLineIds);
        $query = $query . " AND Id NOT IN ($commaSeparatedSaleLineIds)";
    }

    $result = mysqli_query($conn, $query);
    $saleLinesToDelete = array();
    while($r = mysqli_fetch_array($result)){
        $saleLinesToDelete[] = SaleLine::getSaleLineFromDBRow($r);
    }

    //Delete them
    foreach ($saleLinesToDelete as $saleLineToDelete){
        $saleLineToDelete->deleteSaleLine($conn);
    }
    
    //Insert them into the database
    foreach ($saleLines as $saleLine){
        if ($saleLine->getId() > 0){
            continue; //already in the database!
        }
        $saleLine->addNewSaleLine($conn);
    }

    mysqli_close($conn);
?>
