<?php

class Admin_Controllers_Category extends Core_BaseController {

    public function index(){

        $model = new Protected_Models_Catalog();

        $model2 = new Protected_Models_Index();

        $categories = $model2->getCategories();
        $categories_tree = $model->getAdminCategoriesTree($categories);

       return ['view'=>'categories.php', 'categories_tree'=>$categories_tree];
    }



















}