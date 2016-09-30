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

        public function test_addNewProduct_addsProduct()
        {
                require("php/settings.php");
                require_once("php/product.php");

                //Get number of products
                $productCount = $this->getConnection()->getRowCount('Product');

                //Create a product
                $product = new Product(null, 1, 'Test', '3.5', 2, 0, 0, 0);
                $product->addNewProduct();

                //Should be a new product
                $this->assertEquals($productCount + 1, $this->getConnection()->getRowCount('Product'));

                //Product should have correct values
                $conn = mysqli_connect($host, $user, $pwd, $sql_db);
                $result = mysqli_query($conn, 'SELECT * FROM Product WHERE Id = 16');
                $productRow = mysqli_fetch_array($result);
                $addedProduct = Product::getProductFromDBRow($productRow);

                $this->assertEquals(1, $addedProduct->getProdGroupID());
                $this->assertEquals('Test', $addedProduct->getName());
                $this->assertEquals(3.5, $addedProduct->getPrice());
                $this->assertEquals(2, $addedProduct->getQtyOnHand());
                $this->assertEquals(0, $product->getQtySold());
                $this->assertEquals(0, $product->getQtyToOrder());
                $this->assertEquals(0, $product->getQtyRequested());
        }

        public function test_updateProduct_updatesProduct()
        {
                require("php/settings.php");
                require_once("php/product.php");

                //Get number of products
                $productCount = $this->getConnection()->getRowCount('Product');

                //Create an updated product
                $product = new Product(1, 2, 'Test', 2.1, 3, 4, 5, 6);
                $product->updateProduct();

                //Should be the same number of products
                $this->assertEquals($productCount, $this->getConnection()->getRowCount('Product'));

                //Product should have correct values
                $conn = mysqli_connect($host, $user, $pwd, $sql_db);
                $result = mysqli_query($conn, 'SELECT * FROM Product WHERE Id = 1');
                $productRow = mysqli_fetch_array($result);
                $addedProduct = Product::getProductFromDBRow($productRow);

                $this->assertEquals(2, $addedProduct->getProdGroupID());
                $this->assertEquals('Test', $addedProduct->getName());
                $this->assertEquals(2.1, $addedProduct->getPrice());
                $this->assertEquals(3, $addedProduct->getQtyOnHand());
                $this->assertEquals(4, $product->getQtySold());
                $this->assertEquals(5, $product->getQtyToOrder());
                $this->assertEquals(6, $product->getQtyRequested());
        }
}
?>