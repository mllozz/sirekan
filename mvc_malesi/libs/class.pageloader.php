<?php
	class PageLoader {

		function __construct($page) {
			if(!isset($_GET['page'])) {
				require 'controller/index.cont.php';
				$index= new Index();
			} else {

				$url=$_GET['page'];
				$url= rtrim($url,'/');
				$url=explode('/', $url);

				$file='controller/'.$url[0].'.cont.php';

				if(file_exists($file)) {
					require $file;
				} else {
					require 'controller/error.cont.php';
					$error= new Error();
					return false;
				}

				$controller= new $url[0];

				if(isset($url[2])) {
					$controller->{$url[1]}($url[2]);
				} else {
					if(isset($url[1])) {
						$controller->{$url[1]}();
					}
				}
			}
		}
	}
?>