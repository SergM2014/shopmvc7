<?php

class Protected_Controllers_Catalog  extends Core_BaseController
{
    function index()
    {
        $url = AppUser::getUrl();
        $nocategory = AppUser::washfromRepetition('category');
        $nomanufacturer = AppUser::washfromRepetition('manufacturer');
        $nop = AppUser::washfromRepetition('p');

        $model = new Protected_Models_Catalog();
        $catalog= $model->getCatalog();
        $pages = $model->countPages();


        $model2 = new Protected_Models_Index();
        //get informatiom for left vertical menu
        $categories = $model2->getCategories();
        $menu = $model->getleftCatalogMenu($nocategory, $categories, 0);

        $manufacturers = $model-> getManufacturers();



        //$this->url = $url;



        return ['view'=>'catalog/index.php', 'manufacturers'=>$manufacturers, 'menu'=> $menu, 'pages'=>$pages, 'catalog'=> $catalog, 'nop'=>$nop, 'nomanufacturer'=>$nomanufacturer];
    }



}