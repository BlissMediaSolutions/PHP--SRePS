<?php
/* Sale Class for PHP-SRePS
   Creation Date: 4/09/2016
   version: 1.0           */

	include_once('dbase.php');

	class Sale extends dbase
	{
      /* Class variables */
      private $id;
      private $customerId;
      private $saleDateTime;

      /*Class Constructor */
			public function __construct ($id, $customerId, $saleDateTime)
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
	}




?>
