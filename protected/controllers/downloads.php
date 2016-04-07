<?php

class Protected_Controllers_Downloads extends Core_BaseController
{
    public function index(){

        return ['view'=>'downloads.php'];
    }
}