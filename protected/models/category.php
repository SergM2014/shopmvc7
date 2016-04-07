<?php

class Protected_Models_Category extends Core_DataBase
{
    protected $errors;


    public function checkCategoryName()
    {
        $entry_category = (isset($_POST['create_new_category']))? $_POST['create_new_category']: $_POST['update_category'];

        $value = htmlspecialchars($entry_category);
        $this->errors=[];

        if(empty($value)){
            $this->errors['create_new_category']= "Нет названия категории";
            $this->errors['update_category']= "Нет названия категории";
        }

        return $this->errors;
    }

    public function getCategoryPageInfo()
    {
        $entry_category = (isset($_POST['create_new_category']))? $_POST['create_new_category']: $_POST['update_category'];
        $category_name = htmlspecialchars($entry_category);


        $parent_id = (isset($_POST['category_id']))? $_POST['category_id']: 0;

        if(isset($_POST['create_new_category'])){
            $model= new Protected_Models_Product();
            $categories_tree = $model->getCategoriesTree(0,$parent_id, true );

            return compact('category_name', 'categories_tree');
        } else {


            $model = new Protected_Models_Catalog();
            $category = $model->getCategoryName();
            return compact ('category');
        }
    }

    public function  saveNewCategory(){

        $category_name= htmlspecialchars($_POST['create_new_category']);
        $parent_id = (isset($_POST['category_id']))? $_POST['category_id']: 0;
        $latin_category_name = Lib_LangService::translite_in_latin($category_name);


        $sql = "INSERT INTO `categories` (`title`,  `parent_id`, `translit_title`) VALUES (?, ?, ? )";
        $stmt = $this->conn->prepare($sql);
        $stmt -> bindParam(1, $latin_category_name, PDO::PARAM_STR);
        $stmt -> bindParam(2, $parent_id, PDO::PARAM_INT);
        $stmt -> bindParam(3, $category_name, PDO::PARAM_STR);
        $stmt->execute();

        return true;
    }


    public function saveUpdatedCategory()
    {
        $category_name= htmlspecialchars($_POST['update_category']);
        $latin_category_name = Lib_LangService::translite_in_latin($category_name);

        $sql = "UPDATE `categories` SET `translit_title` =?, `title`= ?  WHERE `id`=?";
        $stmt = $this -> conn ->prepare($sql);
        $stmt -> bindParam(1, $category_name, PDO::PARAM_STR);
        $stmt -> bindParam(2, $latin_category_name, PDO::PARAM_STR);

        $stmt -> bindParam(3, $_POST['product_id'], PDO::PARAM_INT);
        $stmt -> execute();
        return true;

    }

    public function destroyCategory()
    {
        $sql = "DELETE FROM `categories` WHERE `id`=?";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(1, $_POST['id'], PDO::PARAM_INT);
        $res= $stmt->execute();

        if($res){
            return array("message"=>"the category {$_POST['id']} was successfully deleted", "success"=>true);
        }

    }

    private function findChildCategory()
    {
        $sql= "SELECT * FROM `categories` WHERE `parent_id`= ?";
        $stmt = $this ->conn->prepare($sql);
        $stmt ->bindParam(1, $_POST['id'], PDO::PARAM_INT);
        $stmt ->execute();
        $res = $stmt ->fetch();

        return $res;
    }

    private function findItemsInCategory()
    {
        $sql="SELECT `id` FROM `products` WHERE `cat_id`=?";
        $stmt = $this ->conn->prepare($sql);
        $stmt ->bindParam(1, $_POST['id'], PDO::PARAM_INT);
        $stmt ->execute();
        $res = $stmt ->fetch();

        return $res;
    }

    public function checkCategoryDeleteErrors()
    {
        $this->errors = "";
        if(!Lib_TokenService::check('delete_category')) $this->errors.= 'Something is wrong';
        if($this->findChildCategory()) $this->errors.= "Present Child Categories. Impossible to delete!";
        if($this->findItemsInCategory()) $this->errors.= "Items in Category. Impossible to delete!";

        return $this->errors;
    }


}