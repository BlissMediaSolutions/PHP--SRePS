<?php

//Small hack: when PHPUnit attempts to truncate tables before running tests
//on TravisCI, it fails due to foreign key checks preventing the truncation.
//To fix this, we'll turn off foreign key checks before truncating,
//and turn them back on afterwards.
//Fix found here http://stackoverflow.com/a/10331869/5740181 accessed 28/08/2016
class TruncateOperation extends \PHPUnit_Extensions_Database_Operation_Truncate
{
	public function execute(\PHPUnit_Extensions_Database_DB_IDatabaseConnection $connection,
						 \PHPUnit_Extensions_Database_DataSet_IDataSet $dataSet)
    {
    	$connection->getConnection()->query("SET foreign_key_checks = 0");
    	parent::execute($connection, $dataSet);
    	$connection->getConnection()->query("SET foreign_key_checks = 1");
    }
}

abstract class DatabaseTestBase extends PHPUnit_Extensions_Database_TestCase
{
	//Only instantiate pdo once for test clean-up/fixture load
	static private $pdo = null;

	//Only instantiate the connection once per test
	protected $conn = null;

	public function __construct()
	{
		$ds = new PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
	}

	final public function getConnection()
	{
		if ($this->conn === null){
			if (self::$pdo == null){
				self::$pdo = new PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
			}
			$this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
		}

		return $this->conn;
	}

	public function getDataSet()
	{
		return $this->createMySQLXMLDataSet('file.xml');
	}

	//Hacking around the truncate issue by telling PHPUnit to use our special 'TruncateOpeartion'
	//class whenever it does its truncates before running tests.
	public function getSetUpOperation()
	{
		$cascadeTruncates = false;

		return new \PHPUnit_Extensions_Database_Operation_Composite(array(new TruncateOperation($cascadeTruncates), \PHPUnit_Extensions_Database_Operation_Factory::INSERT()));
	}

	protected function WriteToDatabase($query, &$insertID = NULL)
	{
		$result = self::$pdo->query($query);

		if ($insertID !== NULL){
			$insertID = self::$pdo->lastInsertId();
		}

		if (!$result){
			return false;
		}
		return true;
	}
}
?>