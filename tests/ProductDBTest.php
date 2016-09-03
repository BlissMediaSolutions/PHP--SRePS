<?php

require_once('DatabaseTestBase.php');

//To run: navigate to the main project folder in bash and run the following command:
//phpunit --configuration tests/phpunit.xml tests/ProductDBTest.php

class ProductDBTest extends DatabaseTestBase
{
	public function test_getProductFromDBRow_ReturnsValidProduct()
	{
		//Fetch a product from the DB and try to convert it to a Product object
		require("php/settings.php");
		require_once("php/product.php");

        $conn = mysqli_connect($host, $user, $pwd, $sql_db);
        $result = mysqli_query($conn, 'SELECT * FROM Product WHERE Id = 1');

        $productRow = mysqli_fetch_array($result);

        $product = Product::getProductFromDBRow($productRow);

        $this->assertEquals(1, $product->getId());
        $this->assertEquals(1, $product->getProdGroupID());
        $this->assertEquals('Panadol 500mg 100 tablets', $product->getName());
        $this->assertEquals(9.99, $product->getPrice());
        $this->assertEquals(400, $product->getQtyOnHand());
        $this->assertEquals(0, $product->getQtySold());
        $this->assertEquals(0, $product->getQtyToOrder());
        $this->assertEquals(0, $product->getQtyRequested());
	}
}
?>