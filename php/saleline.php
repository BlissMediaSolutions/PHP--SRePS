<?php
/* Saleline Class for PHP-SRePS
   Creation Date: 26/08/2016
   version: 1.0           */

	include_once('dbase.php');

	class Saleline extends dbase
	{

      /* Class variables */
      private $id;
      private $prodid;
      private $saleid;
      private $quantity;

      /*Class Constructor */
			public function __construct ($id, $prodid, $saleid, $quantity)
			{
					$this->id = $id;
					$this->prodid = $prodid;
					$this->saleid = $saleid;
					$this->quantity = $quantity;
			}

      /* Class Destructor */
		  function __destruct(){
		  }

      /* Set & Get Functions */
      function setId($par){
        $this->id = $par;
      }

      function getId(){
        return $this->$id;
      }

      function setProductId($par){
        $this->prodid = $par;
      }

      function getProductId(){
        return $this->$prodid;
      }

      function setSaleId($par){
        $this->$saleid = $par;
      }

      function getSaleId(){
        return $this->$saleid;
      }

      function setQuantity($par){
        $this->$quantity = $par;
      }

      function getQuantity(){
        return $this->$quantity;
      }

      function addNewSale(){
        $sqltable = "SALELINE";
        $query = "INSERT INTO $sqltable (ProductId, SaleId, Quantity) VALUES ('$this->prodid', '$this->saleid', '$this->$quantity')";
        $result = $this->WriteDelDbase($sqltable, $query);
        return $result;
      }
	}




?>
