<?php

  class Admin_Controllers_Index  extends Core_BaseController 
  {
      function index() 
	  {

          Lib_TokenService::checkAdmin();
          Lib_CookieService::getAdminCookies();

            if(!isset($_SESSION['admin'])) {

                $data = Lib_HelperService::cleanInput($_POST, false);

                $model = new Protected_Models_Admin;
                $checkedIP = $model->checkIP();
                if ($checkedIP) {

//var_dump($data);

                   $success= $model->getAdmin($data);
                    if($success){
                        Lib_CookieService::setAdminCookies($data);
                        $model->scavengeImages();
                    }


                } else {
                    return ['view' => 'index.php', 'restriction' => 'You seem to be very suspicios person try again in a minute'];
                }
            }
              return ['view'=>'index.php'];

	    }
		
   
  }