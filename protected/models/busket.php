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

    public function updateBusket(){

        $items= json_decode($_POST['items']);
        $array=(array)$items;

        unset ($_SESSION['busket']);
        unset($_SESSION['totalamount']);
        unset($_SESSION['totalsum']);

        foreach ($array as $key=>$value){
            if(!empty($value) && $value>0 && is_numeric($key)){
                $value = (int)$value;
                $_SESSION['busket'][$key]= $value;
                $_SESSION['totalamount']= (isset($_SESSION['totalamount']))? $_SESSION['totalamount']+$value : $value;
                $_SESSION['totalsum']= (isset($_SESSION['totalsum']))? $_SESSION['totalsum']+($array[$key.'_price']*$value) : $array[$key.'_price']*$value;
            }
        }


    }


    public function makeOrder(){

       $inputs= $this->decodePost();
//die(var_dump($inputs));
        if(isset($inputs['send'])) {
            $error = array();

            if (strlen($inputs['name']) < 3) {
                $error['name'] = 'Имя должно состоять больше чем из 3 букв';
            }

            $pattern = '/^\\+?(38)?(\\-|\\s)?(\\([0-9]{3}\\)|[0-9]{3})?[0-9\\-\\s]{6,10}$/';
            if (!preg_match($pattern, $inputs['phone'])) {
                $error['phone'] = 'Введите правильный телефон';
            };
            if (strlen($inputs['phone']) < 8) {
                $error['phone'] = 'телефон должен иметь не меньще чем 8 цифр';
            }

            if ($_SESSION['captcha_keystring'] != $inputs['keystring']) {
                $error['keystring'] = 'неверная капча';
            }
            if (empty($inputs['keystring'])) {
                $error['keystring'] = 'Пустое поле';
            }


            unset($_SESSION['captcha_keystring']);
//die(var_dump($error));
            if (empty($error)){ unset($_SESSION['busket']); return false; }

            return $error;
        }
        return false;
    }

    public function decodePost(){
        if(isset($_POST['inputs'])) {
            $inputs = json_decode($_POST['inputs']);
            $inputs = (array)$inputs;
            return $inputs;
        }
        return false;
    }

}