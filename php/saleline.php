<?php
/* Saleline Class for PHP-SRePS
   Creation Date: 26/08/2016
   version: 1.0           */

	include_once('dbase.php');
  include_once('product.php');

	class Saleline extends dbase implements JsonSerializable
	{

      /* Class variables - map directly to SaleLine DB table */
      private $id;
      private $prodid;
      private $saleid;
      private $quantity;

      /* Class variables - other useful properties not in the SaleLine DB table */
      private $productName;
      private $cost;

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
        return $this->id;
      }

      function setProductId($par){
        $this->prodid = $par;
      }

      function getProductId(){
        return $this->prodid;
      }

      function setSaleId($par){
        $this->saleid = $par;
      }

      function getSaleId(){
        return $this->saleid;
      }

      function setQuantity($par){
        $this->quantity = $par;
      }

      function getQuantity(){
        return $this->quantity;
      }

      function setProductName($par){
        $this->productName = $par;
      }

      function getProductName(){
        return $this->productName;
      }

      function setCost($par){
        $this->cost = floatval($par);
      }

      function getCost(){
        return $this->cost;
      }

      //Insert a SaleLine into the database, and update the associated product's quantity.
      function addNewSaleLine($conn){
        $sqltable = "SaleLine";
        $query = "INSERT INTO $sqltable (ProductId, SaleId, Quantity) VALUES ($this->prodid, $this->saleid, $this->quantity)";
        
        $insertId = 0;
        $result = $this->WriteDelDbase($sqltable, $query, $insertId);

        $this->setId($insertId);

        //Go and update the associated product
        $query = "SELECT * FROM Product WHERE Id = $this->prodid";
        $result = mysqli_query($conn, $query);
        $resultRow = mysqli_fetch_array($result);
        $thisProduct = Product::getProductFromDBRow($resultRow);

        $thisProduct->updateProductData($this->quantity);

        return $result;
      }

      //Delete a SaleLine from the database, and update the associated product's quantity
      function deleteSaleLine($conn){
        //Get the relevant product
        $query = "SELECT * FROM Product WHERE Id = $this->prodid";
        $result = mysqli_query($conn, $query);
        $resultRow = mysqli_fetch_array($result);
        $thisProduct = Product::getProductFromDBRow($resultRow);

        //Reduce quantity by the specified amount
        $productQtyChange = $this->getQuantity() * -1;
        $thisProduct->updateProductData($productQtyChange);

        //Delete the Saleline
        $sqltable = "SaleLine";
        $query = "DELETE FROM $sqltable WHERE Id = $this->id";
        $this->WriteDelDbase($sqltable, $query);
      }

      /*Given a row from the database representing a saleline with Id, ProductId, SaleId, ProductName, Quantity and cost,
       construct and return the SaleLine*/
      public static function getSaleLineFromDBRow($dbRow){
        $newSaleLine = new self($dbRow['Id'], $dbRow['ProductId'], $dbRow['SaleId'], $dbRow['Quantity']);

        if (array_key_exists(('Name'), $dbRow)){
          $newSaleLine->setProductName($dbRow['Name']);
        }
        if (array_key_exists(('Cost'), $dbRow)){
          $newSaleLine->setCost($dbRow['Cost']);
        }

        return $newSaleLine;
      }

      //Provide an implementation for converting a saleline to JSON.
      public function jsonSerialize(){
        return [
          'id' => $this->getId(),
          'productId' => $this->getProductId(),
          'saleId' => $this->getSaleId(),
          'qty' => $this->getQuantity(),
          'name' => $this->getProductName(),
          'cost' => $this->getCost()
        ];
      }
	}
?>
