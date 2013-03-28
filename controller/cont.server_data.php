<?php

function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}

if(isset($_GET['server'])){
    $kddekon=$_POST['kddekon'];
    
    session_start();

    $username=$_SESSION['username'];

    $kddept = substr($username, 0, 3);
    $kdunit = substr($username, 3, 2);
    $kdsatker= substr($username, 5, 6);
    $kdbaes= substr($username, 0, 5);
    $error=false;
    $msg='';
    $ambil=new Server_Data();
    
    $del=$ambil->deleteLokal($kdbaes, $kdsatker, $kddekon);
    if($del){
        $proses=$ambil->prosesData($kddept, $kdunit, $kdsatker, $kddekon);
        if(!$proses){
            $error='Gagal Mencari data';
        }else {
            //proses pencocokan
            $msg='Berhasil Proses Data';
        }
    }else{
        $error='Gagal Proses Data';
    }
    
    
    $data=array(
        'msg' => $msg,
        'error' => $error,
    );
    
    echo json_encode($data);
}
?>
