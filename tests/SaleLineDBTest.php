<?php

require_once('DatabaseTestBase.php');

//To run: navigate to the main project folder in bash and run the following command:
//phpunit --configuration tests/phpunit.xml tests/SaleDBTest.php

class SaleLineDBTest extends DatabaseTestBase
{
        public function test_getSaleLineFromDBRow_ReturnsValidSaleLine()
        {
                //Fetch a product from the DB and try to convert it to a Product object
                require("php/settings.php");
                require_once("php/product.php");
                require_once("php/sale.php");
                require_once("php/saleline.php");

                //Create a sale
                $sale = new Sale(null, null, date("Y-m-d H:i:s"));
                $sale->addNewSale();

                //Create a new saleline
                $saleline = new SaleLine(null, 1, $sale->getId(), 1);

                $conn = mysqli_connect($host, $user, $pwd, $sql_db);
                $saleline->addNewSaleLine($conn);
                $saleLineId = $saleline->getId();

                $result = mysqli_query($conn, "SELECT * FROM SaleLine WHERE Id = $saleLineId");
                $saleLineRow = mysqli_fetch_array($result);

                $saleLine = SaleLine::getSaleLineFromDBRow($saleLineRow);

                $this->assertTrue($saleLine->getId() > 0);
                $this->assertEquals(1, $saleLine->getProductId());
                $this->assertEquals($sale->getId(), $saleLine->getSaleId());
                $this->assertEquals(1, $saleLine->getQuantity());
        }

	public function test_addNewSale_populatesId()
	{
		require_once("php/saleline.php");
		require_once("php/sale.php");
                require("php/settings.php");

        //Create a sale
        $sale = new Sale(null, null, date("Y-m-d H:i:s"));
        $sale->addNewSale();

        //Create a new saleline
        $saleline = new SaleLine(null, 1, $sale->getId(), 1);

        $conn = mysqli_connect($host, $user, $pwd, $sql_db);
        $saleline->addNewSaleLine($conn);

        //Id should be populated
        $this->assertEquals(1, $saleline->getId());
	}

        public function test_addNewSale_UpdatesProduct(){
                //Fetch a product from the DB and try to convert it to a Product object
                require_once("php/saleline.php");
                require_once("php/sale.php");
                require_once("php/product.php");
                require("php/settings.php");

                $conn = mysqli_connect($host, $user, $pwd, $sql_db);
                $result = mysqli_query($conn, 'SELECT * FROM Product WHERE Id = 1');
                $productRow = mysqli_fetch_array($result);
                $product = Product::getProductFromDBRow($productRow);

                //Note initial quantities.
                $productQtyOnHand = $product->getQtyOnHand();
                $productQtySold = $product->getQtySold();

                //Create a sale
                $sale = new Sale(null, null, date("Y-m-d H:i:s"));
                $sale->addNewSale();

                //Create a new saleline
                $saleline = new SaleLine(null, 1, $sale->getId(), 1);
                $saleline->addNewSaleLine($conn);

                //Product quantity should have changed
                $result = mysqli_query($conn, 'SELECT * FROM Product WHERE Id = 1');
                $productRow = mysqli_fetch_array($result);
                $product = Product::getProductFromDBRow($productRow);

                $this->assertEquals($productQtyOnHand - 1, $product->getQtyOnHand());
                $this->assertEquals($productQtySold + 1, $product->getQtySold());
        }

        public function test_deleteSaleLine_DeletesSaleLine(){
                require_once("php/saleline.php");
                require_once("php/sale.php");
                require("php/settings.php");

                //Create a sale
                $sale = new Sale(null, null, date("Y-m-d H:i:s"));
                $sale->addNewSale();

                //Create a new saleline
                $saleline = new SaleLine(null, 1, $sale->getId(), 1);

                $conn = mysqli_connect($host, $user, $pwd, $sql_db);
                $saleline->addNewSaleLine($conn);

                //Note number of salelines
                $saleLines = $this->getConnection()->getRowCount('SaleLine');

                //Request to delete saleline
                $saleline->deleteSaleLine($conn);

                //Should be one less saleline
                $this->assertEquals($saleLines - 1, $this->getConnection()->getRowCount('SaleLine'));
        }

        public function test_deleteSaleLine_UpdatesProduct(){
                require_once("php/saleline.php");
                require_once("php/sale.php");
                require("php/settings.php");

                //Create a sale
                $sale = new Sale(null, null, date("Y-m-d H:i:s"));
                $sale->addNewSale();

                //Create a new saleline
                $saleline = new SaleLine(null, 1, $sale->getId(), 1);

                $conn = mysqli_connect($host, $user, $pwd, $sql_db);
                $saleline->addNewSaleLine($conn);

                //Note product quantities
                $this->getProductQuantities(1, $conn, $productQtyOnHand, $productQtySold);


                //Request to delete saleline
                $saleline->deleteSaleLine($conn);

                //Product quantities should update
                $result = mysqli_query($conn, 'SELECT * FROM Product WHERE Id = 1');
                $productRow = mysqli_fetch_array($result);
                $product = Product::getProductFromDBRow($productRow);

                $this->assertEquals($productQtyOnHand + 1, $product->getQtyOnHand());
                $this->assertEquals($productQtySold - 1, $product->getQtySold());
        }

        public function test_updateSaleLineSameProduct_UpdatesProduct(){
                require_once("php/saleline.php");
                require_once("php/sale.php");
                require("php/settings.php");

                //Create a sale
                $sale = new Sale(null, null, date("Y-m-d H:i:s"));
                $sale->addNewSale();

                //Create a new saleline
                $saleline = new SaleLine(null, 1, $sale->getId(), 1);

                $conn = mysqli_connect($host, $user, $pwd, $sql_db);
                $saleline->addNewSaleLine($conn);

                //Note product quantities
                $this->getProductQuantities(1, $conn, $productQtyOnHand, $productQtySold);

                //Update saleline quantities
                $saleline->setQuantity(3);
                $saleline->updateSaleLine($conn);

                //Product quantities should update
                $result = mysqli_query($conn, 'SELECT * FROM Product WHERE Id = 1');
                $productRow = mysqli_fetch_array($result);
                $product = Product::getProductFromDBRow($productRow);

                $this->assertEquals($productQtyOnHand - 2, $product->getQtyOnHand());
                $this->assertEquals($productQtySold + 2, $product->getQtySold());
        }

        public function test_updateSaleLineDifferentProduct_UpdatesProduct(){
                require_once("php/saleline.php");
                require_once("php/sale.php");
                require("php/settings.php");

                //Create a sale
                $sale = new Sale(null, null, date("Y-m-d H:i:s"));
                $sale->addNewSale();

                //Create a new saleline
                $saleline = new SaleLine(null, 1, $sale->getId(), 1);

                $conn = mysqli_connect($host, $user, $pwd, $sql_db);
                $saleline->addNewSaleLine($conn);

                //Note product quantities
                $this->getProductQuantities(1, $conn, $product1QuantityOnHand, $product1QuantitySold);
                $this->getProductQuantities(2, $conn, $product2QuantityOnHand, $product2QuantitySold);

                //Update saleline product
                $saleline->setProductId(2);
                $saleline->updateSaleLine($conn);

                //Product quantities should update
                $this->getProductQuantities(1, $conn, $product1QuantityOnHandAfter, $product1QuantitySoldAfter);
                $this->getProductQuantities(2, $conn, $product2QuantityOnHandAfter, $product2QuantitySoldAfter);

                $this->assertEquals($product1QuantityOnHand + 1, $product1QuantityOnHandAfter);
                $this->assertEquals($product1QuantitySold -1, $product1QuantitySoldAfter);
                $this->assertEquals($product2QuantityOnHand - 1, $product2QuantityOnHandAfter);
                $this->assertEquals($product2QuantitySold +1, $product2QuantitySoldAfter);
        }

        private function getProductQuantities($productId, $conn, &$quantityOnHand, &$quantitySold){
                $result = mysqli_query($conn, "SELECT * FROM Product WHERE Id = $productId");
                $productRow = mysqli_fetch_array($result);
                $product = Product::getProductFromDBRow($productRow);
                $quantityOnHand = $product->getQtyOnHand();
                $quantitySold = $product->getQtySold();
        }

}
?>