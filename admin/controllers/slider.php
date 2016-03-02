<?php

class Admin_Controllers_Slider extends Core_BaseController{

    public function index()
    {
        $model= new Protected_Models_Slider();
        $sliders = $model->getSliders();
//var_dump($sliders); die();
        return ['view'=>'sliders/index.php', 'sliders'=>$sliders];
    }



}