<?php

class Protected_Models_Busket extends Core_DateBase
{
    function getBigBusket(){

        $goods =[];

        if(!isset($_SESSION['busket'])) return false;

        $sql="SELECT `p`.`product_id`, `p`.`author`, `p`.`title`,  `p`.`price`,
                `c`.`cat_title`,  `m`.`manf_title` FROM `products` `p` LEFT JOIN `categories` `c` ON
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

}