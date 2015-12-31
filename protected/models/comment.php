<?php

class Protected_Models_Comment extends Core_DataBase

{

    public function checkComment(){

        $inputs= $this->decodePost();

            $error = array();

            if (strlen($inputs['name']) < 3) {
                $error['name'] = 'Имя должно состоять больше чем из 3 букв';
            }

            if(!filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)){$error['email']='Неверный email';}
            if(empty($inputs['email'])){$error['email']='Пустое поле';}

            if(empty($inputs['message'])){
                $error['message']= 'Пустое поле';
            }

            if ($_SESSION['captcha_keystring'] != $inputs['keystring']) {
                $error['keystring'] = 'неверная капча';
            }
            if (empty($inputs['keystring'])) {
                $error['keystring'] = 'Пустое поле';
            }

            unset($_SESSION['captcha_keystring']);


            return $error;

    }


    public function decodePost(){
        if(isset($_POST['inputs'])) {
            $inputs = json_decode($_POST['inputs']);
            $inputs = (array)$inputs;
            return $inputs;
        }
        return false;
    }


    public function saveComment(){
        $inputs = $this->decodePost();
        $cleaned = AppUser::cleanInput($inputs);
        if(isset($_SESSION['avatar'])) $avatar= $_SESSION['avatar'];


        $sql="INSERT INTO `comments`(`avatar`, `product_id`, `name`, `email`,  `comment`) VALUES (?, ?, ?, ?, ? )";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $avatar, PDO::PARAM_STR);
        $stmt->bindParam(2,$cleaned['product_id'], PDO::PARAM_INT);
        $stmt->bindParam(3, $cleaned['name'], PDO::PARAM_STR);
        $stmt->bindParam(4, $cleaned['email'], PDO::PARAM_STR);

        $stmt->bindParam(5, $cleaned['message'], PDO::PARAM_STR);

        $stmt->execute();
        return true;
    }


}