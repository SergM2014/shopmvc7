<?php

abstract class Core_Application  //класс маршрутизатор, подбирает нужный контролер для обработки данных
 {
    //получаем путь помещаем в массивб фильтруем от гет переменных
	public function getController(){

		$url = $_SERVER['REQUEST_URI'];
		$url= trim($url, '/');

		if(strripos($url, '?')== true){$url = explode('?', $url); $url= $url[0];}
		if(strripos($url, '/')== true){$url = explode('/', $url);}

		if($url=='admin'){$controller['admin']='admin'; $url='';}//+
		if(isset($url[0]) && $url[0] =='admin') { $admin = array_shift($url);}


		if(!is_array($url) && !empty($url)){ $controller[0]= $url; $controller[1]= 'index';}
		if(empty($url)){$controller[0]= 'index'; $controller[1]= 'index';}
		if(!isset($controller)){$controller= $url;}
        if(isset($admin)){ $controller['admin'] = $admin; }

		return $controller;
	}
	 
    abstract function runController($controller);

    abstract function getView($view);




	 







 }
 
 
?>
