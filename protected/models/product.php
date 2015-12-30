<?php

class Protected_Models_Product extends Core_DataBase
{
    function getProduct(){

        $sql="SELECT `p`.`id` as `product_id`, `p`.`author`, `p`.`title`, `p`.`description`, `p`.`body`, `p`.`price`, `p`.`cat_id`,
              `p`.`manf_id`, `p`.`images`, `c`.`id`, `c`.`title`, `c`.`translit_title`, `c`.`parent_id`, `m`.`id`, `m`.`title` FROM `products` `p` LEFT JOIN
              `categories` `c` ON `p`.`cat_id` = `c`.`id` LEFT JOIN `manufacturer` `m` ON `p`.`manf_id` = `m`.`id`  WHERE `p`.`id` = ? ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);


        $sql2= "SELECT `avatar`, `name`, `comment`, `created_at` FROM `comments` WHERE `product_id`=? AND `published`='1' ORDER BY `created_at` DESC";
        $stmt = $this->conn->prepare($sql2);
        $stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        $result['comments']= $stmt->fetchAll(PDO::FETCH_ASSOC);





        return $result;
    }
}