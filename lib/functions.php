<?php

class AppUser {


    public static function setBusketCookies(){

        $expire_time = time()+1209600;
        $value = json_encode($_SESSION['busket']);
        setcookie('busket', $value, $expire_time, '/');
        setcookie('totalsum', (int)$_SESSION['totalsum'], $expire_time, '/');
        setcookie('totalamount', (int)$_SESSION['totalamount'], $expire_time, '/');

    }

    public static function updateBusketCookies(){

    }

    public static function getBusketCookies(){
        return json_decode($_COOKIE('busket'), true);
    }

    public static function initBusket()
    {
        if (!isset($_SESSION['busket'])) {
            if (isset($_COOKIE['busket'])) $_SESSION['busket'] = json_decode($_COOKIE['busket'], true);
            if (isset($_COOKIE['totalsum'])) $_SESSION['totalsum'] = (int)$_COOKIE['totalsum'];
            if (isset($_COOKIE['totalamount'])) $_SESSION['totalamount'] = (int)$_COOKIE['totalamount'];
        }
    }

    public static function deleteBusketCookies(){
        setcookie('busket', NULL, -1, '/');
        setcookie('totalsum', NULL, -1, '/');
        setcookie('totalamount', NULL, -1, '/');
    }


 
	}








?>