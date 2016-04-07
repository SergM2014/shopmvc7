<?php

class Admin_Controllers_Slider extends Core_BaseController{

    public function index()
    {
        $model= new Protected_Models_Slider;
        $sliders = $model->getSliders();
        $message = $model->getMessage();
        return ['view'=>'sliders/index.php', 'sliders'=>$sliders, 'message'=>$message];
    }


    public function create()
    {


        return ['view'=>'sliders/create.php'];
    }



    public function store()
    {
        Lib_TokenService::check('create_new_slider');
        $model = new Protected_Models_Slider;
        $error = $model->checkSliderInputs();

        if (!empty($error)) {
            $page = $model->getSliderPageInfo();
            extract($page);

            return ['view' => 'sliders/create.php', 'slider_url'=> $slider_url, 'slider_title'=>$slider_title, 'error' => $error, 'uploads'=>'/uploads/slider/', 'image'=>$image ];
        } else {
            $result= $model->saveNewSlider();

            if ($result) {

                $_SESSION['message'] ="The new slider was successfull created";

                $this->redirect('index');
            }
        }
    }

    public function edit()
    {

        $model= new Protected_Models_Slider;
        $slider=$model->getOneSlider();
        return ['view'=>'sliders/update_slider.php', 'slider_url'=>$slider['url'], 'slider_id'=>$slider['id'], 'uploads'=>'/uploads/slider/', 'image'=>(isset($_SESSION['slider']))? $_SESSION['slider']: null];
    }

    public function update()
    {
        Lib_TokenService::check('update_slider');
        $model = new Protected_Models_Slider;
        $error = $model->checkSliderInputs();

        if (!empty($error)) {
            $page = $model->getSliderPageInfo();
            extract($page);

            return ['view' => 'sliders/update_slider.php', 'slider_url'=> $slider_url, 'error' => $error, 'slider_id'=>$_POST['id'], 'uploads'=>'/uploads/slider/', 'image'=>(isset($_SESSION['slider']))? $_SESSION['slider']: null];
        } else {
            $result= $model->saveUpdatedSlider();

            if ($result) {

                $_SESSION['message'] ="The new slider#{$_POST['id']} was successfull updated";

                $this->redirect('index');
            }
        }
    }


    public function destroy()
    {
        Lib_TokenService::check('delete_slider');
        $model = new Protected_Models_Slider;
        $response = $model->destroySlider();
        echo json_encode($response);
        exit();
    }



}