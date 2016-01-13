<?php

class Protected_Models_Product extends Core_DataBase
{
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

        return $result;
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

    public function getAllCategoriesForTree()
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



    public function buildSelectTree($cats,$parent_id, $current_category)
    {
        if(is_array($cats) and isset($cats[$parent_id])){

            if($parent_id==0){
                $tree = '<select name="category_id">';
                global $prefix;
                $prefix='';
                $tree .= '<option value="">Без категории</option>';}

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


    public function errorUpdatePage()
    {
        $product= $this->getUpdatedProduct();

        $product['product_id'] = $_POST['product_id'];
        $product['manufacturer_id'] = $_POST['manufacturer_id'];

        $categories= $this->getAllCategoriesForTree();
        $categories_tree =$this->buildSelectTree($categories, 0, $_POST['category']);

        $manufacturers = $this->getManufacturerForList();

       return compact('product', 'categories_tree', 'manufacturers');

    }

    public function checkIfNotEmpty()
    {
        $data= $this->getUpdatedProduct();
        $error=[];
        if(empty($data['title'])) $error['title']= "Пустой заголовок";
        if(empty($data['author'])) $error['author']= "Пустое поле автора";
        if(empty($data['description'])) $error['description']= "Нет описания";
        if(empty($data['body'])) $error['body']= "Пустое поле отрывка";
        if(empty($data['price'])) $error['price']= "Нет цены";

        return $error;
    }



    public function getUpdatedProduct()
    {
        $updated['title'] = htmlspecialchars($_POST['title']);
        $updated['author'] = htmlspecialchars($_POST['author']);
        $updated['description'] = $this->stripTags($_POST['description']);
        $updated['body'] =$this->stripTags($_POST['body']);
        $updated['price'] = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        return $updated;
    }

    private function stripTags($income)
    {
        $content = $this->close_tags($income);

        $content = strip_tags($content,'<a><b><blockquote><br><button><cite><code><div><dd><dl><dt><em><fieldset>
        <font><h1><h2><h3><h4><h5><hr><i><it><img><label><li><ol><p><pre><span><strong><table><tbody><tr>
        <td><th><u><ul>');
        return $content;

    }

    private  function close_tags($content)
    {
        $position = 0;
        $open_tags = array();
        //теги для игнорирования
        $ignored_tags = array('br', 'hr', 'img');

        while (($position = strpos($content, '<', $position)) !== FALSE)
        {
            //забираем все теги из контента
            if (preg_match("|^<(/?)([a-z\d]+)\b[^>]*>|i", substr($content, $position), $match))
            {
                $tag = strtolower($match[2]);
                //игнорируем все одиночные теги
                if (in_array($tag, $ignored_tags) == FALSE)
                {
                    //тег открыт
                    if (isset($match[1]) AND $match[1] == '')
                    {
                        if (isset($open_tags[$tag]))
                            $open_tags[$tag]++;
                        else
                            $open_tags[$tag] = 1;
                    }
                    //тег закрыт
                    if (isset($match[1]) AND $match[1] == '/')
                    {
                        if (isset($open_tags[$tag]))
                            $open_tags[$tag]--;
                    }
                }
                $position += strlen($match[0]);
            }
            else
                $position++;
        }
        //закрываем все теги
        foreach ($open_tags as $tag => $count_not_closed)
        {
            $content .= str_repeat("</{$tag}>", $count_not_closed);
        }

        return $content;
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
        return true;
    }




}