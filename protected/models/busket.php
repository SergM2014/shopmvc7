<?php

class Protected_Models_Busket extends Core_DateBase
{
    public function getBigBusket(){

        $goods =[];

        if(!isset($_SESSION['busket'])) return false;

        $sql="SELECT `p`.`product_id`, `p`.`author`, `p`.`title`,  `p`.`price` FROM `products` `p` LEFT JOIN `categories` `c` ON
                `p`.`cat_id` = `c`.`category_id` LEFT JOIN `manufacturer` `m` ON `p`.`manf_id` = `m`.`manufacturer_id`
                  WHERE `p`.`product_id` = ? ";


        foreach($_SESSION['busket'] as $key=>$value){

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1,$key, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $result['number'] = $_SESSION['busket'][$key];

            $goods[]= $result;
        }

        return $goods;
    }

    //нажатие на клавишу купить  на странице товара
    public function addintobusket(){

        $price= $_POST['price'];
        $id= $_POST['id'];


        $_SESSION['totalsum']= (isset($_SESSION['totalsum']))? $_SESSION['totalsum']+$price : $price;

        $_SESSION['totalamount']= (isset($_SESSION['totalamount']))? $_SESSION['totalamount']+1 : 1;

        $_SESSION['busket'][$id]= (isset($_SESSION['busket'][$id]))? $_SESSION['busket'][$id]+1: 1;
    }

}