<?php

  class Admin_Controllers_Index  extends Core_BaseController 
  {
      function index() 
	  {  

          if(isset($_POST['_token']) &&  $_POST['_token']==$_SESSION['_token']['enterAdmin']){
              $data=AppUser::cleanInput($_POST, false);

              $model= new Protected_Models_Admin;
              $checkedIP = $model->checkIP();
             if($checkedIP){ $model->getAdmin($data);} else { return ['view'=>'index.php', 'restriction'=>'You seem to be very suspicios person try again in a minute']; }

              return ['view'=>'index.php'];
          }
          return ['view'=>'index.php'];
	    }
		
   
  }