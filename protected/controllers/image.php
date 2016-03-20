<?php

class Protected_Controllers_Image extends Core_BaseController
{
    public function upload()
    {
       // Lib_TokenService::_token('comment_form');
        $model = new Protected_Models_Image();
        $message = $model->uploadAvatar();

        //return ['ajax'=>1, 'message'=> $message, 'view'=>'uploadimage/uploadresponce.php'];
        echo json_encode($message);
        exit();
    }





    public function delete()
    {
       // Lib_TokenService::_token('comment_form');
        $model = new Protected_Models_Image();
        $message = $model->deleteAvatar();


        echo json_encode($message);
        exit();
    }

}

?>