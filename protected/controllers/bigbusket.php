<?php

class Protected_Controllers_BigBusket  extends Core_BaseController
{
    public function index()
    {
        $model = new Protected_Models_Busket();
        $items=$model->getBigBusket();

        return ['view'=>'bigbusket.php', 'ajax'=> true , 'items'=>$items ];
    }

    public function addIntoBusket()
    {
        Lib_TokenService::check('add_into_busket');

        $model= new Protected_Models_Busket();
        $response = $model->addIntoBusket();

        echo json_encode($response);
        exit();
    }



    function recount()
    {
        Lib_TokenService::check('update_busket');

            $model = new Protected_Models_Busket();
            $model->updateBusket();

            $items = $model->getBigBusket();

            return ['view' => 'bigbusket.php', 'ajax' => true, 'items' => $items];
    }



    public function updateSmallBusket()
    {
        Lib_TokenService::check('update_busket');
        $number= (isset($_SESSION['totalamount']))? (int)$_SESSION['totalamount']: 0;
        $sum= (isset($_SESSION['totalsum']))? (int)$_SESSION['totalsum']:0;
        echo json_encode(["number"=>$number, "sum"=>$sum ]);
        exit();

    }


    public function createOrderForm()
    {
        return ['view'=> 'orderform.php', 'ajax'=>1];
    }

//making the order
    public function order()
    {
      Lib_TokenService::check('order_form');
      $model = new Protected_Models_Busket();
      $inputs = $model->decodePost();

        $error = $model->makeOrder();

        if( !empty($error)){
                $post = Lib_HelperService::cleanInput($inputs);
                return ['view'=>'orderform.php', 'error'=>$error, 'post'=>$post, 'ajax'=>1];
            } else {

                //тут зберигаемо заказ в базу
               $order = $model->saveOrder($inputs);
              
                unset($_SESSION['totalamount']);
                unset($_SESSION['totalsum']);
                unset($_SESSION['busket']);
                //here  desrtoy cookies


                Lib_CookieService::deleteBusketCookies();
                return ['view'=>'orderform.php', 'success'=> true, 'ajax'=>1];
              }


       return ['view'=> 'orderform.php', 'ajax'=>1];
    }

}