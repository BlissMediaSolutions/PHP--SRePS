<?php

    include_once('product.php');

    $productId = $_GET['ProductId'];  //Get the Product Group Selected

    require("settings.php");
    $conn = mysqli_connect($host, $user, $pwd, $sql_db);

    if (mysqli_connect_errno())
    {
        return false;
    }

    $query = "SELECT ProductGroupId FROM Product WHERE Id = $productId";
    $result = mysqli_query($conn, $query);
    $productGroupId = mysqli_fetch_row($result)[0];

    $query = "SELECT * FROM Product WHERE ProductGroupId = $productGroupId AND (Id = $productId OR IsHidden = 0)";
    $result = mysqli_query($conn, $query);

    $products = array();
    while($r = mysqli_fetch_array($result)) {
        $products[] = Product::getProductFromDBRow($r);
    }

    $json = "{
        \"productGroupId\" : \"$productGroupId\",
        \"products\" : " . json_encode($products) .
    "}";

    echo $json;

    mysqli_free_result($result);
    mysqli_close($conn);
?>
