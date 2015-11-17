<?php

class Protected_Controllers_Catalog  extends Core_BaseController
{
    function index()
    {
       // $url = AppUser::getUrl();
       // $nocategory = AppUser::washfromRepetition('category');
        $nomanufacturer = AppUser::washfromRepetition('manufacturer');


        $model = new Protected_Models_Catalog();
        $pages = $model->countPages();
        $catalog= $model->getCatalog();

        $nop = AppUser::washfromRepetition('p');

        $model2 = new Protected_Models_Index();
        //get informatiom for left vertical menu
        $categories = $model2->getCategories();
        $menu = $model->getleftCatalogMenu($categories, 0);

        $manufacturers = $model-> getManufacturers();



        //$this->url = $url;



        return ['view'=>'catalog.php', 'manufacturers'=>$manufacturers, 'menu'=> $menu, 'pages'=>$pages, 'catalog'=> $catalog, 'nop'=>$nop, 'nomanufacturer'=>$nomanufacturer];
    }



}