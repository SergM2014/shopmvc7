<?php

class Protected_Controllers_Contacts extends Core_BaseController
{
    public function index(){

        if(isset($_POST['send'])){
            $error=array();
            if(empty($_POST['name'])){$error['name']= 'Пустое поле';}
            if(empty($_POST['phone'])){$error['phone']='Пустое поле';}
            if(empty($_POST['email'])){$error['email']='Пустое поле';}
            if(empty($_POST['message'])){$error['message']='Пустое поле';}
            if(empty($_POST['keystring'])){$error['keystring']='Пустое поле';}

            if(!empty($error)){ return ['view'=>'contacts.php', 'error'=>$error]; }
        }

        return ['view'=>'contacts.php'];

    }
}