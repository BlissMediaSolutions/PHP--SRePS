<?php
/* Product Class for PHP-SRePS
   Creation Date: 26/08/2016
   version: 1.0           */

	include_once('dbase.php');

	class Product extends dbase
	{

      /* Class variables */
      private $id;
      private $prodgroupid;
      private $name;
      private $price;
      private $qtyOnHand;
      private $qtySold;
      private $qtyToOrder;
      private $qtyRequested;

		/* Main Class Constructor 					*/
		/* Note: as PHP doesnt allow overloading constructors this hack/woraround was used to overload the constructor */
		public function __construct ()
		{
				$get_arguments       = func_get_args();
	      $number_of_arguments = func_num_args();
	        // call a constructor in the format of __constructX, where X is the number of agruments.
	      if (method_exists($this, $method_name = '__construct'.$number_of_arguments))
				{
	          call_user_func_array(array($this, $method_name), $get_arguments);
	      } else
				{
	        	error_log("Undefined function: " . '__construct' . $number_of_arguments . '  in class: ' . get_class($this), 0);
	      }
		}

		public function __construct1 ($prodgroupid)
		{
				$this->prodgroupid = $prodgroupid;
		}

		/*Class Constructor with 8 arguments*/
		public function __construct8 ($id, $prodgroupid, $name, $price, $qtyOnHand, $qtySold, $qtyToOrder, $qtyRequested)
		{
			$this->id = $id;
			$this->prodgroupid = $prodgroupid;
			$this->name = $name;
			$this->price = $price;
			$this->qtyOnHand = $qtyOnHand;
			$this->qtySold = $qtySold;
			$this->qtyToOrder = $qtyToOrder;
			$this->qtyRequested = $qtyRequested;
		}

      /* Class Destructor */
      function __destruct(){
      }

			/* Set & Get Functions */
			function setId($par){
				$this->id = $par;
			}

			function getId(){
				return $this->id;
			}

			function setProdGroupID($par){
				$this->prodgroupid = $par;
			}

			function getProdGroupID(){
				return $this->prodgroupid;
			}

			function setName($par){
				$this->name = $par;
			}

			function getName(){
				return $this->name;
			}

			function setPrice($par){
				$this->price = $par;
			}

			function getPrice(){
				return $this->price;
			}

			function setQtyOnHand($par){
				$this->qtyOnHand = $par;
			}

			function getQtyOnHand(){
				return $this->qtyOnHand;
			}

			function setQtySold($par){
				$this->qtySold = $par;
			}

			function getQtySold(){
				return $this->qtySold;
			}

			function setQtyToOrder($par){
				$this->qtyToOrder = $par;
			}

			function getQtyToOrder(){
				return $this->qtyToOrder;
			}

			function setQtyRequested($par){
				$this->qtyRequested = $par;
			}

			function getQtyRequested(){
				return $this->qtyRequested;
			}

			function addNewProduct(){
        $sqltable = "PRODUCT";
        $query = "INSERT INTO $sqltable (ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested)
					VALUES ('$this->prodgroupid', '$this->name', '$this->price', '$this->qtyOnHand', '$this->qtySold', '$this->qtyToOrder', '$this->qtyRequested')";
        $result = $this->WriteDelDbase($sqltable, $query);
        return $result;
      }

}
