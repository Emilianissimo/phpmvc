<?php

namespace Database;

use Database\DBConn;
use Illuminate\Database\Capsule\Manager as Capsule;

class Database {
	function __construct() {
		$capsule = new Capsule;
		$capsule->addConnection([
		  "driver" => DBConn::DBDRIVER,
		   "host" => DBConn::DBHOST,
		   "database" => DBConn::DBNAME,
		   "username" => DBConn::DBUSER,
		   "password" => DBConn::DBPASS,
		   "charset" => DBConn::CHAR,
		   "collation" => "utf8_unicode_ci",
		   "prefix" => "",
		]);

		$capsule->setAsGlobal();

		$capsule->bootEloquent();
	}
}