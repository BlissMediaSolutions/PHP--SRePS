<?php
/*   GetSale for PHP-SRePS - used to get the details of a single sale
     Creation Date: 4/09/2016
     version: 1.0           */

    include_once('saleline.php');
    include_once('sale.php');

    //Get the SaleId
    $saleId = $_GET['SaleId'];

    //Get sale details from the DB
    require('settings.php');
    $conn = mysqli_connect($host, $user, $pwd, $sql_db);
    if (mysqli_connect_errno())
    {
        return false;
    }

    $query = "SELECT SaleLine.Id, ProductId, SaleId, Name, Quantity, Product.Price * Quantity AS Cost ".
              "FROM SaleLine ".
              "INNER JOIN Product ON Product.Id = SaleLine.ProductId ".
              "WHERE SaleId = $saleId";

    $result = mysqli_query($conn, $query);
    if ($result == false){
        return false;
    }

    $saleLines = array();
    while($r = mysqli_fetch_array($result)){
        $saleLines[] = SaleLine::getSaleLineFromDBRow($r);
    }

    echo json_encode($saleLines);

    mysqli_free_result($result);
    mysqli_close($conn);
?>