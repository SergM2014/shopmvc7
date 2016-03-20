<?php

class Protected_Models_Busket extends Core_DataBase
{
    public function getBigBusket()
    {
        $goods =[];

        if(!isset($_SESSION['busket'])) return false;

        $sql="SELECT `p`.`id`, `p`.`author`, `p`.`title`,  `p`.`price` FROM `products` `p` LEFT JOIN `categories` `c` ON
                `p`.`cat_id` = `c`.`id` LEFT JOIN `manufacturer` `m` ON `p`.`manf_id` = `m`.`id`
                  WHERE `p`.`id` = ? ";

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
    public function addIntoBusket()
    {
        $price= filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);

        if(!$price) return false;

        $id= (int)$_POST['id'];


        $_SESSION['totalsum']= (isset($_SESSION['totalsum']))? $_SESSION['totalsum']+$price : $price;

        $_SESSION['totalamount']= (isset($_SESSION['totalamount']))? $_SESSION['totalamount']+1 : 1;

        $_SESSION['busket'][$id]= (isset($_SESSION['busket'][$id]))? $_SESSION['busket'][$id]+1: 1;

        Lib_CookieService::setBusketCookies();

        return ["number"=>$_SESSION['totalamount'], "sum"=>$_SESSION['totalsum'] ];
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

       Lib_CookieService::setBusketCookies();

    }


    public function makeOrder(){

       $inputs= $this->decodePost();

            $error = array();

            if (strlen($inputs['name']) < 3 OR !isset($inputs['name'])) {
                $error['name'] = 'Имя должно состоять больше чем из 3 букв';
            }

            $pattern = '/^\\+?(38)?(\\-|\\s)?(\\([0-9]{3}\\)|[0-9]{3})?[0-9\\-\\s]{6,10}$/';
            if (!preg_match($pattern, $inputs['phone']) ) {
                $error['phone'] = 'Введите правильный телефон';
            };
            if (strlen($inputs['phone']) < 8 OR  !isset($inputs['phone'])) {
                $error['phone'] = 'телефон должен иметь не меньще чем 8 цифр';
            }

            if ($_SESSION['captcha_keystring'] != $inputs['keystring'] OR !isset($inputs['keystring'])) {
                $error['keystring'] = 'неверная капча';
            }
            if (empty($inputs['keystring'])) {
                $error['keystring'] = 'Пустое поле';
            }


            unset($_SESSION['captcha_keystring']);


            return $error;


    }




    public function decodePost(){
        if(isset($_POST)) {
           
            $inputs = (array)$_POST;
            return $inputs;
        }
        return false;
    }

    public function saveOrder($inputs){
        $cleaned = Lib_HelperService::cleanInput($inputs);

        $busket= $_SESSION['busket'];
        $items = $this->getProductName($busket);
        $items_str = serialize($items);

        $sql="INSERT INTO `orders`(`name`, `email`, `phone`, `message`, `products`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $cleaned['name'], PDO::PARAM_STR);
        $stmt->bindParam(2, $cleaned['email'], PDO::PARAM_STR);
        $stmt->bindParam(3, $cleaned['phone'], PDO::PARAM_STR);
        $stmt->bindParam(4, $cleaned['message'], PDO::PARAM_STR);
        $stmt->bindParam(5, $items_str, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }

    private function getProductName($busket){
        $order=[];

        $counter=0;
        $sql= "SELECT `author`, `title` FROM `products` WHERE `id`=?";

        foreach($busket as $key=>$value){

            $result= $this->conn->prepare($sql);
            $result->bindParam(1, $key, PDO::PARAM_INT);
            $result->execute();
            $res= $result->fetch(PDO::FETCH_ASSOC);

            if(!$res) return false;

            $orderItem[$counter]['id'] = $key;
            $orderItem[$counter]['author']=$res['author'];
            $orderItem[$counter]['title'] = $res['title'];
            $orderItem[$counter]['number'] = $value;
            $counter++;
        }
        return $orderItem;
    }

}