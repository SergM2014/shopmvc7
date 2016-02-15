<?php

class Protected_Models_Admin extends Core_DataBase
{
    function getAdmin($data)
    {
        if(isset($_POST['_token']) && $_POST['_token']== $_SESSION['_token']['enter_admin']){

            if (!isset($data['login']) OR !isset($data['password'])) return false;
            $sql = "SELECT login, password FROM users";
            $stmt = $this->conn->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($row['login'] == $data['login'] && $row['password'] == md5($data['password'])) {
                    $_SESSION['admin'] = true;
                    $_SESSION['login'] = $row['login'];

                    return true;
                }
            }
            return false;
        }  else return false;
    }



    private function getClientIP(){

        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return (string)$ip;

    }



    public function checkIP(){

        $ip= $this->getClientIP();

        $this->setIP($ip);

        return $this->getIP($ip);
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
?>