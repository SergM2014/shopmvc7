<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/config.php";
	
	$router=new Core_CustomApplication();
	
	$controller=$router->getController();

	$data_and_view = $router->runController($controller);

	if(isset($data_and_view)){ extract($data_and_view, EXTR_OVERWRITE);}

	require_once "./template/index.php";
?>