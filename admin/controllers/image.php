<?php

class Admin_Controllers_Image extends Core_BaseController
{
    public function upload()
    {

        if(!isset($_POST['_token']) OR $_POST['_token']!= $_SESSION['_token']['update_product']) exit();

        $model = new Protected_Models_Image();
        $response = $model->uploadImage();

        echo json_encode($response);
        exit();
    }



    public function delete()
    {
        if(!isset($_POST['_token']) OR $_POST['_token']!= $_SESSION['_token']['update_product']) exit();
        $model = new Protected_Models_Image();
        $message = $model->deleteImage();

        echo $message;
        exit();
    }

     public function addSection()
     {
         return ['view'=>'productImageUpload.php', 'ajax'=>1];
     }

}
?>