<?php

class Protected_Models_Product extends Core_DataBase
{
    public function getProduct(){

        $sql="SELECT `p`.`id` as `product_id`, `p`.`author`, `p`.`title` as `product_title`, `p`.`description`, `p`.`body`, `p`.`price`, `p`.`cat_id`,
              `p`.`manf_id`, `p`.`images`, `c`.`id` as `category_id`, `c`.`title` as `category_title`, `c`.`translit_title` as `category_translit_title`, `c`.`parent_id` as `category_parent_id`,
               `m`.`id` as `manufacturer_id`, `m`.`title` as `manufacturer_title`
               FROM `products` `p` LEFT JOIN `categories` `c` ON `p`.`cat_id` = `c`.`id` LEFT JOIN `manufacturer` `m` ON `p`.`manf_id` = `m`.`id`  WHERE `p`.`id` = ? ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getComments($order = null ){

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

    public function getAllCategoriesForTree(){
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

    public function build_tree($cats,$parent_id, $current_cat_id, $only_parent = false){

        if(is_array($cats) and isset($cats[$parent_id])){
            $tree = '<ul class="ul-treefree">';
            if($only_parent==false){
                foreach($cats[$parent_id] as $cat){
                   if($current_cat_id == $cat['id']) {
                        $tree .= '<li><span  class="current_category" data-id="'.$cat['id'].'">'.$cat['translit_title'].'</span>';
                    } else {
                        $tree .= '<li><span data-id="' . $cat['id'] . '">' . $cat['translit_title'] . '</span>';
                    }
                    $tree .= $this-> build_tree($cats,$cat['id'], $current_cat_id);
                    $tree .= '</li>';
                }
            }elseif(is_numeric($only_parent)){
                $cat = $cats[$parent_id][$only_parent];
                $tree .= '<li><span data-id="'.$cat['id'].'">'.$cat['translit_title'].'</span>';
                $tree .=  $this->build_tree($cats,$cat['id'], $current_cat_id);
                $tree .= '</li>';
            }
            $tree .= '</ul>';
        }
        else return null;
        return $tree;
    }

    public function getManufacturerForList(){
        $sql="SELECT `id`, `title`, `url` FROM `manufacturer`";
        $res= $this->conn->query($sql);
        $result= $res->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }




}