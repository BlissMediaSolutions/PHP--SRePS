<?php

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