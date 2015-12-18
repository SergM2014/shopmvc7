<?php

class Protected_Models_Comment extends Core_DataBase
{

    public function checkComment(){
die(111);
        $inputs= $this->decodePost();


            $error = array();

            if (strlen($inputs['name']) < 3) {
                $error['name'] = 'Имя должно состоять больше чем из 3 букв';
            }

            $pattern = '/^\\+?(38)?(\\-|\\s)?(\\([0-9]{3}\\)|[0-9]{3})?[0-9\\-\\s]{6,10}$/';
            if (!preg_match($pattern, $inputs['phone'])) {
                $error['phone'] = 'Введите правильный телефон';
            };


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
            die(var_dump($inputs));
            return $inputs;
        }
        return false;
    }

    public function saveComment(){
        $inputs = $this->decodePost();
        $cleaned = AppUser::cleanInput($inputs);

       // $busket= $_SESSION['busket'];
        /*$items = $this->getProductName($busket);
        $items_str = serialize($items);*/

        $sql="INSERT INTO `comments`(`name`, `email`,  `message`) VALUES (?, ?, ?, )";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $cleaned['name'], PDO::PARAM_STR);
        $stmt->bindParam(2, $cleaned['email'], PDO::PARAM_STR);

        $stmt->bindParam(3, $cleaned['message'], PDO::PARAM_STR);

        $stmt->execute();
        return true;
    }


}