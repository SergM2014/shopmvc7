<?php

require_once "./../config.php"; 

$router=new Core_Application; 

$member=$router->Run();

if(isset($member)){ 

extract($member, EXTR_OVERWRITE);}

require_once "./template/index.php";
?>
