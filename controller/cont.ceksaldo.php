<?php

function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}

if(isset($_GET['data'])){
    session_start();

    $username=$_SESSION['username'];
    //print_r($username);
    
    $kddept= substr($username, 0, 3);
    $kdunit= substr($username, 3, 2);
    $kdsatker= substr($username, 5, 6);
    $baes1satker=$kddept.'.'.$kdunit.'.'.$kdsatker;
    
    $arr=array(
        'kddept' => $kddept,
        'kdunit' => $kdunit,
        'kdsatker' => $kdsatker,
    );
    
    $satker = new Satker($arr);
    $data_satker = $satker->getSatker();
    $kewe=$satker->getKewenangan();

    $data=array(
        'kdsatker' => $baes1satker,
        'nmsatker' => $data_satker['nmsatker'],
        'kddekon' => $kewe['kddekon'],
    );
    
    echo json_encode($data);
}

if(isset($_GET['cek'])){
    $kddekon=$_REQUEST['kddekon'];
    $tgl_awal=$_REQUEST['tgl_awal'];
    $tgl_akhir=$_REQUEST['tgl_akhir'];
    session_start();

    $username=$_SESSION['username'];

    
    $kddept= substr($username, 0, 3);
    $kdunit= substr($username, 3, 2);
    $kdsatker= substr($username, 5, 6);
    $rekon = new Rekon();
    $content = $rekon->rekonSaldo($kddept,$kdunit,$kdsatker, $tgl_awal,$tgl_akhir,$kddekon);
    echo json_encode($content);
    
}
?>
