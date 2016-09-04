<?php
/*   DisplaySales for PHP-SRePS - used to display all, monthly or weekly sales
     Creation Date: 4/09/2016
     version: 1.0           */

     include_once('saleline.php');
     include_once('sale.php');

     //Get data that was POSTed
     $param = file_get_contents("php://input");

     If ($param = "All")
     {
        $allSale = new Sale('1');
        $sqlstring = "SELECT Sale.ID, Sale.SaleDateTime, SUM(SaleLine.Quantity) AS TotalItems FROM Sale JOIN SaleLine ON Sale.ID = SaleLine.SaleId GROUP BY Sale.ID";
        $allSale->GetData($sqlstring);
        $allSale = null;
     } elseif ($param = "Weekly")
     {
        $allSale = new Sale('1');
        $sqlstring = "SELECT Sale.ID, Sale.SaleDateTime, SUM(SaleLine.Quantity) AS TotalItems JOIN SaleLine ON Sale.ID = SaleLine.SaleId
          Where Sale.SaleDateTime = '2016-09-03' and Sale.SaleDateTime +7 GROUP BY Sale.ID";
        $allSale->GetData($sqlstring);
        $allSale = null;
     } elseif ($parm = "Monthly")
     {
        $allSale = new Sale('1');
        Sqlstring = "";
        $allSale->GetData($sqlstring);
        $allSale = null;
     }

?>
