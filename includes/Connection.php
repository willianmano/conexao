<?php

require_once ('Config.php');

class Connection {

	private static $connected = false;
	private static $instance = null;
	private static $connection = null;

	public static function getInstance() {
		if(self::$instance === null) {
			self::$instance = new self();
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
	public static function fetchAll($sql, $data) {
		self::connect();
		$stmt = self::$connection->prepare($sql);
		$stmt->execute($data);

		$ret = $stmt->fetchAll();
		
		self::close();

		return $ret;
	}
	public static function execute($sql, $data) {
		self::connect();
		$stmt = self::$connection->prepare($sql);
		$ret = $stmt->execute($data);
		self::close();

		return $ret;
	}
}