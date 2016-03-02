<?php
class Protected_Models_Catalog extends Core_DataBase
{

    private $amount;
    private $page;
    private $order;
    private $category;
    private $manufacturer;


    public function __construct($in_admin=false)
    {
        $this->amount = ($in_admin)? NUMBERONPAGEADMIN: AMOUNTONPAGE;
        $this->page = (isset($_GET['p']))? $_GET['p']: 1;
        $this->category='';
        $this->manufacturer='';

        parent::__construct();
    }

    public function getCatalog()
    {

        $page= ($this->page-1)*$this->amount;
        $this->order='';


        if(isset($_GET['order'])) {
            switch($_GET['order']){
                case 'abc': $this->order=' ORDER BY `p`.`title` ASC'; break;
                case 'cba': $this->order=' ORDER BY `p`.`title` DESC'; break;
                case 'cheap_first': $this->order=' ORDER BY `p`.`price` ASC'; break;
                case 'expensive_first': $this->order= ' ORDER BY `p`.`price` DESC'; break;
                case 'default': $this->order= ' ORDER BY `p`.`title` ASC'; break;
            }
        }

        if(isset($_GET['category'])){
            $this->category = $this->conn->quote($_GET['category']);
            $this->category = "WHERE `c`.`title`=".$this->category." ";
            $conjunction =" AND";
        }

        if(isset($_GET['manufacturer'])){
            if(!isset($conjunction)) { $conjunction = " WHERE ";} else {$conjunction = " AND "; }
            $name= $this->conn->quote($_GET['manufacturer']);
            $this->manufacturer = $conjunction."`m`.`title`=".$name." ";
        }

        $sql="SELECT `p`.`id` AS product_id , `p`.`author`, `p`.`title` as product_title , `p`.`description`, `p`.`body`, `p`.`price`, `p`.`cat_id`,
              `p`.`manf_id`, `p`.`images`, `c`.`id`, `c`.`title` AS category_title , `c`.`translit_title`, `c`.`parent_id`, `m`.`id` as manufacturer_id , `m`.`title` AS manufacturer_title FROM `products` `p` LEFT JOIN
              `categories` `c` ON `p`.`cat_id` = `c`.`id` LEFT JOIN `manufacturer` `m` ON `p`.`manf_id` = `m`.`id` ".$this->category.$this->manufacturer.$this->order."
               LIMIT ?, ".$this->amount;

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $page, PDO::PARAM_INT);
        $stmt->execute();
        $result= $stmt->fetchAll(PDO::FETCH_ASSOC);

//добавляем порядковый номер товарыв для вывода таблиць и розюыраемось з изображениямы
        foreach ($result as $key=> $value){
            $number =(!isset($number))? ($this->page-1)*$this->amount+1: $number+1;
            $result[$key]['number']= $number;

            if(!empty($value['images'] and $value['images']!= false )){

                $images= unserialize($value['images']);
                $result[$key]['images']= array_values($images);
            }
        }

        return $result;
    }


    public function countPages()
    {

        if(isset($_GET['category'])){
            $this->category = $this->conn->quote($_GET['category']);
            $this->category = "WHERE `c`.`title`=".$this->category." ";
            $conjunction =" AND";
        }

        if(isset($_GET['manufacturer'])){
            if(!isset($conjunction)) { $conjunction = " WHERE ";} else {$conjunction = " AND "; }
            $name= $this->conn->quote($_GET['manufacturer']);
            $this->manufacturer = $conjunction."`m`.`title`=".$name." ";
        }

        $sql= "SELECT COUNT(`p`.`id`) AS number FROM `products` `p` LEFT JOIN
              `categories` `c` ON `p`.`cat_id` = `c`.`id` LEFT JOIN `manufacturer` `m` ON `p`.`id` = `m`.`id` ".$this->category.$this->manufacturer;
        $res= $this->conn->query($sql);
        $res= $res->fetch(PDO::FETCH_ASSOC);
        $pages= ceil($res['number']/$this->amount);

        return $pages;

    }


    public function getleftCatalogMenu( $categories, $parent = 0)
    {
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


    public function getAdminCategoriesTree( $categories, $parent = 0)
    {
        if(!isset($print)){$print='';}

        global $admin_cat_prefix;
        $admin_cat_prefix.='_';


        foreach($categories as $category){
            if($category['parent_id'] ==$parent ){

                $print.='<li ><span class=" admin_categories_item r'.$admin_cat_prefix.'" data-category_id='.$category["id"].' data-parent_id='.$category["parent_id"].'>'.$category['translit_title'].'</span>' ;
                foreach($categories as $sub_cat){
                    if($sub_cat['parent_id']==$category['id']){
                        $flag = TRUE; break;
                    }
                }

                if(isset($flag)){
                    $print.= "<ul>";
                    $print.= $this->getAdminCategoriesTree( $categories, $category['id']);
                    $print.= "</ul>";
                    $print.= "</li>";
                } else{
                    $print.="</li>";
                }
            }
        }
        $admin_cat_prefix= substr( $admin_cat_prefix, 0, -1);
        return $print;
    }


    public function getAdminDropDownCatMenu( $categories, $parent = 0)
    {
        if(!isset($print)){$print='';}

        foreach($categories as $category){
            if($category['parent_id'] ==$parent ){

                $print.='<li ><a href="'.URL.'admin/product/lists?category='. $category['title'] .'">'.$category['translit_title'].'</a>' ;
                foreach($categories as $sub_cat){
                    if($sub_cat['parent_id']==$category['id']){
                        $flag = TRUE; break;
                    }
                }

                if(isset($flag)){
                    $print.= "<ul>";
                    $print.= $this->getAdminDropDownCatMenu( $categories, $category['id']);
                    $print.= "</ul>";
                    $print.= "</li>";
                } else{
                    $print.="</li>";
                }
            }
        }

        return $print;
    }

    public function getManufacturers()
    {
        $sql="SELECT `id`, `title`, `url`  FROM `manufacturer`";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCategoryName()
    {
        $id = (isset($_GET['id']))? $_GET['id']: $_POST['product_id'];

        $sql = "SELECT `translit_title` FROM `categories` WHERE `id`=?";
        $stmt = $this -> conn ->prepare($sql);
        $stmt -> bindParam(1, $id, PDO::PARAM_INT);
        $stmt -> execute();
        $category['name'] = $stmt->fetchColumn();
        $category['id'] = (int)($id);

        return $category;
    }




}

