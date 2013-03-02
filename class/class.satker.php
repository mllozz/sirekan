<?php

	class Satker {

		public $kode_satker;
		public $kode_ba;
		public $kode_es;
		public $nama_satker;
		protected $_id_satker;

		protected $_time_created;
		protected $_time_updated;

		function __construct($data=array()) {

			//data array apa bukan
			if(!is_array($data)) {
				trigger_error('Unable to construct satker, ' .get_class($name));
			}

			//jika data ada
			if(count($data)>0) {
				foreach ($data as $name => $value) {
					//untuk var protected
					if(in_array($name, array(
						'time_created',
						'time_updated',
					))) {
						$name = '_'.$name;
					}
					$this->$name = $value;
				}
			}
		}

		function __get($name) {
			$protected_property_name='_'.$name;
			if(property_exists($this, $protected_property_name)) {
				return $this->$protected_property_name;
			}
		}

		function display()
		{
			$output='';

			$output .='<br />';
			$output .= $this->kode_ba.' . '.$this->kode_es;
			$output .= $this->kode_satker;
			$output .='<br />';
			$output .= $this->nama_satker;

			return $output;
		}

		function __toString() {
			return $this->display();
		}
	}