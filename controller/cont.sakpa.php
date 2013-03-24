<?php

function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}

session_start();
$username = $_SESSION['username'];

$kddept = substr($username, 0, 3);
$kdunit = substr($username, 3, 2);
$kdsatker = substr($username, 5, 6);

$arr = array(
    'kddept' => $kddept,
    'kdunit' => $kdunit,
    'kdsatker' => $kdsatker,
);

$satker = new Satker($arr);
$data_satker = $satker->getKewenangan();

echo json_encode($data_satker);

?>