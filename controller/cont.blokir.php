<?php

function __autoload($class_name) {
    include 'class/class.' . strtolower($class_name) . '.php';
}

$users = User::getAllUser();
$data[] = array();
$i = 0;
foreach ($users as $rows) {
    $arr[$i] = array(
        'kddept' => $rows['kddept'],
        'kdunit' => $rows['kdunit'],
        'kdsatker' => $rows['kdsatker'],
    );
    $satker[$i] = new Satker($arr[$i]);
    $res[$i] = $satker[$i]->getSatker();

    $data[$i] = array(
        'id_user' => $rows['id_user'],
        'kddept' => $rows['kddept'],
        'kdunit' => $rows['kdunit'],
        'kdsatker' => $rows['kdsatker'],
        'username' => $rows['username'],
        'nmakses' => $rows['nmakses'],
        'nmsatker' => $res[$i]['nmsatker'],
    );
    $i++;
}

print_r($data);
?>