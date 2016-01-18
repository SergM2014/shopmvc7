<?php

class Admin_Controllers_Image extends Core_BaseController
{
    public function upload()
    {

      //  if(!isset($_POST['_token']) OR $_POST['_token']!= $_SESSION['_token']['commentForm']) exit();

        $model = new Protected_Models_Image();
        $message = $model->uploadImage();

        echo $message;
        ?> <img src="/img/tick.jpg" class="note"> <?php
        exit();
    }



    public function delete(){

       // if(!isset($_POST['_token']) OR $_POST['_token']!= $_SESSION['_token']['commentForm']) exit();
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