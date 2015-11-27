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
        return ['view'=> 'orderform.php', 'ajax'=>1];
    }

}