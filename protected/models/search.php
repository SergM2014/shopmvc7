<?php

class Protected_Models_Search extends Core_DataBase
{
    public function search(){

        $search= $_POST['value'];

        $sql="SELECT `id`, `title`, `author` FROM `products` WHERE `title` LIKE ? OR `author` LIKE ? LIMIT 0,7 ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, "%$search%", PDO::PARAM_STR);
        $stmt->bindValue(2, "%$search%", PDO::PARAM_STR);
        $stmt->execute();
        $results= $stmt->fetchAll(PDO::FETCH_ASSOC);


        return $results;
    }

    public function getProduct(){

      $sql="SELECT `id` , `author`, `title`, `description`, `price`
               FROM `products`  WHERE `id` = ? ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;


    }


}