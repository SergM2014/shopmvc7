<?php

class Protected_Controllers_BigBusket  extends Core_BaseController
{
    function index()
    {


        $model = new Protected_Models_Busket();
        $items=$model->getBigBusket();





        return ['view'=>'bigbusket.php', 'ajax'=> true , 'items'=>$items ];
    }

    function recount(){

        $model = new Protected_Models_Busket();
        $model->updateBusket();


        $items=$model->getBigBusket();



        return ['view'=>'bigbusket.php', 'ajax'=> true , 'items'=>$items ];
    }

    public function updateSmallBusket(){
        return ['view'=>'smallbusket.php', 'ajax'=> true];
    }

    public function order(){
//var_dump($_POST);

        $inputs= json_decode($_POST['inputs']);
        $inputs_array = (array)$inputs;
        print_r($inputs_array);
        if(isset($_POST['send'])){
            $error=array();
            // if(empty($_POST['name'])){$error['name']= 'Пустое поле';}
            if(strlen($_POST['name'])<3) {$error['name']='Имя должно состоять больше чем из 3 букв';}
            // if(empty($_POST['phone'])){$error['phone']='Пустое поле';}
            $pattern='/^\\+?(38)?(\\-|\\s)?(\\([0-9]{3}\\)|[0-9]{3})?[0-9\\-\\s]{6,10}$/';
            if(!preg_match( $pattern, $_POST['phone'])){$error['phone']='Введите правильный телефон';};
            if(strlen($_POST['phone'])<8){$error['phone']='телефон должен иметь не меньще чем 8 цифр';}

            if( $_SESSION['captcha_keystring']!= $_POST['keystring']){$error['keystring']='неверная капча';}
            if(empty($_POST['keystring'])){$error['keystring']='Пустое поле';}


            unset($_SESSION['captcha_keystring']);

            if(!empty($error)){
                return ['view'=>'orderform.php', 'error'=>$error, 'ajax'=>1];
            } else {
                //тут робым видправку листа
               // Mail::tomail($_POST['message'], $_POST['email']);

                return ['view'=>'orderform.php', 'success'=> true, 'ajax'=>1];}
        }



        return ['view'=> 'orderform.php', 'ajax'=>1];
    }

}