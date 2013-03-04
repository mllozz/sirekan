<?php
	function __autoload($class_name) {
  		include 'class/class.' . strtolower($class_name) . '.php';
	}
	
	$index=new Kppn();
	$kppn=$index->getNamaKppn();