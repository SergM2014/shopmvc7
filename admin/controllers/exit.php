<?php

  class Admin_Controllers_Exit  extends Core_BaseController 
  {
      public function index()
	  {  

          unset($_SESSION['admin']);
          unset($_SESSION['login']);
          return ['view'=> 'index.php'];

        }





  }