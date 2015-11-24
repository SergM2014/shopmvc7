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

        $items= json_decode($_POST['items']);
        print_r($items);

        echo '<br>';
        $array=(array)$items;

        print_r($array);
        exit();
    }



}