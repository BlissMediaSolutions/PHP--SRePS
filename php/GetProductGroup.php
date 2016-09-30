<?php

    include_once('product.php');

    $prodGroupId = $_GET['ProductGroupId'];  //Get the Product Group Selected

    require("settings.php");
    $conn = mysqli_connect($host, $user, $pwd, $sql_db);

    if (mysqli_connect_errno())
    {
        return false;
    }
    $query = "SELECT * FROM Product WHERE ProductGroupId = $prodGroupId AND QuantityOnHand > 0 AND IsHidden = 0";

    $result = mysqli_query($conn, $query);

    $products = array();
    while($r = mysqli_fetch_array($result)) {
        $products[] = Product::getProductFromDBRow($r);
    }

    echo json_encode($products);

    mysqli_free_result($result);
    mysqli_close($conn);
?>
