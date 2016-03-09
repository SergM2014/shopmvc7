<?php

class Admin_Controllers_Image extends Core_BaseController
{
    public function upload()
    {
        Lib_TokenService::check('upload_image');
        $model = new Protected_Models_Image();
        $response = $model->uploadImage();

        echo json_encode($response);
        exit();
    }



    public function delete()
    {
        Lib_TokenService::check('upload_image');
        $model = new Protected_Models_Image();
        $message = $model->deleteImage();

        echo $message;
        exit();
    }

     public function addSection()
     {
         return ['view'=>'partials/productImageUpload.php', 'ajax'=>1];
     }



    //update avatar section

    public function uploadCommentImage()
     {
        Lib_TokenService::check('upload_image');
        $model = new Protected_Models_Image();
        $response = $model->uploadAvatar( true );

        echo json_encode($response);
        exit();
     }

     public function deleteCommentImage()

     {
         Lib_TokenService::check('upload_image');
         $model = new Protected_Models_Image();
         $response = $model->deleteAdminAvatar();
         echo json_encode($response);
         exit();
     }

    public function uploadSliderImage()
    {
        Lib_TokenService::check('upload_image');
        $model = new Protected_Models_Image();
        $response = $model->uploadSlider();

        echo json_encode($response);
        exit();
    }

    public function deleteSliderImage()
    {
        Lib_TokenService::check('upload_image');
        $model = new Protected_Models_Image();
        $response = $model->deleteSlider();

        echo json_encode($response);
        exit();
    }

    public function uploadCarouselImage()
    {
        Lib_TokenService::check('upload_image');
        $model = new Protected_Models_Image();
        $response = $model->uploadCarousel();

        echo json_encode($response);
        exit();
    }

    public function deleteCarouselImage()
    {
        Lib_TokenService::check('upload_image');
        $model = new Protected_Models_Image();
        $response = $model->deleteCarousel();

        echo json_encode($response);
        exit();
    }

}
?>