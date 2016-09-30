<?php
include_once('php/product.php');
class ProductTest extends PHPUnit_Framework_TestCase
{
	//Function to run Unit Tests on the Student Class
	public function testProductCreate()
	{
		//Testing Constructor with 1 Paramter
		$thisProduct = new Product('03');
		$this->assertEquals('03', $thisProduct->getId());

		//Testing Constructor with 8 Paramter
		$newProduct = new Product('01', '02', 'Lipitor 20mg Tablets 30', '9.99', '25', '5', '50', '0');

		$this->assertEquals('01', $newProduct->getId());
		$this->assertEquals('02', $newProduct->getProdGroupID());
		$this->assertEquals('Lipitor 20mg Tablets 30', $newProduct->getName());
		$this->assertEquals('9.99', $newProduct->getPrice());
		$this->assertEquals('25', $newProduct->getQtyOnHand());
		$this->assertEquals('5', $newProduct->getQtySold());
		$this->assertEquals('50', $newProduct->getQtyToOrder());
		$this->assertEquals('0', $newProduct->getQtyRequested());

		$this->assertNotEquals('05', $newProduct->getId());
		$this->assertNotEquals('01', $newProduct->getProdGroupID());
		$this->assertNotEquals('Panadol 500mg 100 tablets', $newProduct->getName());
		$this->assertNotEquals('7.25', $newProduct->getPrice());
		$this->assertNotEquals('15', $newProduct->getQtyOnHand());
		$this->assertNotEquals('10', $newProduct->getQtySold());
		$this->assertNotEquals('10', $newProduct->getQtyToOrder());
		$this->assertNotEquals('5', $newProduct->getQtyRequested());

		$newProduct->setId('20');
		$newProduct->setProdGroupID('10');
		$newProduct->setName('Panadol 500mg 100 tablets');
		$newProduct->setPrice('25.99');
		$newProduct->setQtyOnHand('05');
		$newProduct->setQtySold('15');
		$newProduct->setQtyToOrder('10');
		$newProduct->setQtyRequested('10');

		$this->assertEquals('20', $newProduct->getId());
		$this->assertEquals('10', $newProduct->getProdGroupID());
		$this->assertEquals('Panadol 500mg 100 tablets', $newProduct->getName());
		$this->assertEquals('25.99', $newProduct->getPrice());
		$this->assertEquals('05', $newProduct->getQtyOnHand());
		$this->assertEquals('15', $newProduct->getQtySold());
		$this->assertEquals('10', $newProduct->getQtyToOrder());
		$this->assertEquals('10', $newProduct->getQtyRequested());
	}

	//Test that we can correctly serialize a product to JSON
	public function testProductSerialize(){
		$newProduct = new Product('01', '02', 'Lipitor 20mg Tablets 30', '9.99', '25', '5', '50', '0');
		$this->assertEquals(
			'{'.
				'"id":"01",'.
				'"name":"Lipitor 20mg Tablets 30",'.
				'"price":"9.99",'.
				'"quantityOnHand":"25",'.
				'"quantitySold":"5",'.
				'"quantityToOrder":"50",'.
				'"quantityRequested":"0",'.
				'"productGroupId":"02",'.
				'"productGroupName":null'.
				'}', 
			json_encode($newProduct));
	}
}
?>
