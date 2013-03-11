<?php
function __autoload($class_name) {
    include 'class/class.' . strtolower($class_name) . '.php';
}

session_start();
///if(isset($_SESSION['isLogged'])) {
    //$data_log=$_SESSION['satker'];
    $username=$_SESSION['username'];
    $akses=$_SESSION['akses'];
    //print_r($username);
    
    $kddept= substr($username, 0, 3);
    $kdunit= substr($username, 3, 2);
    $kdsatker= substr($username, 5, 6);
    $kdakses=$akses[0];
    
    $arr=array(
        'kddept' => $kddept,
        'kdunit' => $kdunit,
        'kdsatker' => $kdsatker,
    );
    
    $satker = new Satker($arr);
    $data_satker = $satker->getSatker();
//} else {
//    header('Location: index.php');
//}

?>