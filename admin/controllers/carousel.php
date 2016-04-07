<?php

class Admin_Controllers_Carousel extends Core_BaseController{

    public function index()
    {
        $model= new Protected_Models_Carousel;
        $carousel_images = $model->getCarouselImage();
        $message = $model->getMessage();
        return ['view'=>'carousel/index.php', 'carousel_images'=>$carousel_images, 'message'=>$message];
    }


    public function create()
    {


        return ['view'=>'carousel/create.php'];
    }



    public function store()
    {
        Lib_TokenService::check('create_new_carousel');
        $model = new Protected_Models_Carousel;
        $error = $model->checkCarouselInputs();

        if (!empty($error)) {
            $page = $model->getCarouselPageInfo();
            extract($page);

            return ['view' => 'carousel/create.php', 'slider_url'=> $carousel_url, 'error' => $error, 'uploads'=>'/uploads/carousel/', 'image'=>(isset($_SESSION['carousel']))? $_SESSION['carousel']: null];
        } else {
            $result= $model->saveNewCarousel();

            if ($result) {

                $_SESSION['message'] ="The new carousel was successfull created";

                $this->redirect('index');
            }
        }
    }

    public function edit()
    {

        $model= new Protected_Models_Carousel;
        $carousel=$model->getOneCarousel();
        return ['view'=>'carousel/update_carousel.php', 'carousel_url'=>$carousel['url'], 'carousel_id'=>$carousel['id'], 'uploads'=>'/uploads/carousel/', 'image'=>(isset($_SESSION['carousel']))? $_SESSION['carousel']: null];
    }

    public function update()
    {
        Lib_TokenService::check('update_carousel');
        $model = new Protected_Models_Carousel;
        $error = $model->checkCarouselInputs();

        if (!empty($error)) {
            $page = $model->getcarouselPageInfo();
            extract($page);

            return ['view' => 'carousel/update_carousel.php', 'carousel_url'=> $carousel_url, 'error' => $error, 'carousel_id'=>$_POST['id'], 'uploads'=>'/uploads/carousel/', 'image'=>(isset($_SESSION['carousel']))? $_SESSION['carousel']: null];
        } else {
            $result= $model->saveUpdatedCarousel();

            if ($result) {

                $_SESSION['message'] ="The new slider#{$_POST['id']} was successfull updated";

                $this->redirect('index');
            }
        }
    }


    public function destroy(){

         Lib_TokenService::check('delete_carousel');

        $model = new Protected_Models_Carousel;
        $response = $model->destroyCarousel();

        echo json_encode($response);
        exit();
    }



}