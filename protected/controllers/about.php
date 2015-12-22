<?php

class Protected_Controllers_About  extends Core_BaseController
{
    function index()
    {


        $model = new Protected_Models_Index();
        $about = $model->getAboutInformation();



        return ['view'=>'about.php', 'about'=>$about];
    }



}