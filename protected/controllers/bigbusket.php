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


        $model = new Protected_Models_Busket();
        $error = $model->makeOrder();
        //get fields from json
        $inputs = $model->decodePost();

            if( isset($inputs['_token']) && $inputs['_token'] == $_SESSION['_token'])
                { if( !empty($error)){
                    $post = AppUser::cleanInput($inputs);
                    return ['view'=>'orderform.php', 'error'=>$error, /*'inputs'=>$inputs,*/ 'post'=>$post, 'ajax'=>1];
                } else {

                    //тут зберигаемо заказ в базу

                   $order = $model->saveOrder($inputs);

                    if(!$order) return ['view'=> 'orderform.php', 'ajax'=>1];


                    unset($_SESSION['totalamount']);
                    unset($_SESSION['totalsum']);
                    unset($_SESSION['busket']);
                    return ['view'=>'orderform.php', 'success'=> true, 'ajax'=>1];
                  }
                }



        return ['view'=> 'orderform.php', 'ajax'=>1];
    }

}