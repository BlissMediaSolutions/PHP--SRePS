<?php
include_once('php/saleline.php');
class SaleLineTest extends PHPUnit_Framework_TestCase
{
	//Function to run Unit Tests on the Student Class
	public function testSaleLineCreate()
	{
	        //Testing Basic Constructor
          $newSale = new Saleline('01', '02', '03', '45');

					$this->assertEquals('01', $newSale->getId());
					$this->assertEquals('02', $newSale->getProductId());
					$this->assertEquals('03', $newSale->getSaleId());
					$this->assertEquals('45', $newSale->getQuantity());

					$this->assertNotEquals('03', $newSale->getId());
					$this->assertNotEquals('01', $newSale->getProductId());
					$this->assertNotEquals('02', $newSale->getSaleId());
					$this->assertNotEquals('54', $newSale->getQuantity());

		}
}
?>
