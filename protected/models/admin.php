<?php

class Protected_Models_Admin extends Core_DataBase
{
    function getAdmin($data)
    {
        if (!isset($data['login']) OR !isset($data['password'])) return false;
        $sql = "SELECT login, password FROM users";
        $stmt = $this->conn->query($sql);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['login'] == $data['login'] && $row['password'] == md5($data['password'])) {
                $_SESSION['admin'] = true;
                $_SESSION['login'] = $row['login'];

                return true;
            }
        }
        return false;

    }



    private function getClientIP(){

        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return (string)$ip;

    }



    public function checkIP(){

        $ip= $this->getClientIP();

        $this->setIP($ip);

        return $this->getIP($ip);
    }

    private function getIP($ip){
//if more > 3 times per minut
        if($_SESSION ['ip'][$ip]['quantity']>3) return false;
        return true;

    }


    private function setIP($ip){

        if(!isset($_SESSION ['ip'][$ip]['time'])) $_SESSION ['ip'] [$ip]['time'] = time();
// one minute
        if(time()>($_SESSION ['ip'][$ip]['time']+60)){ //echo 11111;
            $_SESSION ['ip'][$ip]['quantity'] = 1;
        } else {
            $_SESSION ['ip'][$ip]['quantity'] = isset($_SESSION['ip'][$ip]['quantity']) ? $_SESSION['ip'][$ip]['quantity']+1 : 1;
        }

        $_SESSION ['ip'][$ip]['time'] = time();

    }

    public function checkCategoryName()
    {
        $entry_category = (isset($_POST['create_new_category']))? $_POST['create_new_category']: $_POST['update_category'];
       
        $value = htmlspecialchars($entry_category);
        $error=[];

        if(empty($value)){
             $error['create_new_category']= "Нет названия категории";
             $error['update_category']= "Нет названия категории";
        }

        return $error;
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
        $error = "";
        if(!Lib_TokenService::check('delete_category')) $error.= 'Something is wrong';
        if($this->findChildCategory()) $error.= "Present Child Categories. Impossible to delete!";
        if($this->findItemsInCategory()) $error.= "Items in Category. Impossible to delete!";

        return $error;
    }


    public function checkManufacturerInput()
    {

        $error=[];
        $add_new_manufacturer = htmlspecialchars($_POST['add_manufacturer_name']);
        if(empty($add_new_manufacturer))$error['add_manufacturer_name'] = "Нет названия производителя";

        $add_manufacturer_url = htmlspecialchars(($_POST['add_manufacturer_url']));
        if(empty($add_manufacturer_url)) $error['add_manufacturer_url']= "Введите урл производителя";

        return $error;
    }


    public function getManufacturerPageInfo()
    {
        $manufacturer_id = (isset($_GET['id']))? $_GET['id']: false;
       if(isset($_POST['manufacturer_id']))$manufacturer_id = $_POST['manufacturer_id'];

        $manufacturer_name = htmlspecialchars($_POST['add_manufacturer_name']);

        $manufacturer_url = htmlspecialchars(($_POST['add_manufacturer_url']));

        return compact('manufacturer_name', 'manufacturer_url', 'manufacturer_id');

    }

    public function  saveNewManufacturer(){

        $manufacturer_name = htmlspecialchars($_POST['add_manufacturer_name']);
        $manufacturer_url = htmlspecialchars(($_POST['add_manufacturer_url']));
        $translited_titel = Lib_LangService::translite_in_latin($manufacturer_name);

        $sql = "INSERT INTO `manufacturer` (`title`, `translited_title`,  `url`) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt -> bindParam(1, $manufacturer_name, PDO::PARAM_STR);
        $stmt -> bindParam(2, $translited_titel, PDO::PARAM_STR);
        $stmt -> bindParam(3, $manufacturer_url, PDO::PARAM_INT);
        $stmt->execute();

        return true;
    }

    public function getOneManufacturer()
    {
        $sql="SELECT `title`, `url` FROM `manufacturer` WHERE `id`=?";
        $stmt = $this ->conn ->prepare($sql);
        $stmt -> bindParam(1, $_GET['id'], PDO::PARAM_INT);
        $stmt -> execute();
        $res = $stmt ->fetch(PDO::FETCH_ASSOC);
        $res['id'] = (int)$_GET['id'];

        return $res;

    }

    public function saveUpdatedManufacturer()
    {
        $manufacturer_name = htmlspecialchars($_POST['add_manufacturer_name']);
        $manufacturer_url = htmlspecialchars(($_POST['add_manufacturer_url']));
        $manufacturer_id = (int)$_POST['manufacturer_id'];
        $translited_title = Lib_LangService::translite_in_latin($manufacturer_name);


        $sql = "UPDATE `manufacturer` SET `title` =?, `translited_title`=?, `url`= ?  WHERE `id`=?";
        $stmt = $this -> conn ->prepare($sql);
        $stmt -> bindParam(1, $manufacturer_name, PDO::PARAM_STR);
        $stmt -> bindParam(2, $translited_title, PDO::PARAM_STR);
        $stmt -> bindParam(3, $manufacturer_url, PDO::PARAM_STR);

        $stmt -> bindParam(4, $manufacturer_id, PDO::PARAM_INT);

        $stmt -> execute();

        return true;

    }

    public function checkManufacturerDeleteErrors()
    {
        $error = "";
        if(!Lib_TokenService::check('delete_manufacturer')) $error.= 'Something is wrong';

        if($this->findItemsOfManufacturer()) $error.= "There is Items of the Manufacturer. Impossible to delete!";

        return $error;
    }

    private function findItemsOfManufacturer()
    {
        $sql="SELECT `id` FROM `products` WHERE `manf_id`=?";
        $stmt = $this ->conn->prepare($sql);
        $stmt ->bindParam(1, $_POST['id'], PDO::PARAM_INT);
        $stmt ->execute();
        $res = $stmt ->fetch();

        return $res;
    }


    public function destroyManufacturer()
    {
        $sql = "DELETE FROM `manufacturer` WHERE `id`=?";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(1, $_POST['id'], PDO::PARAM_INT);
        $res = $stmt->execute();

        if($res){
            return array("success"=>"the Manufacturer# {$_POST['id']} was successfully deleted");
        }

    }



    //убираем лишни картинки с всех директорий
    public function scavengeImages()
    {
        $sql="SELECT `images` FROM `products` WHERE `images` IS NOT NULL";
        $res= $this->conn->query($sql);
        $result = $res->fetchAll(PDO::FETCH_ASSOC);

        $db_images=[];
        foreach($result as $one){
        $db_images= array_merge($db_images, unserialize($one['images']));
        }



        $sql= "SELECT `avatar` FROM `comments` WHERE `avatar` IS NOT NUll";
        $res= $this->conn->query($sql);
        $result = $res->fetchAll(PDO::FETCH_ASSOC);

        $comments_images=[];
        foreach ($result as $one){
            $comments_images[] = $one['avatar'];
        }

        $sql= "SELECT `image` FROM `slider` WHERE `image` IS NOT NUll";
        $res= $this->conn->query($sql);
        $result = $res->fetchAll(PDO::FETCH_ASSOC);

        $slider_images=[];
        foreach ($result as $one){
            $slider_images[] = $one['image'];
        }

        $sql= "SELECT `image` FROM `carousel` WHERE `image` IS NOT NUll";
        $res= $this->conn->query($sql);
        $result = $res->fetchAll(PDO::FETCH_ASSOC);

        $carousel_images=[];
        foreach ($result as $one){
            $carousel_images[] = $one['image'];
        }

        $this->getAndDeleteRedunduntImages(PATH_SITE.'/uploads/product_images/', $db_images);
        $this->getAndDeleteRedunduntImages(PATH_SITE.'/uploads/product_images/thumbs/', $db_images);

        $this->getAndDeleteRedunduntImages(PATH_SITE.'/uploads/avatars/', $comments_images);

        $this->getAndDeleteRedunduntImages(PATH_SITE.'/uploads/slider/', $slider_images);

        $this->getAndDeleteRedunduntImages(PATH_SITE.'/uploads/carousel/', $carousel_images);


    }



    private function getAndDeleteRedunduntImages($folder, $images_from_bd)
    {
        $product_folder_content= scandir($folder);

        $product_images=[];
        foreach($product_folder_content as $file){
            if(is_file($folder.$file)) {
                $product_images[] = $file;
            }
        }

        $difference= array_diff($product_images, $images_from_bd);

        foreach ($difference as $image){
            @unlink($folder.$image);
        }

    }



}
?>