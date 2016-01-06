<?php

class Admin_Controllers_Product  extends Core_BaseController
{
    public function index()
    {

        return ['view'=>'getproduct.php'];
    }


    public function getProduct(){



        $model= new Protected_Models_Product;
        $product = $model->getProduct();
        $current_category_id= $product['cat_id'];
        $categories= $model->getAllCategoriesForTree();
        $categories_tree =$model->build_tree($categories, 0, $current_category_id);
        $comments= $model->getComments();
        $manufacturers = $model->getManufacturerForList();
        return ['view'=>'getproduct.php', 'product'=>$product, 'categories_tree'=>$categories_tree, 'manufacturers'=>$manufacturers, 'comments'=>$comments];
    }

}