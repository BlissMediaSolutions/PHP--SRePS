<?php
/* Sale Class for PHP-SRePS
   Creation Date: 4/09/2016
   version: 1.0           */

	include_once('dbase.php');
  include_once('saleline.php');

	class Sale extends dbase
	{
      /* Class variables */
      private $id;
      private $customerId;
      private $saleDateTime;

			/* Main Class Constructor 					*/
			/* Note: as PHP doesnt allow overloading constructors this hack/woraround was used to overload the constructor */
			public function __construct ()
			{
				$get_arguments       = func_get_args();
		    $number_of_arguments = func_num_args();
		    // call a constructor in the format of __constructX, where X is the number of agruments.
		    if (method_exists($this, $method_name = '__construct'.$number_of_arguments)){
		      		call_user_func_array(array($this, $method_name), $get_arguments);
		      	} else {
		        	error_log("Undefined function: " . '__construct' . $number_of_arguments . '  in class: ' . get_class($this), 0);
		      	}
			}

			/* Class Constructor with 1 argument */
			public function __construct1 ($id)
			{
					$this->id = $id;
			}

      /*Class Constructor with 3 arguments  */
			public function __construct3 ($id, $customerId, $saleDateTime)
			{
					$this->id = $id;
					$this->customerId = $customerId;
					$this->saleDateTime = $saleDateTime;
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

      function setCustomerId($par){
        $this->customerId = $par;
      }

      function getCustomerId(){
        return $this->customerId;
      }

      function setSaleDatetime($par){
        $this->saleDateTime = $par;
      }

      function getSaleDateTime(){
        return $this->saleDateTime;
      }

      //Add this Sale object to the database, populating its ID.
      function addNewSale(){
        $sqltable = "Sale";
        $customerId = $this->customerId == null ? 'null' : $this->customerId;
        $query = "INSERT INTO $sqltable (CustomerId, SaleDateTime) VALUES($customerId, '$this->saleDateTime')";
        $insertId = 1;
        $result = $this->WriteDelDbase($sqltable, $query, $insertId);

        $this->id = $insertId;
        return $result;
      }

			function deleteSale($conn){
        $sqltable = "Sale";

        //Get all corresponding salelines
        $query = "SELECT Id, ProductId, SaleId, Quantity ".
                  "FROM SaleLine ".
                  "WHERE SaleId = $this->id";
        $result = mysqli_query($conn, $query);

        $saleLines = array();
        while($r = mysqli_fetch_array($result)){
            $saleLines[] = SaleLine::getSaleLineFromDBRow($r);
        }

        //Delete all salelines
        foreach($saleLines as $saleLine){
            $saleLine->deleteSaleLine($conn);
        }

        //Delete the sale
        $query = "DELETE FROM $sqltable WHERE Id = $this->id";
        $this->WriteDelDbase($sqltable, $query);
      }
	}
?>
