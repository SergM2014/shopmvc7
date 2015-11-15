<?php

class Protected_Models_Product extends Core_DateBase
{
    function getProduct(){

        $sql="SELECT `p`.`product_id` as `product_id`, `p`.`author`, `p`.`title`, `p`.`description`, `p`.`body`, `p`.`price`, `p`.`cat_id`,
              `p`.`manf_id`, `p`.`images`, `c`.`category_id`, `c`.`cat_title`, `c`.`translit_title`, `c`.`parent_id`, `m`.`manufacturer_id`, `m`.`manf_title` FROM `products` `p` LEFT JOIN
              `categories` `c` ON `p`.`cat_id` = `c`.`category_id` LEFT JOIN `manufacturer` `m` ON `p`.`manf_id` = `m`.`manufacturer_id`  WHERE `p`.`product_id` = ? ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
}