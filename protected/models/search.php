<?php

class Protected_Models_Search extends Core_DateBase
{
    public function search(){

        $search= $_POST['value'];

        $sql="SELECT `product_id`, `title`, `author` FROM `products` WHERE `title` LIKE ? OR `author` LIKE ? LIMIT 1,7";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, "%$search%", PDO::PARAM_STR);
        $stmt->bindValue(2, "%$search%", PDO::PARAM_STR);
        $stmt->execute();
        $results= $stmt->fetchAll(PDO::FETCH_ASSOC);


        return $results;
    }


}