<?php
//любой контролер будет наследоваться от базового класса
 class Core_BaseController 
 {
    public $notAuthorized;

     public function __construct($controller)
     {
         session_start();
         AppUser::initBusket();

         if (isset($controller['admin']) && $controller['admin'] == 'admin' && !isset($_SESSION['admin']) && $controller[0] != "index") {
             $this->notAuthorized = true;
         }

     }


     public function redirect($controller_action)
         {
             $trimmed_uri= trim($_SERVER['REQUEST_URI'], '/');
             $location = explode('/', $trimmed_uri);
             $location[count($location)-1]= $controller_action;
             $location=implode('/', $location);

             header('Location: /'.$location);
         }







 }
 
?>