<?php

class Admin_Controllers_Product  extends Core_BaseController
{
    public function index()
    {

       /* $data=AppUser::cleanInput($_POST, false);

        $model= new Protected_Models_Admin;
        $model->getAdmin($data);*/

        return ['view'=>'getproduct.php'];
    }


    public function getProduct(){



        $model= new Protected_Models_Product;
        $product = $model->getProduct();
        $current_category_id= $product['cat_id'];
        $categories= $model->getAllCategoriesForTree();
        $categories_tree =$model->build_tree($categories, 0, $current_category_id);
        $comments= $model->getComments();
        return ['view'=>'getproduct.php', 'product'=>$product, 'categories_tree'=>$categories_tree, 'comments'=>$comments];
    }

}