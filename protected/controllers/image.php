<?php

class Protected_Controllers_Image extends Core_BaseController
{
    public function upload()
    {

    if(!isset($_POST['_token']) OR $_POST['_token']!= $_SESSION['_token']['comment_form']) exit();

        $model = new Protected_Models_Image();
        $message = $model->uploadAvatar();

        return ['ajax'=>1, 'message'=> $message, 'view'=>'uploadimage/uploadresponce.php'];
    }





    public function delete(){

        if(!isset($_POST['_token']) OR $_POST['_token']!= $_SESSION['_token']['comment_form']) exit();

        $model = new Protected_Models_Image();
        $message = $model->deleteAvatar();


        return ['view'=> 'uploadimage/deletedimage.php', 'message'=>$message, 'ajax'=> 1];
    }

}
?>