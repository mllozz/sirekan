<?php
function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}


if(isset($_POST['rekon'])){
    
    session_start();
    $username = $_SESSION['username'];

    $kdbaes = substr($username, 0, 5);
    $kdsatker = substr($username, 5, 6);
    $ulang=$_POST['rekon'];    
    $id_rekon=$_POST['id'];
    $nama_file=$_POST['nama'];
    
    //rekon saldo awal
    if($id_rekon=='1'){
        $rekon=new Rekon();
        $cek=$rekon->cekRekonSA($kdbaes, $kdsatker);
        if($cek && $ulang==0){
            echo json_encode('pernah');
        }else{
            echo json_encode('rekon normal');
        }
    }
    
    
    //rekon sakpa
    if($id_rekon=='1') {
        
    }
    //echo json_encode('Dataneeeee');
}
?>
