<?php

  require_once('DatabaseTestBase.php');

  //To run: navigate to the main project folder in bash and run the following command:
  //phpunit --configuration tests/phpunit.xml tests/OrderPredictDBTest.php

  class OrderPredictDBTest extends DatabaseTestBase
  {
	   public function test_OrderPrediction()
	   {
             //Execute the Order Predictions PHP file & return the result
             $result = exec('php php/Order.php');

             //Order.php produces a JSON object, so we need to decode back to an array
             $neworders = json_decode($result, true);

             //Extract the first array, from the collection of arrays
             $orders = array_shift($neworders);
             //print_r($orders);
             $this->assertEquals(1, $orders['ProductGroupId']);
             $this->assertEquals('Painkillers', $orders['ProductGroup']);
             $this->assertEquals(1, $orders['Id']);
             $this->assertEquals('Panadol 500mg 100 tablets', $orders['Name']);
             $this->assertEquals(0, $orders['RecommendedStockLevel']);
             $this->assertEquals(400, $orders['QuantityOnHand']);

             $this->assertNotEquals(5, $orders['ProductGroupId']);
             $this->assertNotEquals(10, $orders['RecommendedStockLevel']);
             $this->assertNotEquals(100, $orders['QuantityOnHand']);
        }
    }

?>
