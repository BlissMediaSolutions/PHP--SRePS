<?php
require_once('dbase.php');

//Not the best way of doing this, but need a way to access the DB functions!
class DatabaseFunctions extends dbase { }
$databaseFunctions = new DatabaseFunctions();

//Extract the json parameter
$param = file_get_contents("php://input");
$objData = json_decode($param, true);

//Json must contain a field 'functionName' with the function we wish to execute.
switch ($objData['functionName']){
	case 'getProductGroups' :
		$databaseFunctions->getProductGroups();
		break;
	case 'getProductItemName':
		$databaseFunctions->GetProductItemName($objData['productGroupName']);
		break;
}
?>