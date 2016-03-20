<?php
    define('PATH_SITE', $_SERVER['DOCUMENT_ROOT']);
    define('NAMESITE','shopmvc7');
    define('URL','http://shopmvc7/');
    define('AMOUNTONPAGE',5);
    define('NUMBERONPAGEADMIN',6);
    define('HOST', 'localhost'); //сервер
    define('USER', 'root'); //пользователь
    define('PASSWORD', '1'); //пароль
    define('NAME_BD', 'shopmvc7');
    define('DEBUG_MODE', true ); //режим отладки

	define('UPLOAD_FILE','/uploads/');
	define('LINKCOUNT',5);
	define('ADMINEMAIL', 'weisse@ukr.net');
	
	date_default_timezone_set('Europe/Kiev');
	
	function __autoload ($class_name) //автоматическая загрузка кслассов
	{
		$path=str_replace("_", "/", strtolower($class_name));//разбивает имя класса получая из него путь

		if (file_exists(PATH_SITE."/".$path.".php")) {

			require_once (PATH_SITE."/".$path.".php");//подключает php файл по полученному пути

		}
		else
		{ echo PATH_SITE."/".$path.".php";
            debug_print_backtrace();
		 //header('Location: /404');
            exit;

		}
	}
	if (DEBUG_MODE){
					ini_set("display_errors","1");
					ini_set("display_startup_errors","1");
					ini_set('error_reporting', E_ALL);
	}

    include_once PATH_SITE.'/auto_Lib_Includer.php';




?>
