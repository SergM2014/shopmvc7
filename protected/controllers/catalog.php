<?php

class Protected_Controllers_Catalog  extends Core_BaseController
{
    function index()
    {
        $nomanufacturer = Lib_HelperService::washfromRepetition('manufacturer');

        $model = new Protected_Models_Catalog();
        $pages = $model->countPages();
        $catalog= $model->getCatalog();

        $nop = Lib_HelperService::washfromRepetition('p');

        $model2 = new Protected_Models_Index();
        //get informatiom for left vertical menu
        $categories = $model2->getCategories();
        $menu = $model->getleftCatalogMenu($categories, 0);

        $manufacturers = $model-> getManufacturers();

        return ['view'=>'catalog.php', 'manufacturers'=>$manufacturers, 'menu'=> $menu, 'pages'=>$pages, 'catalog'=> $catalog, 'nop'=>$nop, 'nomanufacturer'=>$nomanufacturer];
    }



}