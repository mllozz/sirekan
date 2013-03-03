<?php

class Database {

	private $_host='localhost';
	private $_user='root';
	private $_pass='';
	private $_db='sirekan';
	
	private $_connection;

	//simpan single instance
	private static $_instance;

	/**
	* Get instance dari database
	* @return type database
	*/
	public static function getInstance($index=null) {
		if($index!=null && $index=='sp2d') {
			$_db='sqldb12';
		}

		if(!self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {

		$this->_connection = new mysqli($this->_host,$this->_user,$this->_pass,$this->_db);

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