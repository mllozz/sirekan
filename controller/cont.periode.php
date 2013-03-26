<?php

function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}

$periode=new Periode();

$data=$periode->getPeriode();

echo json_encode($data);
?>
