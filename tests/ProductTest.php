<?php
include_once('php/product.php');
class ProductTest extends PHPUnit_Framework_TestCase
{
	//Function to run Unit Tests on the Student Class
	public function testProductCreate()
	{
	        //Testing Basic Constructor
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

		}
}
?>
