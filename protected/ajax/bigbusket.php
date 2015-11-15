<?php

class Protected_Ajax_Bigbusket  extends Core_BaseController
{
    function index()
    {
        $model = new Protected_Models_Busket;
        $goods = $model->getBigBusket();

        $this->goods = $goods;
    }

}