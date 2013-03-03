<?php

class Database {

	//konstan variabel
	const DB_HOST = 'localhost';
	const DB_USER = 'root';
	const DB_PASS = 'root';
	const DB_SIREKAN = 'sirekan';
	const DB_VERA = 'sqldb12';
	const DB_PORT_VERA = '3306';
	
	
	//protected variabel
	protected $_connection_sirekan;
	protected $_connection_vera;
	protected $mysqli_exception;
	protected $host;
	protected $user;
	protected $port;
	protected $password;
	protected $db_name;
	
	/**
	*protected konfigurasi
	*@var array
	*/
	protected $config_sirekan;
	protected $config_vera;

	//simpan single instance
	private static $_instance;
	protected static $log;

	/**
	* Get singleton instance dari database
	* @return type database
	*/
	public static function getInstance() {
		if(!self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	
	/**
	* Constructor
	*/
	protected function __construct() {}

	/**
	* Konfigurasi sirekan
	* @return config array
	*/
	protected function configSirekan() {
		if (isset($this->_connection_sirekan)) {
			error_log('DATABASE CONNECTION::warning, koneksi ke database sirekan sudah dibuat');
		}

		$this->config_sirekan = array(
			'host' => self::DB_HOST,
			'user' => self::DB_USER,
			'password' => self::DB_PASS,
			'db_name' => self::DB_SIREKAN
		);
	}
	
	/**
	* Konfigurasi db vera
	* @return config array
	*/
	protected function configVera() {
		if (isset($this->_connection_vera)) {
			error_log('DATABASE CONNECTION::warning, koneksi ke database sp2d sudah dibuat');
		}

		$this->config_vera = array(
			'host' => self::DB_HOST,
			'user' => self::DB_USER,
			'port' => self::DB_PORT_VERA,
			'password' => self::DB_PASS,
			'db_name' => self::DB_VERA
		);
	}
	
	/**
	* Membuat koneksi mysqli
	* @return mysqli object
	*/	
	protected function createConnection($config=array()){
		
		if(is_array($config)) {
			error_log('DATABASE CONNECTION::warning, konfigurasi koneksi database tidak ada ');
		}
		
		if(count($config)>0) {
			foreach($config as $name => $value) {
				$this->$name=$value;
			}
		}
		
		$new_connection=new mysqli($this->host,$this->user,$this->password,$this->db_name);
		
		if(mysqli_connect_error()) {
			error_log('DATABASE CONNECTION:warning, gagal terkoneksi dengan database');
			return false;
		}
		
		return $new_connection;
	}


	/**
	* Empty clone, magic to prevent duplication
	*/
	private function __clone() {}

	/**
	* Get Mysqli connection
	* @param int
	* @return mysqli Connection
	*/
	public function getConnection($sel=null)
	{
		if(isset($sel)) {
			if($sel==1){
				$this->configSirekan();
				$this->_connection_sirekan=$this->createConnection($this->config_sirekan);
				return $this->_connection_sirekan;
			} else if($sel==2) {
				$this->configVera();
				$this->_connection_vera=$this->createConnection($this->config_vera);
				return $this->_connection_vera;
			}
			else {
				error_log('DATABASE CONNECTION::warning, database selection failed');
			}
		}
		else {
			error_log('DATABASE CONNECTION::warning, database selection failed');
		}
	}
}