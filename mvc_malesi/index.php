<?php
function __autoload($class_name) {
	require 'libs/class.' . strtolower($class_name) . '.php';
}

$pageloader= new PageLoader();
?>