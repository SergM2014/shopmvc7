<?php
//if ajax-request
if(isset($ajax)){
    $view=$router->getView($view);
    include ($view);
    exit();
}
//else
require_once "header.php";
$view=$router->getView($view);
include ($view);
require_once "footer.php";
?>
