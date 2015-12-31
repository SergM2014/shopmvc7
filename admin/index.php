<?php

require_once $_SERVER['DOCUMENT_ROOT']."/config.php";

$router=new Core_Application;

$controller=$router->getController();

$data_and_view = $router->runController($controller);

if(isset($data_and_view)){ extract($data_and_view, EXTR_OVERWRITE);}
//var_dump($data_and_view);
include_once PATH_SITE . "/admin/template/index.php";

