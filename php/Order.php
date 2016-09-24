<?php
/*   Order for PHP-SRePS - used to predict quantity to be ordered based on the average of the last 4 weeks of sales.
     Creation Date: 23/09/2016
     version: 1.0           */

   include_once('sale.php');

   $orderPredict = new Sale('1');

   $sqlstring = "SELECT Product.ProductGroupId, Product.Id, Product.Name,".
                "SUM(CASE WHEN Sale.SaleDateTime <= CURDATE()".
                      "AND Sale.SaleDateTime > (CURDATE() - INTERVAL 7 DAY) THEN SaleLine.Quantity ELSE 0 END) AS LastWeek,".
                "SUM(CASE WHEN Sale.SaleDateTime <= (CURDATE() - INTERVAL 7 DAY)".
                      "AND Sale.SaleDateTime > (CURDATE() - INTERVAL 14 DAY) THEN SaleLine.Quantity ELSE 0 END) AS TwoWeeksAgo,".
                "SUM(CASE WHEN Sale.SaleDateTime <= (CURDATE() - INTERVAL 14 DAY)".
                      "AND Sale.SaleDateTime > (CURDATE() - INTERVAL 21 DAY) THEN SaleLine.Quantity ELSE 0 END) AS ThreeWeeksAgo,".
                "SUM(CASE WHEN Sale.SaleDateTime <= (CURDATE() - INTERVAL 21 DAY)".
                      "AND Sale.SaleDateTime > (CURDATE() - INTERVAL 28 DAY) THEN SaleLine.Quantity ELSE 0 END) AS FourWeeksAgo,".
		            "(SELECT CEIL(SUM(Quantity)/4)".
			          "FROM SaleLine sl".
                    "JOIN Sale s ON s.Id = sl.SaleId".
                    "WHERE sl.ProductId = Product.Id".
                    "AND s.SaleDateTime > (CURDATE() - INTERVAL 28 DAY)) AS QTY_ORDER".
                "FROM Sale JOIN SaleLine ON Sale.ID = SaleLine.SaleId JOIN Product ON SaleLine.ProductId = Product.Id".
                    "GROUP BY Product.ProductGroupId, Product.Id, Product.Name".
                    "ORDER BY ProductId";

      $orderPredict->GetData($sqlstring);

?>
