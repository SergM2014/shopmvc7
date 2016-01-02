<?php

class Admin_Controllers_Product  extends Core_BaseController
{
    function index()
    {

       /* $data=AppUser::cleanInput($_POST, false);

        $model= new Protected_Models_Admin;
        $model->getAdmin($data);*/

        return ['view'=>'product.php'];
    }


}