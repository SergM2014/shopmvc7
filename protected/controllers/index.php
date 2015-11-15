<?php

  class Protected_Controllers_Index  extends Core_BaseController 
  {
      function index() 
	{


        $model = new Protected_Models_Index();
        //get informatiom for left vertical menu
        $categories = $model->getCategories();
        $menu = $model->getleftMenu($categories, 0);


        //get data foe slider
        $sliders = $model-> getSlider();

        $carousel = $model->getCarousel();


      return ['view'=>'index/index.php', 'menu'=>$menu, 'sliders'=>$sliders, 'carousel'=>$carousel];
    }


	
  }
  