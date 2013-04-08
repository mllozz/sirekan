<?php

function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}

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
?>
