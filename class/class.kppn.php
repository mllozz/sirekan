<?php
	
	class Kppn {
		
		public $kdkppn;
		public $nmkppn;
		public $almkppn;
		public $telkppn;
		public $kotakppn;
		public $email;
		public $kodepos;
		public $faxkppn;
		public $kdsatkerkppn;
		
		public function __construct() {}
			
		/**
		* Fungsi autoload class
		*/
		function __autoload($class_name) {
	  		include 'class/class.' . strtolower($class_name) . '.php';
		}
		
		/**
		* Magic __set
		*/
		function __set($name, $value) {
		        $this->record[$name] = $value;
		}
		
		/**
		* Mendapatkan kppn yang diset di server
		* @return object
		*/
		public function getKppn() {
			$db=Database::getInstance();
			$conn=$db->getConnection(2);
			
			$query = "select kdkppn,nmkppn,almkppn,telkppn,kotakppn,email,kodepos,faxkppn,kdsatkerkppn ";
			$query .= " from t_kppn where kddefa='1'";
			
			$result=$conn->prepare($query);
			$result->execute();
			$jml_hasil=$result->rowCount();
			
			if($jml_hasil!=1) {
				trigger_error('Data tidak ditemukan');
				return false;
			}
			$class = get_called_class();
			$result->setFetchMode(PDO::FETCH_CLASS, $class);
			return $result->fetch();
		}

	}
?>
