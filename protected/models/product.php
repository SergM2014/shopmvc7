<?php

class Protected_Models_Product extends Core_DataBase
{
    use Lib_CheckProductFieldsService;

//create back_button
    public function __construct($action= null )
    {
        if($action){
            $last_action = ($action== 'edit')? 'create': 'edit';

            if(!isset($_SESSION['history_back']) || (isset($_SESSION['history_back']) && $_SESSION['form']== $last_action)) $_SESSION['history_back']=$_SERVER['HTTP_REFERER'];
            $_SESSION['form']= $action;
        }

        parent::__construct();
    }




    public function getProduct()
    {
        $sql="SELECT `p`.`id` as `product_id`, `p`.`author`, `p`.`title` as `title`, `p`.`description`, `p`.`body`, `p`.`price`, `p`.`cat_id`,
              `p`.`manf_id`, `p`.`images`, `c`.`id` as `category_id`, `c`.`title` as `category_title`, `c`.`translit_title` as `category_translit_title`, `c`.`parent_id` as `category_parent_id`,
               `m`.`id` as `manufacturer_id`, `m`.`title` as `manufacturer_title`
               FROM `products` `p` LEFT JOIN `categories` `c` ON `p`.`cat_id` = `c`.`id` LEFT JOIN `manufacturer` `m` ON `p`.`manf_id` = `m`.`id`  WHERE `p`.`id` = ? ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result['images']){
            $result['images']= unserialize($result['images']);
        }

        return $result;
    }

    public function getProductImages( )
    {
        $sql ="SELECT `images` FROM `products` WHERE `id`=?";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

        $result= $stmt->fetch(PDO::FETCH_ASSOC);

        if($result)  $images= unserialize($result['images']);

        if(isset($images) ) {
            $_SESSION['product_image'] = $images;

            return $images;
        }
    }



    public function getComments($order = null )
    {
        $id= (isset($_GET['id']))? $_GET['id']: $_POST['id'];

        if(!isset($order) OR $order =='new_first'){ $sqlOrder ='ORDER BY `created_at` DESC ';}
        if($order == 'old_first'){$sqlOrder ='ORDER BY `created_at` ASC ';}

        $sql= "SELECT `avatar`, `name`, `comment`, `created_at` FROM `comments` WHERE `product_id`=? AND `published`='1' ".$sqlOrder ;
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $result= $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    protected function getAllCategoriesForTree()
    {
        $sql ="SELECT `id`, `title`, `parent_id`, `translit_title` FROM `categories`";
        $res=$this->conn->query($sql);
        $cats= array();
        while($cat= $res->fetch(PDO::FETCH_ASSOC)){
            $cat_ID[$cat['id']][] =$cat;
            $cats[$cat['parent_id']][$cat['id']]= $cat;
        }

       // die(var_dump($cats));
        return $cats;
    }



    protected function buildSelectTree($cats,$parent_id, $current_category, $manage_category)
    {
        //die(var_dump($current_category));
        if(is_array($cats) and isset($cats[$parent_id])){

            if($parent_id==0){
                $tree = '<select id="category_id" name="category_id">';
                global $prefix;
                $prefix='';
                if($manage_category){
                    $tree .= '<option value="0">Сделать стартовой</option>';
                } else {
                $tree .= '<option value="">Без категории</option>';}
            }

                foreach($cats[$parent_id] as $cat){

                    if($cat['id']==$current_category){ $tree .= '<option selected value="' . $cat['id'] . '">' . $cat['translit_title'] . '</option>';}

                   else   {  $tree .= '<option value="' . $cat['id'] . '">' . $cat['translit_title'] . '</option>';}
                    $tree .= $this-> buildInternalTree($cats, $cat['id'], $current_category);
                }
            }

            unset($GLOBALS['prefix']);

            $tree .= '</select>';

        return $tree;
    }

    public function getCategoriesTree($parent_id, $current_category, $manage_category= false )
    {

        $cats = $this->getAllCategoriesForTree();
        $tree = $this->buildSelectTree($cats, $parent_id, $current_category, $manage_category);

        return $tree;
    }



    private function buildInternalTree($cats,$parent_id, $current_category )
    {

        if(is_array($cats) and isset($cats[$parent_id])) {
            global $prefix;
            $prefix.='-';

            foreach($cats[$parent_id] as $cat){
                if(!isset($tree2)) $tree2='';
                if($cat['id']==$current_category){$tree2 .= '<option selected value="' . $cat['id'] . '">' .$prefix. $cat['translit_title'] . '</option>';}
                 else {$tree2 .= '<option value="' . $cat['id'] . '">' .$prefix. $cat['translit_title'] . '</option>';}
                $tree2 .= $this->buildInternalTree($cats, $cat['id'], $current_category);
            }
            //убрать один дефис из prefixa
            $prefix= substr( $prefix, 0, -1);
            return $tree2;

        } else return null;
    }




    public function getManufacturerForList()
    {
        $sql="SELECT `id`, `title`, `url` FROM `manufacturer`";
        $res= $this->conn->query($sql);
        $result= $res->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function getPageInfo()
    {
        $product= $this->getUpdatedProduct();

        if(isset($_POST['product_id'])){ $product['product_id'] = $_POST['product_id'];}

        $product['manufacturer_id'] = $_POST['manufacturer_id'];

        $categories= $this->getAllCategoriesForTree();
        if(!isset($_POST['category'])){$_POST['category']=null;}
        $categories_tree =$this->buildSelectTree($categories, 0, $_POST['category']);

        $manufacturers = $this->getManufacturerForList();

       return compact('product', 'categories_tree', 'manufacturers');

    }





    public function saveUpdatedProduct()
    {
        $updated= $this->getUpdatedProduct();

        $category_id = ($_POST['category_id']!='')? (int)$_POST['category_id']: null;
        $manufacturer_id = ($_POST['manufacturer_id']!='')? (int)$_POST['manufacturer_id']: null;

        $sql= "UPDATE `products` SET `author`= ?, `title`= ?, `description`=?, `body`= ?, `price`= ?, `cat_id`=?, `manf_id`= ?  WHERE `id`= ?";
        $result = $this->conn->prepare($sql);
        $result->bindParam(1,$updated['author'], PDO::PARAM_STR);
        $result->bindParam(2, $updated['title'], PDO::PARAM_STR);
        $result->bindParam(3, $updated['description'], PDO::PARAM_STR);
        $result->bindParam(4, $updated['body'], PDO::PARAM_STR);
        $result->bindParam(5, $updated['price'], PDO::PARAM_STR);
        $result->bindParam(6, $category_id);
        $result->bindParam(7, $manufacturer_id);
        $result->bindParam(8, $_POST['product_id'], PDO::PARAM_INT);

        $result->execute();

        // here persist the images
        if(isset($_SESSION['product_image']) AND $_SESSION['product_image'] != false) {

            $serialized = serialize($_SESSION['product_image']);
            $sql="UPDATE `products` SET `images`=? WHERE `id`=?";
            $result = $this->conn->prepare($sql);
            $result->bindParam(1,$serialized, PDO::PARAM_STR);
            $result->bindParam(2, $_POST['product_id'], PDO::PARAM_INT);

            $result->execute();

            if(isset($_SESSION['delete_image_product'])){
                foreach($_SESSION['delete_image_product'] as $image ){
                    @unlink(PATH_SITE.'/uploads/product_images/'.$image);
                    @unlink(PATH_SITE.'/uploads/product_images/thumbs/'.$image);
                }
                unset($_SESSION['delete_image_product']);
            }
            unset($_SESSION['product_image']);
        }
        // избегаем повторного сохранения в базу при обновленнии страницы
        unset($_SESSION['_token']['update_product']);
        return true;
    }


    public function saveAddedProduct()
    {
        $added= $this->getUpdatedProduct();

        if(isset($_SESSION['product_image'])) {

            $serialized = serialize($_SESSION['product_image']);

            if(isset($_SESSION['delete_image_product'])){
                foreach($_SESSION['delete_image_product'] as $image ){
                    @unlink(PATH_SITE.'/uploads/product_images/'.$image);
                    @unlink(PATH_SITE.'/uploads/product_images/thumbs/'.$image);
                }
                unset($_SESSION['delete_image_product']);
            }
            unset($_SESSION['product_image']);
        }

        $serialized = (isset($serialized))? $serialized: null;
        $category_id = ($_POST['category_id']!='')? (int)$_POST['category_id']: null;
        $manufacturer_id = ($_POST['manufacturer_id']!='')? (int)$_POST['manufacturer_id']: null;

        $sql= "INSERT INTO `products` ( `author`, `title`, `description`, `body`, `price`, `cat_id`, `manf_id`, `images`)  VALUES  (?, ?, ?, ?, ?, ?, ?, ?)";
        $result = $this->conn->prepare($sql);
        $result->bindParam(1,$added['author'], PDO::PARAM_STR);
        $result->bindParam(2, $added['title'], PDO::PARAM_STR);
        $result->bindParam(3, $added['description'], PDO::PARAM_STR);
        $result->bindParam(4, $added['body'], PDO::PARAM_STR);
        $result->bindParam(5, $added['price'], PDO::PARAM_STR);
        $result->bindParam(6, $category_id);
        $result->bindParam(7, $manufacturer_id);
        $result->bindParam(8, $serialized, PDO::PARAM_STR);


        $result->execute();

        // избегаем повторного сохранения в базу при обновленнии страницы
        unset($_SESSION['_token']['add_product']);

        return true;
    }

    public function destroyItem()
    {
        $sql = "DELETE FROM `products` WHERE `id`=?";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(1, $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }




    public function successSavedRedirectionView()
    {
        $_SESSION['message'] ="The new product is saved";
        $history_back = Lib_SessionService::getSessionValue('history_back');
        header('Location: '.$history_back);
    }

    public function successUpdatedRedirectionView()
    {
        $_SESSION['message'] ='The  product  '. $_POST['product_id'].' is changed and saved successfully';
        $history_back = Lib_SessionService::getSessionValue('history_back');
        header('Location: '.$history_back);
    }





}