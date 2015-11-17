<?php

class Protected_Controllers_Addintobusket extends Core_BaseController
{
    public function index(){

        return ['view'=>'addintobusket.php','ajax'=> true ];
    }
}