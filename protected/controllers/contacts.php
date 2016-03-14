<?php

class Protected_Controllers_Contacts extends Core_BaseController
{

    public function index()
    {
         $model = new Protected_Models_Contacts();
         $contacts = $model->getContacts();

         return ['view'=>'contacts.php', 'contacts'=>$contacts];
    }

    public function send(){
       
            Lib_TokenService::check('contacts');

            $model = new Protected_Models_Contacts();
            $error = $model->findErrors();

            if(!empty($error)){
                $post = Lib_HelperService::cleanInput($_POST);
                return ['view'=>'contacts.php', 'error'=>$error, 'post'=> $post];
            } else {

                Lib_HelperService::tomail($_POST['message'], $_POST['email'], $_POST['name'], $_POST['phone']);


                return ['view'=>'contacts.php', 'success'=> true];
            }
    }



}