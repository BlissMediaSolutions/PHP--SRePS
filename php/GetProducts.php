<?php
    include_once('product.php');
    require("settings.php");
    $conn = mysqli_connect($host, $user, $pwd, $sql_db);

    if (mysqli_connect_errno())
    {
        return false;
    }
    
    $query = 'SELECT ProductGroup.Name ProductGroupName, Product.* '.
        'FROM Product JOIN ProductGroup ON ProductGroup.Id = ProductGroupId '.
        'WHERE IsHidden = 0 ' .
        'ORDER BY ProductGroupName, Product.Name';

    $result = mysqli_query($conn, $query);

    $products = array();
    while($r = mysqli_fetch_array($result)) {
        $products[] = Product::getProductFromDBRow($r);
    }

    echo json_encode($products);

    mysqli_free_result($result);
    mysqli_close($conn);
?>