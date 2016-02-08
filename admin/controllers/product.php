<?php

class Admin_Controllers_Product  extends Core_BaseController
{
// get and output the item
    public function edit()
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


    //persist changed product
    public function update()
        {

           if(!isset($_POST['_token']) OR $_POST['_token']!= $_SESSION['_token']['update_product']) exit();

            $model= new Protected_Models_Product;
            $error=$model->checkIfNotEmpty();

            if(!empty($error)){
                $page =$model->errorTriggerPage();
                extract($page);
                return ['view'=>'getproduct.php', 'product'=>$product, 'categories_tree'=>$categories_tree, 'manufacturers'=>$manufacturers, 'error'=> $error ];
            } else {
                $result= $model->saveUpdatedProduct();

                if($result){
                   return ['view'=>'savedproduct.php', 'success'=> "The product ".$_POST['product_id']." is changed and saved successfully"];
                }
            }
        }

//outpu torm for creatin an item
    public function create()
        {
            $model= new Protected_Models_Product;
            $categories= $model->getAllCategoriesForTree();
            $categories_tree =$model->buildSelectTree($categories, 0, null);
            $manufacturers = $model->getManufacturerForList();
            $images= $model->getProductImages();
            return ['view'=>'getproduct.php',  'categories_tree'=>$categories_tree, 'manufacturers'=>$manufacturers, 'images'=>$images];
        }


    public function store()
        {
           // if(!isset($_POST['_token']['add_product']) OR $_POST['_token']!= $_SESSION['_token']['add_product']) exit();

            $model= new Protected_Models_Product;
            $error=$model->checkIfNotEmpty();
            if(!empty($error)){
                $page =$model->errorTriggerPage();
                extract($page);
                return ['view'=>'getproduct.php', 'product'=>$product, 'categories_tree'=>$categories_tree, 'manufacturers'=>$manufacturers, 'error'=> $error ];
            } else {
                $result= $model->saveAddedProduct();

                if($result){
                    return ['view'=>'savedproduct.php', 'success'=> "The new product is saved successfully"];
                }
            }
        }


    public function index()
        {
            $nomanufacturer = AppUser::washfromRepetition('manufacturer');

            $model = new Protected_Models_Catalog('admin');
            $pages = $model->countPages();
            $catalog= $model->getCatalog();

            $nop = AppUser::washfromRepetition('p');

            $model2 = new Protected_Models_Index();

            $categories = $model2->getCategories();
            $menu = $model->getadminCatMenu($categories, 0);

            $manufacturers = $model-> getManufacturers();

            return ['view'=>'productslist.php', 'manufacturers'=>$manufacturers, 'menu'=> $menu, 'pages'=>$pages, 'catalog'=> $catalog, 'nop'=>$nop, 'nomanufacturer'=>$nomanufacturer];
        }



}