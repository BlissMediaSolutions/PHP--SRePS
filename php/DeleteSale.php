<?php
    /*   DeleteSale for PHP-SRePS - used to delete a single sale and all its salelines
     Creation Date: 5/09/2016
     version: 1.0           */
    include_once('saleline.php');
    include_once('sale.php');

    //Establish DB connection
    require('settings.php');
    $conn = mysqli_connect($host, $user, $pwd, $sql_db);
    if (mysqli_connect_errno())
    {
        return false;
    }

    //Get the SaleId to delete
    $saleId = $_GET['SaleId'];

    //Delete the sale
    $sale = new Sale($saleId);
    $sale->deleteSale($conn);

    mysqli_close($conn);
?>