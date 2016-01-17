<?php

class Admin_Controllers_Image extends Core_BaseController
{
    public function upload()
    {

      //  if(!isset($_POST['_token']) OR $_POST['_token']!= $_SESSION['_token']['commentForm']) exit();

        $model = new Protected_Models_Image();
        $message = $model->uploadImage();
die(var_dump($message));
       // return ['ajax'=>1, 'message'=> $message, 'view'=>'uploadimage/uploadresponce.php'];
/*var_dump($_FILES);
        echo "<br>";
        die(var_dump($_POST));*/

    }





    public function delete(){

       // if(!isset($_POST['_token']) OR $_POST['_token']!= $_SESSION['_token']['commentForm']) exit();

        $model = new Protected_Models_Image();
        $message = $model->deleteAvatar();


        return ['view'=> 'uploadimage/deletedimage.php', 'message'=>$message, 'ajax'=> 1];
    }

}
?>