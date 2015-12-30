<?php
class Protected_Models_Catalog extends Core_DataBase
{

    function getCatalog( ){

        $page= (isset($_GET['p']))? $_GET['p']: 1;

        $page= ($page-1)*AMOUNTONPAGE;
        $order='';
        $category='';
        $manufacturer='';

        if(isset($_GET['order'])) {
            switch($_GET['order']){
                case 'abc': $order=' ORDER BY `p`.`title` ASC'; break;
                case 'cba': $order=' ORDER BY `p`.`title` DESC'; break;
                case 'cheap_first': $order=' ORDER BY `p`.`price` ASC'; break;
                case 'expensive_first': $order= ' ORDER BY `p`.`price` DESC'; break;
                case 'default': $order= ' ORDER BY `p`.`title` ASC'; break;
            }
        }

        if(isset($_GET['category'])){
            $category = $this->conn->quote($_GET['category']);
            $category = "WHERE `c`.`title`=".$category." ";
            $conjunction =" AND";
        }

        if(isset($_GET['manufacturer'])){
            if(!isset($conjunction)) { $conjunction = " WHERE ";} else {$conjunction = " AND "; }
            $name= $this->conn->quote($_GET['manufacturer']);
            $manufacturer = $conjunction."`m`.`title`=".$name." ";
        }

        $sql="SELECT `p`.`id` AS product_id , `p`.`author`, `p`.`title` as product_title , `p`.`description`, `p`.`body`, `p`.`price`, `p`.`cat_id`,
              `p`.`manf_id`, `p`.`images`, `c`.`id`, `c`.`title` AS category_title , `c`.`translit_title`, `c`.`parent_id`, `m`.`id` as manufacturer_id , `m`.`title` AS manufacturer_title FROM `products` `p` LEFT JOIN
              `categories` `c` ON `p`.`cat_id` = `c`.`id` LEFT JOIN `manufacturer` `m` ON `p`.`manf_id` = `m`.`id` ".$category.$manufacturer.$order."
               LIMIT ?, ".AMOUNTONPAGE;

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $page, PDO::PARAM_INT);
        $stmt->execute();
        $result= $stmt->fetchAll(PDO::FETCH_ASSOC);


      /*  foreach ($result as $one){
            if(!empty($one['images'])){
                $result['images']= unserialize($one['images']);
            }
        }*/

        return $result;
    }

    function countPages(){
        $category='';
        $manufacturer='';


        if(isset($_GET['category'])){
            $category = $this->conn->quote($_GET['category']);
            $category = "WHERE `c`.`title`=".$category." ";
            $conjunction =" AND";
        }

        if(isset($_GET['manufacturer'])){
            if(!isset($conjunction)) { $conjunction = " WHERE ";} else {$conjunction = " AND "; }
            $name= $this->conn->quote($_GET['manufacturer']);
            $manufacturer = $conjunction."`m`.`title`=".$name." ";
        }


        //подсчет количества страниц
        $sql= "SELECT COUNT(`p`.`id`) AS number FROM `products` `p` LEFT JOIN
              `categories` `c` ON `p`.`cat_id` = `c`.`id` LEFT JOIN `manufacturer` `m` ON `p`.`id` = `m`.`id` ".$category.$manufacturer;
        $res= $this->conn->query($sql);
        $res= $res->fetch(PDO::FETCH_ASSOC);
        $pages= ceil($res['number']/AMOUNTONPAGE);

        return $pages;

    }


    function getleftCatalogMenu( $categories, $parent = 0){
        if(!isset($print)){$print='';}
        foreach($categories as $category){
            if($category['parent_id'] ==$parent ){

                $print.='<li ><a href="'.URL.'catalog?category='. $category['title'] .'">'.$category['translit_title'].'</a>' ;
                foreach($categories as $sub_cat){
                    if($sub_cat['parent_id']==$category['id']){
                        $flag = TRUE; break;
                    }
                }

                if(isset($flag)){
                    $print.= "<ul>";
                    $print.= $this->getleftCatalogMenu( $categories, $category['id']);
                    $print.= "</ul>";
                    $print.= "</li>";
                } else{
                    $print.="</li>";
                }
            }
        }
        return $print;
    }

    function getManufacturers(){

        $sql="SELECT `id`, `title`, `url`  FROM `manufacturer`";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }




}

