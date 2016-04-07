<?php

  class Admin_Controllers_Index  extends Core_BaseController 
  {
      function index() 
	  {
          Lib_TokenService::checkAdmin();
          Lib_CookieService::getAdminCookies();

          if(!isset($_SESSION['admin'])) {

                $data = Lib_HelperService::cleanInput($_POST, false);

                $model = new Protected_Models_Ip;
                $checkedIP = $model->checkIP();
                if ($checkedIP) {
                      $model2 = new Protected_Models_Admin;
                      $success= $model2->getAdmin($data);
                      if($success){
                            Lib_CookieService::setAdminCookies($data);
                            $model2->scavengeImages();
                        }

                    } else {
                        return ['view' => 'index.php', 'restriction' => 'You seem to be very suspicios person try again in a minute'];
                    }

            }
              return ['view'=>'index.php'];
	    }
		
   
  }