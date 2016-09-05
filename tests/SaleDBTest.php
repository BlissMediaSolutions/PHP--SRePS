<?php

require_once('DatabaseTestBase.php');

//To run: navigate to the main project folder in bash and run the following command:
//phpunit --configuration tests/phpunit.xml tests/SaleDBTest.php

class SaleDBTest extends DatabaseTestBase
{
	public function test_addNewSale_populatesId()
	{
		require_once("php/sale.php");

        //Create a sale
        $sale = new Sale(null, null, date("Y-m-d H:i:s"));
        $sale->addNewSale();

        //Id should be populated
        $this->assertEquals(1, $sale->getId());
	}

	public function test_deleteSale_deletesSale()
	{
		require_once("php/sale.php");
		require("php/settings.php");
		$conn = mysqli_connect($host, $user, $pwd, $sql_db);

        //Create a sale
        $sale = new Sale(null, null, date("Y-m-d H:i:s"));
        $sale->addNewSale();

        //Note number of sales and salelines
        $saleCount = $this->getConnection()->getRowCount('Sale');
        $saleLineCount = $this->getConnection()->getRowCount('SaleLine');

        //Request to delete the sale
        $sale->deleteSale($conn);

        //Count of sales should reduce, salelines should not change
        $this->assertEquals($saleCount - 1, $this->getConnection()->getRowCount('Sale'));
        $this->assertEquals($saleLineCount, $this->getConnection()->getRowCount('SaleLine'));
	}

	public function test_deleteSale_deletesAllSaleLines()
	{
		require_once("php/sale.php");
		require("php/settings.php");
		$conn = mysqli_connect($host, $user, $pwd, $sql_db);

        //Create a sale
        $sale = new Sale(null, null, date("Y-m-d H:i:s"));
        $sale->addNewSale();

        //Create some SaleLines
        $saleline = new SaleLine(null, 1, $sale->getId(), 1);
        $saleline->addNewSaleLine($conn);
        $saleline = new SaleLine(null, 1, $sale->getId(), 2);
        $saleline->addNewSaleLine($conn);

        //Note number of salelines
        $saleLineCount = $this->getConnection()->getRowCount('SaleLine');

        //Deleting sale should delete salelines
        $sale->deleteSale($conn);
        $this->assertEquals($saleLineCount - 2, $this->getConnection()->getRowCount('SaleLine'));
	}

	public function test_deleteSale_adjustsProductQuantities()
	{
		require_once("php/sale.php");
		require("php/settings.php");
		$conn = mysqli_connect($host, $user, $pwd, $sql_db);

        //Create a sale
        $sale = new Sale(null, null, date("Y-m-d H:i:s"));
        $sale->addNewSale();

        //Create some SaleLines
        $saleline = new SaleLine(null, 1, $sale->getId(), 1);
        $saleline->addNewSaleLine($conn);
        $saleline = new SaleLine(null, 1, $sale->getId(), 2);
        $saleline->addNewSaleLine($conn);

        //Note number of product quantities
        $result = mysqli_query($conn, 'SELECT * FROM Product WHERE Id = 1');
        $productRow = mysqli_fetch_array($result);
        $product = Product::getProductFromDBRow($productRow);
        $productQtyOnHand = $product->getQtyOnHand();
        $productQtySold = $product->getQtySold();

        //Deleting sale should change product quantities correctly
        $sale->deleteSale($conn);

        $result = mysqli_query($conn, 'SELECT * FROM Product WHERE Id = 1');
        $productRow = mysqli_fetch_array($result);
        $product = Product::getProductFromDBRow($productRow);

        $this->assertEquals($productQtyOnHand + 3, $product->getQtyOnHand());
        $this->assertEquals($productQtySold - 3, $product->getQtySold());
	}
}
?>