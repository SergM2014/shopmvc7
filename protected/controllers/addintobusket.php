<?php

class Protected_Controllers_Addintobusket extends Core_BaseController
{
    public function index(){

        $model= new Protected_Models_Busket();
        $model->addIntoBusket();

        return ['view'=>'smallbusket.php','ajax'=> true ];
    }
}