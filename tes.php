<?php
	include 'class/class.satker.php';

	$data = array(
		'kode_ba' =>'015' ,
		'kode_es' => '08',
		'kode_satker' => '635172',
		'nama_satker' => 'KPPN Mana Saaja',
	);

	$satker = new Satker($data);

	echo $satker;
?>