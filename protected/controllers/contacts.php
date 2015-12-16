<?php

class Protected_Controllers_Contacts extends Core_BaseController
{
    public function index(){

        if(isset($_POST['_token']) && $_POST['_token']== $_SESSION['_token']['contactform']){

            $model = new Protected_Models_Contacts();
            $error = $model->findErrors();

            if(!empty($error)){
                $post = AppUser::cleanInput($_POST);
                return ['view'=>'contacts.php', 'error'=>$error, 'post'=> $post];
            } else {

                Mail::tomail($_POST['message'], $_POST['email'], $_POST['name'], $_POST['phone']);

                return ['view'=>'contacts.php', 'success'=> true];
            }
         }

        return ['view'=>'contacts.php'];



    }
}