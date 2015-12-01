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
        $inputs = $model->decodePost();



            if( isset($inputs['send']))
                { if( !empty($error)){
                    return ['view'=>'orderform.php', 'error'=>$error, 'inputs'=>$inputs, 'ajax'=>1];
                } else {

                    //тут робым видправку листа и занесення в бд

                    $model->saveOrder($inputs['send']);

                   // Mail::tomail($_POST['message'], $_POST['email']);
                    unset($_SESSION['totalamount']);
                    unset($_SESSION['totalsum']);
                    return ['view'=>'orderform.php', 'success'=> true, 'ajax'=>1];
                  }
                }



        return ['view'=> 'orderform.php', 'ajax'=>1];
    }

}