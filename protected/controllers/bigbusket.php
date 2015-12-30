<?php

class Protected_Controllers_BigBusket  extends Core_BaseController
{
    public function index()
    {
        $model = new Protected_Models_Busket();
        $items=$model->getBigBusket();

        return ['view'=>'bigbusket.php', 'ajax'=> true , 'items'=>$items ];
    }

    public function addIntoBusket(){
        $model= new Protected_Models_Busket();
        $model->addIntoBusket();

        return ['view'=>'smallbusket.php','ajax'=> true ];
    }



    function recount(){

        if (isset($_POST['_token']) && $_POST['_token'] == $_SESSION['_token']['updateBusket']) {

            $model = new Protected_Models_Busket();
            $model->updateBusket();

            $items = $model->getBigBusket();

            return ['view' => 'bigbusket.php', 'ajax' => true, 'items' => $items];
        }
        else
            return false;
    }



    public function updateSmallBusket()
    {

       if (isset($_POST['_token']) && $_POST['_token'] == $_SESSION['_token']['updateSmallBusket']) {

            return ['view' => 'smallbusket.php', 'ajax' => true];
        } else {
            return false;}
    }


    public function createOrderForm(){

        return ['view'=> 'orderform.php', 'ajax'=>1];
    }


    public function order(){

        $model = new Protected_Models_Busket();
        $inputs = $model->decodePost();

        if( isset($inputs['_token']) && $inputs['_token'] == $_SESSION['_token']['orderForm'])
        {
            $error = $model->makeOrder();

            if( !empty($error)){
                    $post = AppUser::cleanInput($inputs);
                    return ['view'=>'orderform.php', 'error'=>$error, 'post'=>$post, 'ajax'=>1];
                } else {

                    //тут зберигаемо заказ в базу
                   $order = $model->saveOrder($inputs);

                    if(!$order) return ['view'=> 'orderform.php', 'ajax'=>1];
                    unset($_SESSION['totalamount']);
                    unset($_SESSION['totalsum']);
                    unset($_SESSION['busket']);
                    //how to desrtoy cookies
                    AppUser::deleteBusketCookies();
                    return ['view'=>'orderform.php', 'success'=> true, 'ajax'=>1];
                  }
                }

       return ['view'=> 'orderform.php', 'ajax'=>1];
    }

}