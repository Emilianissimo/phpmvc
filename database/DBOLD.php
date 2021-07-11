<?php

namespace Database;

use Database\DBConn;

class DB{

	private $pdo;
	private $query;
	private $valuesExec;
	private $options = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	];
	private $dsn = 'mysql:host='.DBConn::HOST.';dbname='.DBConn::DBNAME.';charset='.DBnn::CHAR.';port='.DBConn::PORT;

	public function __construct()
	{
		$this->sqlQuery = "";
		$this->valuesExec = array();
		try{
		$this->pdo = new PDO($this->dsn, DBConn::USER, DBConn::PASS, $this->options);
		}catch(PDOException $pe){
			die('Невозможно подключиться к базе данных: '. $pe->getMessage());
		}
	}

	public function select($table)
	{
		$this->sqlQuery = "SELECT * FROM `$table`";
		return $this;
	}

	public function where($where, $op = '='){ 
		$vals = array(); 
		foreach($where as $k => $v){ 
			$vals[] = "`$k` $op :$k";
			$this->valuesExec[":".$k] = $v; 
		}
		$str = implode(' AND ',$vals); 				
		$this->sqlQuery .= " WHERE " . $str;
		return $this;
	}

	private function dropInstance()
	{
		$this->sqlQuery = '';
		$this->valuesExec = array();
	}

	public function execute()
	{
		$q = $this->pdo->prepare($this->sqlQuery);
		$q->execute($this->valuesExec);

		if ($q->errorCode() != PDO::ERR_NONE) {
			$info = $q->errorInfo();
			die($info[2]);
		}
		// $this->dropInstance(); 
		return $q->fetchall();
	}

}