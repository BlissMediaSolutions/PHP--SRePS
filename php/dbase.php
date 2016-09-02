<?php
/* Database Class for The Book Exchaange
Creation Date: 26/08/2016
version: 1.0      */

include_once('settings.php');

abstract class dbase
{

    //Function to Write,delete or Amend a record in the Database
    function WriteDelDbase($sqltable, $query, &$insertID = NULL)
    {
        require("settings.php");
        $conn = mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$conn)
        {
            //echo "<p><font color='red'> Error Connecting to Database </font></p>";
            return false;
        } else
        {
            $result = mysqli_query($conn, $query);
            if ($insertID !== NULL) {
            	$insertID = mysqli_insert_id($conn);
		    }
            mysqli_close($conn);
            if (!$result) {
                return false;
            }
            return true;
        }
    }

    //function to return the last created SaleID, ProductID etc;
    function GetLastID($sqltable, $query)
    {
        require("settings.php");
        $conn = mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$conn)
        {
            return false;
        } else {
            $result = mysql_query($conn, $query);
            //return $result;
        }
        mysqli_close($conn);
        if ($result) {
            return false;
        }
        return $result;
     }

     //function which performs a Dbase query based on the SQL String ($par) passed & returns the results as JSON.
     function GetData($par)
     {
        require("settings.php");
        $conn = mysqli_connect($host, $user, $pwd, $sql_db);

        if (mysqli_connect_errno())
        {
            return false;
        }

        //$query = "SELECT Product.Name FROM Product INNER JOIN ProductGroup on Product.ProductGroupId = ProductGroup.Id WHERE ProductGroup.Name = $par";
        $result = mysqli_query($conn, $par);

        $rows = array();
        while($r = mysqli_fetch_array($result)) {
          $rows[] = $r;
          }
        echo json_encode($rows);

        mysqli_close($conn);
     }

 }

 ?>
