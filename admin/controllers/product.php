<?php

class Admin_Controllers_Product  extends Core_BaseController
{

    public function index()
    {
        $model= new Protected_Models_Product;
        $product = $model->getProduct();
        $current_category_id= $product['cat_id'];
        $categories= $model->getAllCategoriesForTree();
        $categories_tree =$model->buildSelectTree($categories, 0,$current_category_id);
        $manufacturers = $model->getManufacturerForList();
        $images= $model->getProductImages();

        return ['view'=>'getproduct.php', 'product'=>$product, 'categories_tree'=>$categories_tree, 'manufacturers'=>$manufacturers, 'images'=>$images];
    }

    public function updateProduct()
    {
        $model= new Protected_Models_Product;
        $error=$model->checkIfNotEmpty();

        if(!empty($error)){
            $page =$model->errorUpdatePage();
            extract($page);
            return ['view'=>'getproduct.php', 'product'=>$product, 'categories_tree'=>$categories_tree, 'manufacturers'=>$manufacturers, 'error'=> $error ];
        } else {
            $result= $model->saveUpdatedProduct();

            if($result){
               return ['view'=>'savedproduct.php', 'success'=> "The product ".$_POST['product_id']." is changed and saved successfully"];
            }
        }
    }



}