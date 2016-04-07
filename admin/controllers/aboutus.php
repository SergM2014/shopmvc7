<?php


class Admin_Controllers_Aboutus extends Core_BaseController
{
    public function index()
    {
        $model= new Protected_Models_About;
        $aboutus= $model->getInfo();

        return ['view'=>'aboutus/index.php', 'aboutus'=>$aboutus];
    }

    public function update()
    {
        Lib_TokenService::check('about_us');
        $model= new Protected_Models_About;
        $response = $model->saveUpdatedAboutus();
        echo json_encode($response);
        exit();
    }


}