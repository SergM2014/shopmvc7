<?php
//любой контролер будет наследоваться от базового класса
 class Core_BaseController 
 {
    public $notAuthorized;

     public function __construct($controller){
         session_start();
         AppUser::initBusket();

        if (isset($controller['admin']) && $controller['admin']== 'admin' && !isset($_SESSION['admin']) && $controller[0] != "index"){
            $this->notAuthorized = true;
        }


     }





 }
 
?>