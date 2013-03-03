<?php
	function __autoload($class_name) {
  		include 'class/class.' . $class_name . '.php';
	}

	$data = array(
		'kode_ba' =>'015' ,
		'kode_es' => '08',
		'kode_satker' => '635172',
		'nama_satker' => 'KPPN Mana Saaja',
	);

	$satker = new Satker($data);

	//echo $satker;

	$db= Database::getInstance('sp2d');
	$mysql=$db->getConnection();

	$query='select * from d_sispen';

	$result=$mysql->query($query) or trigger_error(mysqli_connect_error());

	if($result==false) {
		echo 'error ';
	}

	print_r($result);
?>