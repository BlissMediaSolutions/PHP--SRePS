<?php

    include_once('product.php');

    $prodgroupname = $_GET['ProdGroupName'];  //Get the Product Group Selected

    require("settings.php");
    $conn = mysqli_connect($host, $user, $pwd, $sql_db);

    if (mysqli_connect_errno())
    {
        return false;
    }
    $query = "SELECT Product.Name FROM Product INNER JOIN ProductGroup on Product.ProductGroupId = ProductGroup.Id WHERE ProductGroup.Name = '$prodgroupname'";
    $result = mysqli_query($conn, $query);

    $prodgroupid = mysqli_fetch_field($result);

    mysqli_free_result($result);
    mysqli_close($conn);

    $newProduct = new Product($prodgroupid);
    $newProduct->GetData($query);
?>
