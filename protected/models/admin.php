<?php

class Protected_Models_Admin extends Core_DataBase
{
    function getAdmin($data)
    {
        if(isset($_POST['_token']) && $_POST['_token']== $_SESSION['_token']['enter_admin']){

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
        }  else return false;
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

        //$category_name= htmlspecialchars($_POST['create_new_category']);
        $entry_category = (isset($_POST['create_new_category']))? $_POST['create_new_category']: $_POST['update_category'];
        $category_name = htmlentities($entry_category);


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
        $rus_category_name = Lib_LangService::translite_in_rus($category_name);
      /*  var_dump($rus_category_name); echo "<br>";
        var_dump($parent_id); echo "<br>";
        var_dump($latin_category_name); die();*/

        $sql = "INSERT INTO `categories` (`title`,  `parent_id`, `translit_title`) VALUES (?, ?, ? )";
        $stmt = $this->conn->prepare($sql);
        $stmt -> bindParam(1, $latin_category_name, PDO::PARAM_STR);
        $stmt -> bindParam(2, $parent_id, PDO::PARAM_INT);
        $stmt -> bindParam(3, $rus_category_name, PDO::PARAM_STR);
        $stmt->execute();
        //var_dump($stmt->errorInfo()); 

        return true;
    }


    public function saveUpdatedCategory()
    {
        $category_name= htmlspecialchars($_POST['update_category']);
        $latin_category_name = Lib_LangService::translite_in_latin($category_name);
        $rus_category_name = Lib_LangService::translite_in_rus($category_name);


        $sql = "UPDATE `categories` SET `translit_title` =?, `title`= ?  WHERE `id`=?";
        $stmt = $this -> conn ->prepare($sql);
        $stmt -> bindParam(1, $rus_category_name, PDO::PARAM_STR);
        $stmt -> bindParam(2, $latin_category_name, PDO::PARAM_STR);

        $stmt -> bindParam(3, $_POST['product_id'], PDO::PARAM_INT);
        $stmt -> execute();
        return true;

    }

    public function destroyItem()
    {
        $sql = "DELETE FROM `categories` WHERE `id`=?";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(1, $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();
        return true;
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
//die(var_dump(Lib_TokenService::check('delete_category')));
        if(!Lib_TokenService::check('delete_category')) $error.= 'Something is wrong';
        if($this->findChildCategory()) $error.= "Present Child Categories. Impossible to delete!";
        if($this->findItemsInCategory()) $error.= "Items in Category. Impossible to delete!";

        return $error;
    }



}
?>