<?php

class Protected_Controllers_Product  extends Core_BaseController
{
    function index()
    {
        $model = new Protected_Models_Product();
        //get informatiom for left vertical menu
        $product = $model->getProduct();

      return ['view'=>'product.php', 'product'=>$product];
    }

}