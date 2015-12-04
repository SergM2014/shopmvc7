<?php

class Protected_Controllers_Contacts extends Core_BaseController
{
    public function index(){

        if(isset($_POST['send'])){

            $model = new Protected_Models_Contacts();
            $error = $model->findErrors();

            if(!empty($error)){
                return ['view'=>'contacts.php', 'error'=>$error];
            } else {
                //тут робым видправку листа
                Mail::tomail($_POST['message'], $_POST['email'], $_POST['name'], $_POST['phone']);

                return ['view'=>'contacts.php', 'success'=> true];}
         }

        return ['view'=>'contacts.php'];



    }
}