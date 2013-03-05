<?php
	$message=array();
	$user=$_POST['user'];
    $pass=$_POST['pass'];

    if(empty($user) || empty($pass)){
		$message[]="Tidak boleh kosong php";
	}

	if(count($message) > 0) {
		for($i=0;$i<count($message);$i++) {
			echo ucwords($message[$i]);
		}
	} else {
		echo 'correct';
	}
?>