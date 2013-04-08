<?php

function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}

$rekon=new JenisRekon();

$data=$rekon->getJnsRekon();

echo json_encode($data);
?>
