<?php
class Protected_Controllers_404 extends Core_BaseController
{
    function index(){
        return ['view'=>'404.html'];
    }
}