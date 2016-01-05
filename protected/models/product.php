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

    public function getAllCategories(){
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

    function build_tree($cats,$parent_id,$only_parent = false){
        if(is_array($cats) and isset($cats[$parent_id])){
            $tree = '<ul>';
            if($only_parent==false){
                foreach($cats[$parent_id] as $cat){
                    $tree .= '<li>parent=>'.$cat['parent_id'].'title=>'.$cat['title'].' id=>'.$cat['id'];
                    $tree .= $this-> build_tree($cats,$cat['id']);
                    $tree .= '</li>';
                }
            }elseif(is_numeric($only_parent)){
                $cat = $cats[$parent_id][$only_parent];
                $tree .= '<li>'.$cat['title'].' #'.$cat['id'];
                $tree .=  $this->build_tree($cats,$cat['id']);
                $tree .= '</li>';
            }
            $tree .= '</ul>';
        }
        else return null;
        return $tree;
    }


}