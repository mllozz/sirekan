<?php

class Database {
	
	private $_connection;

	//simpan single instance
	private static $_instance;

	/**
	* Get instance dari database
	* @return type database
	*/
	public static function getInstance() {
		if(!self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		$this->_connection = new mysqli('localhost','root','','sirekan');

		//error handling
		if(mysqli_connect_error()) {
			trigger_error('Gagal terkoneksi ke database : '. mysqli_connect_error(), E_USER_ERROR);
		}
	}

	/**
	* Empty clone, magic to prevent duplication
	*/

	private function __clone() {}

	/**
	* Get mysqli connection
	*/
	public function getConnection()
	{
		return $this->_connection;
	}
}