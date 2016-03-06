<?php

class Admin_Controllers_Category extends Core_BaseController
{

    public function index()
    {

        $model = new Protected_Models_Catalog();

        $model2 = new Protected_Models_Index();

        $categories = $model2->getCategories();
        $categories_tree = $model->getAdminCategoriesTree($categories);
        $message = $model->getMessage();

        return ['view' => 'categories/categories.php', 'categories_tree' => $categories_tree, 'message'=>$message];
    }

    //выищд формы дя створення новой категории
    public function create()
    {
        $model = new Protected_Models_Product();
        $categories_tree = $model->getCategoriesTree(0, null, true);
        return ['view' => 'categories/create_new_category.php', 'categories_tree' => $categories_tree];
    }

    public function store()
    {
         Lib_TokenService::check('create_new_category');


        $model = new Protected_Models_Admin;
        $error = $model->checkCategoryName();
     
        if (!empty($error)) {
            $page = $model->getCategoryPageInfo();
            extract($page);

            return ['view' => 'categories/create_new_category.php', 'category_name' => $category_name, 'categories_tree' => $categories_tree, 'error' => $error];
        } else {
             $result= $model->saveNewCategory();

            if ($result) {
                
                $_SESSION['message'] ="The new category is created";
       
               $this->redirect('index');
            }
        }
    }

    public function edit(){
        
        $model = new Protected_Models_Catalog();
        $category = $model->getCategoryName();

      return ['view' => 'categories/update_category.php', 'category'=>$category, 'product_id'=>$_GET['id']];
    }


    public function update()
    {
         Lib_TokenService::check('update_category');
        $model = new Protected_Models_Admin;
        $error = $model->checkCategoryName();
     
        if (!empty($error)) {
            $page = $model->getCategoryPageInfo();
            extract($page);

            return ['view' => 'categories/update_category.php', 'category'=>$category, 'error' => $error];
        } else {
             $result= $model->saveUpdatedCategory();

            if ($result) {
                
                $_SESSION['message'] ="The category#{$_POST['product_id']} was successfull updated";
       
              $this->redirect('index');
            }
        }
    }


    public function destroy()
        {

            Lib_TokenService::check('delete_category');
            $model= new Protected_Models_Admin;
            $error = $model->checkCategoryDeleteErrors();
            if($error !=''){
                $response = array("error" => $error);
                echo json_encode($response);
                exit();
            }

            $response=$model->destroyCategory();

             echo json_encode($response);
             exit();

            
        }


}



















