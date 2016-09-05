<?php
/*   DisplaySales for PHP-SRePS - used to display all, monthly or weekly sales
     Creation Date: 4/09/2016
     version: 1.0           */

     include_once('saleline.php');
     include_once('sale.php');

     //Get data that was POSTed
     $param = file_get_contents("php://input");
     $startdate;

     If ($param = "All")
     {
        $allSale = new Sale('1');
        $sqlstring = "SELECT Sale.ID, Sale.SaleDateTime, SUM(SaleLine.Quantity) AS TotalItems, SUM(Product.Price * Product.QuantitySold) AS TotalValue FROM Sale JOIN SaleLine ON Sale.ID = SaleLine.SaleId JOIN Product ON SaleLine.ProductId = Product.Id GROUP BY Sale.ID";
        $allSale->GetData($sqlstring);
        echo json_encode($allSale);
     } elseif ($param = "Weekly")
     {
       $enddate = new DateTime($startdate);
       $enddate->modify('+1 week');
       $allSale = new Sale('1');
       $sqlstring = "SELECT Sale.ID, Sale.SaleDateTime, SUM(SaleLine.Quantity) AS TotalItems, SUM(Product.Price * Product.QuantitySold) AS TotalValue
          FROM Sale JOIN SaleLine ON Sale.ID = SaleLine.SaleId JOIN Product ON SaleLine.ProductId = Product.Id
          WHERE Sale.SaleDateTime BETWEEN $startdate AND $enddate GROUP BY Sale.ID";
        $allSale->GetData($sqlstring);
        echo json_encode($allSale);
     } elseif ($parm = "Monthly")
     {
       $enddate = new DateTime($startdate);
       $enddate->modify('+1 month');
       $allSale = new Sale('1');
       $sqlstring = "SELECT Sale.ID, Sale.SaleDateTime, SUM(SaleLine.Quantity) AS TotalItems, SUM(Product.Price * Product.QuantitySold) AS TotalValue
          FROM Sale JOIN SaleLine ON Sale.ID = SaleLine.SaleId JOIN Product ON SaleLine.ProductId = Product.Id
          WHERE Sale.SaleDateTime BETWEEN $startdate AND $enddate GROUP BY Sale.ID";
        $allSale->GetData($sqlstring);
        echo json_encode($allSale);
     }

?>
