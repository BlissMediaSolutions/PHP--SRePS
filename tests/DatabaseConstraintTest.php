<?php

require_once('DatabaseTestBase.php');

//To run: navigate to the test folder in bash and run the following command:
//phpunit --configuration phpunit.xml DatabaseConstraintTest

class DatabaseConstraintTest extends DatabaseTestBase
{
	//*******************
	//ADDING PRODUCT
	//*******************

	public function testAddingProduct_WhenValidValues_Succeeds()
	{
		$this->checkProductInsertStatementSucceeds(array());
	}

	public function testAddingProduct_WhenNullProductGroupId_Succeeds()
	{
		$this->checkProductInsertStatementSucceeds(array('productGroupId' => 'NULL'));
	}

	public function testAddingProduct_WhenInvalidProductGroupId_Fails()
	{
		$this->checkProductInsertStatementFails(array('productGroupId' => '99999'),
			"FK_Product_ProductGroup");
	}

	public function testAddingProduct_WhenNoName_Fails()
	{
		$this->checkProductInsertStatementFails(array('name' => 'NULL'),
			"Column 'Name' cannot be null");
	}

	public function testAddingProduct_WhenNoQuantityOnHand_Fails()
	{
		$this->checkProductInsertStatementFails(array('quantityOnHand' => 'NULL'),
			"Column 'QuantityOnHand' cannot be null");
	}

	public function testAddingProduct_WhenNoQuantitySold_Fails()
	{
		$this->checkProductInsertStatementFails(array('quantitySold' => 'NULL'),
			"Column 'QuantitySold' cannot be null");
	}

	public function testAddingProduct_WhenNoQuantityToOrder_Fails()
	{
		$this->checkProductInsertStatementFails(array('quantityToOrder' => 'NULL'),
			"Column 'QuantityToOrder' cannot be null");
	}

	public function testAddingProduct_WhenNoQuantityRequested_Fails()
	{
		$this->checkProductInsertStatementFails(array('quantityRequested' => 'NULL'),
			"Column 'QuantityRequested' cannot be null");
	}

	public function testAddingProduct_WhenPricePositive_Succeeds()
	{
		$this->checkProductInsertStatementSucceeds(array('price' => '0.1'));
	}

	public function testAddingProduct_WhenPriceZero_Succeeds()
	{
		$this->checkProductInsertStatementSucceeds(array('price' => '0'));
	}

	public function testAddingProduct_WhenPriceNegative_Fails()
	{
		$this->checkProductInsertStatementFails(array('price' => '-0.1'),
			"Trying to insert a negative value into Product.Price");
	}

	public function testAddingProduct_WhenQuantityOnHandPositive_Succeeds()
	{
		$this->checkProductInsertStatementSucceeds(array('quantityOnHand' => '1'));
	}

	public function testAddingProduct_WhenQuantityOnHandZero_Succeeds()
	{
		$this->checkProductInsertStatementSucceeds(array('quantityOnHand' => '0'));
	}

	public function testAddingProduct_WhenQuantityOnHandNegative_Fails()
	{
		$this->checkProductInsertStatementFails(array('quantityOnHand' => '-1'),
			"Trying to insert a negative value into Product.QuantityOnHand");
	}

	public function testAddingProduct_WhenQuantitySoldPositive_Succeeds()
	{
		$this->checkProductInsertStatementSucceeds(array('quantitySold' => '1'));
	}

	public function testAddingProduct_WhenQuantitySoldZero_Succeeds()
	{
		$this->checkProductInsertStatementSucceeds(array('quantitySold' => '0'));
	}

	public function testAddingProduct_WhenQuantitySoldNegative_Fails()
	{
		$this->checkProductInsertStatementFails(array('quantitySold' => '-1'),
			"Trying to insert a negative value into Product.QuantitySold");
	}

	public function testAddingProduct_WhenQuantityToOrderPositive_Succeeds()
	{
		$this->checkProductInsertStatementSucceeds(array('quantityToOrder' => '1'));
	}

	public function testAddingProduct_WhenQuantityToOrderZero_Succeeds()
	{
		$this->checkProductInsertStatementSucceeds(array('quantityToOrder' => '0'));
	}

	public function testAddingProduct_WhenQuantityToOrderNegative_Fails()
	{
		$this->checkProductInsertStatementFails(array('quantityToOrder' => '-1'),
			"Trying to insert a negative value into Product.QuantityToOrder");
	}
	
	public function testAddingProduct_WhenQuantityRequestedPositive_Succeeds()
	{
		$this->checkProductInsertStatementSucceeds(array('quantityRequested' => '1'));
	}

	public function testAddingProduct_WhenQuantityRequestedZero_Succeeds()
	{
		$this->checkProductInsertStatementSucceeds(array('quantityRequested' => '0'));
	}

	public function testAddingProduct_WhenQuantityRequestedNegative_Fails()
	{
		$this->checkProductInsertStatementFails(array('quantityRequested' => '-1'),
			"Trying to insert a negative value into Product.QuantityRequested");
	}

	//*******************
	//UPDATING PRODUCT
	//*******************

	public function testUpdatingProduct_WhenPricePostive_Succeeds()
	{
		$this->checkProductUpdateStatementSucceeds(array('price' => '0.1'));
	}

	public function testUpdatingProduct_WhenPriceZero_Succeeds()
	{
		$this->checkProductUpdateStatementSucceeds(array('price' => '0'));
	}

	public function testUpdatingProduct_WhenPriceNegative_Fails()
	{
		$this->checkProductUpdateStatementFails(array('price' => '-0.1'),
			"Trying to update a negative value in Product.Price");
	}

	public function testUpdatingProduct_WhenQuantityOnHandPostive_Succeeds()
	{
		$this->checkProductUpdateStatementSucceeds(array('quantityOnHand' => '1'));
	}

	public function testUpdatingProduct_WhenQuantityOnHandZero_Succeeds()
	{
		$this->checkProductUpdateStatementSucceeds(array('quantityOnHand' => '0'));
	}

	public function testUpdatingProduct_WhenQuantityOnHandNegative_Fails()
	{
		$this->checkProductUpdateStatementFails(array('quantityOnHand' => '-1'),
			"Trying to update a negative value in Product.QuantityOnHand");
	}

	public function testUpdatingProduct_WhenQuantitySoldPostive_Succeeds()
	{
		$this->checkProductUpdateStatementSucceeds(array('quantitySold' => '1'));
	}

	public function testUpdatingProduct_WhenQuantitySoldZero_Succeeds()
	{
		$this->checkProductUpdateStatementSucceeds(array('quantitySold' => '0'));
	}

	public function testUpdatingProduct_WhenQuantitySoldNegative_Fails()
	{
		$this->checkProductUpdateStatementFails(array('quantitySold' => '-1'),
			"Trying to update a negative value in Product.QuantitySold");
	}

	public function testUpdatingProduct_WhenQuantityToOrderPostive_Succeeds()
	{
		$this->checkProductUpdateStatementSucceeds(array('quantityToOrder' => '1'));
	}

	public function testUpdatingProduct_WhenQuantityToOrderZero_Succeeds()
	{
		$this->checkProductUpdateStatementSucceeds(array('quantityToOrder' => '0'));
	}

	public function testUpdatingProduct_WhenQuantityToOrderNegative_Fails()
	{
		$this->checkProductUpdateStatementFails(array('quantityToOrder' => '-1'),
			"Trying to update a negative value in Product.QuantityToOrder");
	}

	public function testUpdatingProduct_WhenQuantityRequestedPostive_Succeeds()
	{
		$this->checkProductUpdateStatementSucceeds(array('quantityRequested' => '1'));
	}

	public function testUpdatingProduct_WhenQuantityRequestedZero_Succeeds()
	{
		$this->checkProductUpdateStatementSucceeds(array('quantityRequested' => '0'));
	}

	public function testUpdatingProduct_WhenQuantityRequestedNegative_Fails()
	{
		$this->checkProductUpdateStatementFails(array('quantityRequested' => '-1'),
			"Trying to update a negative value in Product.QuantityRequested");
	}

	//*******************
	//ADDING CUSTOMER
	//*******************

	public function testAddingCustomer_WhenValidValues_Succeeds()
	{
		$this->checkCustomerInsertStatementSucceeds(array());
	}

	public function testAddingCustomer_WhenNullFirstName_Fails()
	{
		$this->checkCustomerInsertStatementFails(array('firstName' => 'NULL'),
			"Column 'FirstName' cannot be null");
	}

	public function testAddingCustomer_WhenNullFamilyName_Fails()
	{
		$this->checkCustomerInsertStatementFails(array('familyName' => 'NULL'),
			"Column 'FamilyName' cannot be null");
	}

	//*******************
	//ADDING SaleLine
	//*******************

	public function testAddingSaleLine_WhenQuantityPositive_Succeeds()
	{
		$oldSaleLineRowCount = $this->getConnection()->getRowCount('SaleLine');
		$result = $this->insertSaleLineWithQuantity(1);
		$newSaleLineRowCount = $this->getConnection()->getRowCount('SaleLine');
		
		$this->assertTrue($result);
		$this->assertEquals($newSaleLineRowCount, $oldSaleLineRowCount + 1);
	}

	public function testAddingSaleLine_WhenQuantityZero_Fails()
	{
		$oldSaleLineRowCount = $this->getConnection()->getRowCount('SaleLine');

		try{
			$this->insertSaleLineWithQuantity(0);
			$this->fail("Expected SQL exception");
		} catch(PDOException $e){
			$this->assertContains("Trying to insert a non-positive value into SaleLine.Quantity", $e->getMessage());
		}
		
		$newSaleLineRowCount = $this->getConnection()->getRowCount('SaleLine');
		$this->assertEquals($newSaleLineRowCount, $oldSaleLineRowCount);
	}

	public function testAddingSaleLine_WhenQuantityNegative_Fails()
	{
		$oldSaleLineRowCount = $this->getConnection()->getRowCount('SaleLine');

		try{
			$this->insertSaleLineWithQuantity(-1);
			$this->fail("Expected SQL exception");
		} catch(PDOException $e){
			$this->assertContains("Trying to insert a non-positive value into SaleLine.Quantity", $e->getMessage());
		}
		
		$newSaleLineRowCount = $this->getConnection()->getRowCount('SaleLine');
		$this->assertEquals($newSaleLineRowCount, $oldSaleLineRowCount);
	}

	//*******************
	//UPDATING SaleLine
	//*******************

	public function testUpdatingSaleLine_WhenQuantityPositive_Succeeds()
	{
		$result = $this->updateSaleLineWithQuantity(1);
		$this->assertTrue($result);
	}

	public function testUpdatingSaleLine_WhenQuantityZero_Fails()
	{
		try{
			$this->updateSaleLineWithQuantity(0);
			$this->fail("Expected SQL exception");
		} catch(PDOException $e){
			$this->assertContains("Trying to update a non-positive value in SaleLine.Quantity", $e->getMessage());
		}
	}

	public function testUpdatingSaleLine_WhenQuantityNegative_Fails()
	{
		try{
			$this->updateSaleLineWithQuantity(-1);
			$this->fail("Expected SQL exception");
		} catch(PDOException $e){
			$this->assertContains("Trying to update a non-positive value in SaleLine.Quantity", $e->getMessage());
		}
	}

	//*******************
	//Helper methods for Product
	//*******************

	//Given an associative array with some product values, populate all missing product
	//values with default values that are known to work.
	private function fillProductArgsWithDefaultValues($productArgs){
		//Default values for columns not provided
		$defaults = array(
			'productGroupId' => '1',
			'name' => 'test',
			'price' => '1.0',
			'quantityOnHand' => '5',
			'quantitySold' => '0',
			'quantityToOrder' => '0',
			'quantityRequested' => '0',
			);
		//Apply defaults
		$productArgs = array_merge($defaults, array_intersect_key($productArgs, $defaults));

		return $productArgs;
	}

	//Attempt to insert a product into the product table, expecting it to succeed
	private function checkProductInsertStatementSucceeds($productArgs){
		$productArgs = $this->fillProductArgsWithDefaultValues($productArgs);

		$oldProductRowCount = $this->getConnection()->getRowCount('Product');
		$result = $this->insertProduct($productArgs);
		$newProductRowCount = $this->getConnection()->getRowCount('Product');
		
		$this->assertTrue($result);
		$this->assertEquals($newProductRowCount, $oldProductRowCount + 1);
	}

	//Attempt to insert a product into the product table, expecting it to fail with a 
	//specified error message.
	private function checkProductInsertStatementFails($productArgs, $expectedErrorMessage){
		$productArgs = $this->fillProductArgsWithDefaultValues($productArgs);
		$oldProductRowCount = $this->getConnection()->getRowCount('Product');

		try{
			$this->insertProduct($productArgs);
			$this->fail("Expected SQL exception");
		} catch(PDOException $e){
			$this->assertContains($expectedErrorMessage, $e->getMessage());
		}
		
		$newProductRowCount = $this->getConnection()->getRowCount('Product');
		$this->assertEquals($newProductRowCount, $oldProductRowCount);
	}

	//Attempts to insert a product, assumes that the provided arguments are complete.
	private function insertProduct($productArgs, &$insertId = NULL){
		//Pull values in the array into their own variables
		list($productGroupId, $name, $price, $quantityOnHand, $quantitySold, 
			$quantityToOrder, $quantityRequested) = array_values($productArgs);

		//surround the name value with quotes where necessary
		$name = $name == "NULL" ? $name : "'" . $name . "'";

		$result = $this->WriteToDatabase("INSERT INTO Product(ProductGroupId, Name," . 
			" Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested)".
			" VALUES(" . $productGroupId . ", " . $name . ", " . $price . ", " . 
			$quantityOnHand . ", " . $quantitySold . ", " . $quantityToOrder . ", " . 
			$quantityRequested . ")", $insertId);

		return $result;
	}

	//Attempt to update a product in the product table with the given values, expecting
	//it to be successful.
	private function checkProductUpdateStatementSucceeds($productArgs){
		$updateStatement = $this->generateProductUpdateStatement($productArgs);
		$result = $this->WriteToDatabase($updateStatement);

		$this->assertTrue($result);
	}

	private function checkProductUpdateStatementFails($productArgs, $expectedErrorMessage){
		$updateStatement = $this->generateProductUpdateStatement($productArgs);

		try{
			$this->WriteToDatabase($updateStatement);
			$this->fail("Expected SQL exception");
		} catch(PDOException $e){
			$this->assertContains($expectedErrorMessage, $e->getMessage());
		}
	}

	//Returns an Update statement for the product table, with the ID of a newly added product.
	private function generateProductUpdateStatement($productArgs){
		$defaultArgs = $this->fillProductArgsWithDefaultValues(array());
		$productId = 0;
		$this->insertProduct($defaultArgs, $productId);

		//Put quotes around 'name' if necessary.
		if (array_key_exists("name", $productArgs)){
			$productArgs["name"] = $productArgs["name"] == "NULL" ? "NULL" : "'" . $productArgs["name"] . "'";
		}

		//Build the update statement
		$updateStatement = "UPDATE Product SET ";
		foreach ($productArgs as $column => $value){
			$updateStatement = $updateStatement . ucfirst($column) . " = " . $value . ", ";
		}
		$updateStatement = rtrim($updateStatement, ", ");
		$updateStatement = $updateStatement . " WHERE Id = " . $productId;

		return $updateStatement;
	}

	//*******************
	//Helper methods for Customer
	//*******************

	//Given an associative array with some customer values, populate all missing customer
	//values with default values that are known to work.
	private function fillCustomerArgsWithDefaultValues($customerArgs){
		//Default values for columns not provided
		$defaults = array(
			'firstName' => 'Smith',
			'familyName' => 'Jane',
			'phoneNumber' => '0412929121',
			);
		//Apply defaults
		$customerArgs = array_merge($defaults, array_intersect_key($customerArgs, $defaults));

		return $customerArgs;
	}

	//Attempt to insert a customer into the customer table, expecting it to succeed
	private function checkCustomerInsertStatementSucceeds($customerArgs){
		$customerArgs = $this->fillCustomerArgsWithDefaultValues($customerArgs);

		$oldCustomerRowCount = $this->getConnection()->getRowCount('Customer');
		$result = $this->insertCustomer($customerArgs);
		$newCustomerRowCount = $this->getConnection()->getRowCount('Customer');
		
		$this->assertTrue($result);
		$this->assertEquals($newCustomerRowCount, $oldCustomerRowCount + 1);
	}

	//Attempt to insert a customer into the customer table, expecting it to fail with a 
	//specified error message.
	private function checkCustomerInsertStatementFails($customerArgs, $expectedErrorMessage){
		$customerArgs = $this->fillCustomerArgsWithDefaultValues($customerArgs);
		$oldCustomerRowCount = $this->getConnection()->getRowCount('Customer');

		try{
			$this->insertCustomer($customerArgs);
			$this->fail("Expected SQL exception");
		} catch(PDOException $e){
			$this->assertContains($expectedErrorMessage, $e->getMessage());
		}
		
		$newCustomerRowCount = $this->getConnection()->getRowCount('Customer');
		$this->assertEquals($newCustomerRowCount, $oldCustomerRowCount);
	}

	//Attempts to insert a customer, assumes that the provided arguments are complete.
	private function insertCustomer($customerArgs, &$insertId = NULL){
		//Pull values in the array into their own variables
		list($firstName, $familyName, $phoneNumber) = array_values($customerArgs);

		//surround the varchar values with quotes where necessary
		$firstName = $firstName == "NULL" ? $firstName : "'" . $firstName . "'";
		$familyName = $familyName == "NULL" ? $familyName : "'" . $familyName . "'";
		$phoneNumber = $phoneNumber == "NULL" ? $phoneNumber : "'" . $phoneNumber . "'";

		$result = $this->WriteToDatabase("INSERT INTO Customer(FirstName," . 
			" FamilyName, PhoneNumber)".
			" VALUES(" . $firstName . ", " . $familyName . ", " . $phoneNumber . ")", $insertId);

		return $result;
	}

	//*******************
	//Helper methods for SaleLine
	//*******************

	//Attempts to insert a SaleLine with the specified quantity value.
	private function insertSaleLineWithQuantity($quantity, &$insertId = NULL){
		//Get a valid product ID by inserting a new product
		$defaultArgs = $this->fillProductArgsWithDefaultValues(array());
		$productId = 0;
		$this->insertProduct($defaultArgs, $productId);

		//Get a valid SaleID by inserting a new sale
		$saleId = 0;
		$this->WriteToDatabase("INSERT INTO Sale(SaleDateTime) VALUES('2016-01-01')", $saleId);

		//Insert SaleLine
		$result = $this->WriteToDatabase("INSERT INTO SaleLine(ProductId, SaleId, Quantity) ".
			"VALUES(" . $productId . ", " . $saleId . ", " . $quantity . ")", $insertId);
		return $result;
	}

	//Attempts to update a SaleLine with the specified quantity value.
	private function updateSaleLineWithQuantity($quantity){
		$saleLineId = 0;
		$this->insertSaleLineWithQuantity(2, $saleLineId);

		$result = $this->WriteToDatabase("UPDATE SaleLine SET Quantity = " . $quantity . 
			" WHERE Id = " . $saleLineId);
		return $result;
	}
}
?>