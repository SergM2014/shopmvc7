<?php

class Admin_Controllers_Product  extends Core_BaseController
{
// get and output the item
    public function edit()
    {
        $model= new Protected_Models_Product('edit');
        $product = $model->getProduct();
        $categories_tree = $model->getCategoriesTree(0,$current_category_id=$product['cat_id']);
        $manufacturers = $model->getManufacturerForList();
        $images= $model->getProductImages();

        return ['view'=>'update_product.php', 'product'=>$product, 'categories_tree'=>$categories_tree, 'manufacturers'=>$manufacturers, 'images'=>$images];
    }


    //persist changed product
    public function update()
        {
            Lib_TokenService::check('update_product');

           $model= new Protected_Models_Product;
            $error=$model->checkIfNotEmpty();

            if(!empty($error)){
                $page =$model->getPageInfo();
                extract($page);
                return ['view'=>'update_product.php', 'product'=>$product, 'categories_tree'=>$categories_tree, 'manufacturers'=>$manufacturers, 'error'=> $error ];
            } else {
                $result= $model->saveUpdatedProduct();

                if($result){
                    $model->successUpdatedRedirectionView();
                }
            }
        }

//outpu torm for creating of an item
    public function create()
        {
            $model= new Protected_Models_Product('create');
            $categories_tree = $model->getCategoriesTree(0, null );
            $manufacturers = $model->getManufacturerForList();
            $images= $model->getProductImages();

            return ['view'=>'create_product.php',  'categories_tree'=>$categories_tree, 'manufacturers'=>$manufacturers, 'images'=>$images];
        }


    public function store()
        {
            Lib_TokenService::check('add_product');

            $model= new Protected_Models_Product;
            $error=$model->checkIfNotEmpty();
            if(!empty($error)){
                $page =$model->getPageInfo();
                extract($page);

                return ['view'=>'create_product.php', 'product'=>$product, 'categories_tree'=>$categories_tree, 'manufacturers'=>$manufacturers, 'error'=> $error ];
            } else {
                $result= $model->saveAddedProduct();

                if($result){
                    $model->successSavedRedirectionView();
                }
            }
        }


    public function index()
        {

            Lib_TokenService::fire();

            $nomanufacturer = Lib_HelperService::washfromRepetition('manufacturer');

            $model = new Protected_Models_Catalog('admin');
            $pages = $model->countPages();
            $catalog= $model->getCatalog();

            $nop = Lib_HelperService::washfromRepetition('p');

            $model2 = new Protected_Models_Index();

            $categories = $model2->getCategories();
            $menu = $model->getAdminDropDownCatMenu($categories, 0);

            $manufacturers = $model-> getManufacturers();

            $message = $model->getMessage();



            return ['view'=>'productslist.php', 'manufacturers'=>$manufacturers, 'menu'=> $menu, 'pages'=>$pages, 'catalog'=> $catalog, 'nop'=>$nop, 'nomanufacturer'=>$nomanufacturer, 'message'=>$message];
        }



    public function destroy()
        {
            Lib_TokenService::check('delete_product');
            $model= new Protected_Models_Product;
            $response = $model->destroyItem();
            echo json_encode($response);
            exit();
        }


    public function show()
    {
        $model = new Protected_Models_Product();
        $product = $model->getProduct();

        return ['view'=>'product_view.php', 'product'=>$product ];
    }




}