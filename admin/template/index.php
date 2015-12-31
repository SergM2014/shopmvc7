<?php
//die(var_dump($view));

if(isset($ajax)){
	$view=$router->getView($view, true );
	include ($view);
	exit();
}

require_once 'header.php';
$view=$router->getView($view, true);

include ($view);
require_once 'footer.php';

?>


