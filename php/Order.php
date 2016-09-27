<?php
/*   Order for PHP-SRePS - used to predict quantity to be ordered based on the average of the last 4 weeks of sales.
     Creation Date: 23/09/2016
     version: 1.0           */

   include_once('sale.php');

   $orderPredict = new Sale('1');

   $sqlstring = "SELECT Product.ProductGroupId, Product.Id, Product.Name, ".
                "SUM(CASE WHEN Sale.SaleDateTime <= CURDATE() ".
                    "AND Sale.SaleDateTime > (CURDATE() - INTERVAL 7 DAY) THEN SaleLine.Quantity ELSE 0 END) AS LastWeek, ".
                "SUM(CASE WHEN Sale.SaleDateTime <= (CURDATE() - INTERVAL 7 DAY) ".
                    "AND Sale.SaleDateTime > (CURDATE() - INTERVAL 14 DAY) THEN SaleLine.Quantity ELSE 0 END) AS TwoWeeksAgo, ".
                "SUM(CASE WHEN Sale.SaleDateTime <= (CURDATE() - INTERVAL 14 DAY) ".
                    "AND Sale.SaleDateTime > (CURDATE() - INTERVAL 21 DAY) THEN SaleLine.Quantity ELSE 0 END) AS ThreeWeeksAgo, ".
                "SUM(CASE WHEN Sale.SaleDateTime <= (CURDATE() - INTERVAL 21 DAY) ".
                    "AND Sale.SaleDateTime > (CURDATE() - INTERVAL 28 DAY) THEN SaleLine.Quantity ELSE 0 END) AS FourWeeksAgo, ".
                "CEIL(SUM(CASE WHEN Sale.SaleDateTime > (CURDATE() - INTERVAL 28 DAY) THEN SaleLine.Quantity / 4 ELSE 0 END)) AS REC_STOCK_LEVEL, ".
                    "Product.QuantityOnHand AS QTY_ON_HAND ".
                "FROM Sale JOIN SaleLine ON Sale.ID = SaleLine.SaleId RIGHT OUTER JOIN Product ON SaleLine.ProductId = Product.Id ".
                    "GROUP BY Product.ProductGroupId, Product.Id, Product.Name ".
                    "ORDER BY Product.ProductGroupId, Product.Id";

      $orderPredict->GetData($sqlstring);

?>
