<?php
    $user=$_POST['user'];
    $pass=$_POST['pass'];
    if(empty($user) || empty($pass)){
		echo "Tidak boleh kosong";
	}
	else{
		echo "Berhasil";
	}
?>