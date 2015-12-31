<?php

class Core_Application  //класс маршрутизатор, подбирает нужный контролер для обработки данных
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
	 

 	public function runController($controller){

		session_start();
		AppUser::initBusket();

		if(isset($controller['admin']) && $controller['admin']=='admin'){$name_contr= 'Admin_Controllers_'.$controller[0];}
			else{$name_contr = 'Protected_Controllers_'.$controller[0];}

		$action = $controller[1];
		$contr = new $name_contr;

		$data=call_user_func(array($contr, $action));

		return $data;

	}

	 



	public function getView($view, $admin= false )//получить представление для контролера
	{
        if(!$admin) {
            $view_path = '/protected/views/'.$view;
        } else {
            $view_path = '/admin/views/'.$view;
        }

        return PATH_SITE.$view_path;
	}



 }
 
 
?>
