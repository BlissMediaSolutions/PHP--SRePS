<?php

require_once('DatabaseTestBase.php');

//To run: navigate to the main project folder in bash and run the following command:
//phpunit --configuration tests/phpunit.xml tests/SaleDBTest.php

class SaleLineDBTest extends DatabaseTestBase
{
	public function test_addNewSale_populatesId()
	{
		//Fetch a product from the DB and try to convert it to a Product object
		require_once("php/saleline.php");
		require_once("php/sale.php");

        //Create a sale
        $sale = new Sale(null, null, date("Y-m-d H:i:s"));
        $sale->addNewSale();

        //Create a new saleline
        $saleline = new SaleLine(null, 1, $sale->getId(), 1);
        $saleline->addNewSaleLine();

        //Id should be populated
        $this->assertEquals(1, $saleline->getId());
	}
}
?>