<?php

function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}

session_start();
///if(isset($_SESSION['isLogged'])) {
//$data_log=$_SESSION['satker'];
$username = $_SESSION['username'];
$kdakses = $_SESSION['akses'];
//$kdakses = $akses[0];

if ($kdakses != '2') {
    $user = new \UserAdmin();
    $data_user = $user->getUserByUsername($username);
    $kddept = $data_user['kddept'];
    $kdunit = $data_user['kdunit'];
    $kdsatker = $data_user['kdsatker'];
    $kddekon = $data_user['kddekon'];
    $hak=User::getAkses($kdakses);
    $nmakses=$hak['nmakses'];
} else {
    $user=new \UserSatker();
    $kddept = substr($username, 0, 3);
    $kdunit = substr($username, 3, 2);
    $kdsatker = substr($username, 5, 6);
    $kddekon = substr($username, 11, 2);
    $hak=User::getAkses($kdakses);
    $nmakses=$hak['nmakses'];
}
$arr = array(
    'kddept' => $kddept,
    'kdunit' => $kdunit,
    'kdsatker' => $kdsatker,
    'kddekon' => $kddekon,
);

$satker = new Satker($arr);
$data_satker = $satker->getSatker();

$data=array(
    'profil'=>$data_satker['nmsatker'] . " ( " . $data_satker['kddept'] . "." . $data_satker['kdunit'] . "." . $data_satker['kdsatker'] . ")",
    'akses' => $nmakses,
);

echo json_encode($data);


?>