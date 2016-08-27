<?php

require_once('DatabaseTestBase.php');

//To run: navigate to the test folder in bash and run the following command:
//phpunit --configuration phpunit.xml DatabaseConstraintTest

class DatabaseConstraintTest extends DatabaseTestBase
{
	public function testAddingProduct_WhenValidProductGroupId_Succeeds()
	{
		$oldProductRowCount = $this->getConnection()->getRowCount('Product');

		$result = $this->WriteToDatabase("INSERT INTO Product(ProductGroupId, Name," . 
			" QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested)".
			" VALUES(1, 'test', 0, 0, 0, 0)");
		
		$newProductRowCount = $this->getConnection()->getRowCount('Product');

		$this->assertTrue($result);
		$this->assertEquals($newProductRowCount, $oldProductRowCount + 1);

	}

	public function testAddingProduct_WhenNullProductGroupId_Succeeds()
	{
		$oldProductRowCount = $this->getConnection()->getRowCount('Product');

		$result = $this->WriteToDatabase("INSERT INTO Product(ProductGroupId, Name," . 
			" QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested)".
			" VALUES(NULL, 'test', 0, 0, 0, 0)");
		
		$newProductRowCount = $this->getConnection()->getRowCount('Product');

		$this->assertTrue($result);
		$this->assertEquals($newProductRowCount, $oldProductRowCount + 1);
	}

	public function testAddingProduct_WhenInvalidProductGroupId_Fails()
	{
		$oldProductRowCount = $this->getConnection()->getRowCount('Product');

		try{
			$result = $this->WriteToDatabase("INSERT INTO Product(ProductGroupId, Name," . 
				" QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested)".
				" VALUES(99999, 'test', 0, 0, 0, 0)");
			$this->fail("Expected SQL exception");
		} catch(PDOException $e){
			$this->assertContains("Integrity constraint violation", $e->getMessage());
		}
		
		$newProductRowCount = $this->getConnection()->getRowCount('Product');
		$this->assertEquals($newProductRowCount, $oldProductRowCount);
	}
}
?>