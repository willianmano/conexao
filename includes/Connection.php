<?php

require_once ('Config.php');

class Connection {

	private static $connected = false;
	private static $instance;
	private static $connection = null;

	private function __construct() {
		//echo 'Essa classe nao deve ser instanciada! Utilize Connection::getInstance()';
	}
	public function __clone() {
		trigger_error('Clone nao e permitido.', E_USER_ERROR);
	}
	public static function getInstance() {
		if(!isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	private function connect () {
		if(!self::$connected) {
			try {
				$dns = "mysql:host=" . DB_HOST . ";dbname=" . DB_SCHEMA;
				self::$connection = new PDO($dns, DB_USER, DB_PASS);
				self::$connected = true;
			} catch(PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage( ); return false;
			}
		}
	}
	private function close() {
		self::$connection = null;
		self::$connected = false;
	}
	public static function fetchAll($sql, $data = array()) {
		self::connect();
		$stmt = self::$connection->prepare($sql);
		$stmt->execute($data);

		$ret = $stmt->fetchAll();
		
		self::close();

		return $ret;
	}
	public static function execute($sql, $data  = array()) {
		self::connect();
		$stmt = self::$connection->prepare($sql);
		$ret = $stmt->execute($data);
		self::close();

		return $ret;
	}
}