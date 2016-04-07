<?php

class Protected_Models_Ip extends Core_DataBase
{
    private $ip;
    
    private function getClientIP(){

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $this->ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $this->ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else {
            $this->ip=$_SERVER['REMOTE_ADDR'];
        }
        return (string)$this->ip;

    }


    public function checkIP(){

        $this->ip= $this->getClientIP();

        $this->setIP($this->ip);

        return $this->getIP($this->ip);
    }

    private function getIP($ip){
//if more > 3 times per minut
        if($_SESSION ['ip'][$ip]['quantity']>3) return false;
        return true;

    }


    private function setIP($ip){

        if(!isset($_SESSION ['ip'][$ip]['time'])) $_SESSION ['ip'] [$ip]['time'] = time();
// one minute
        if(time()>($_SESSION ['ip'][$ip]['time']+60)){ //echo 11111;
            $_SESSION ['ip'][$ip]['quantity'] = 1;
        } else {
            $_SESSION ['ip'][$ip]['quantity'] = isset($_SESSION['ip'][$ip]['quantity']) ? $_SESSION['ip'][$ip]['quantity']+1 : 1;
        }

        $_SESSION ['ip'][$ip]['time'] = time();

    }


}