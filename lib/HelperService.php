<?php

class Lib_HelperService {
    //makeinput clean as the escappe is the key of massiv
    public static function cleanInput($arr, $esc=null){

        foreach($arr as $key=>$value){
            if ($esc!= $key){$arr[$key]=htmlspecialchars($value, ENT_QUOTES);}
            else{$arr[$key]=$value;}
        }
        return $arr;
    }

    public static function getUrl(){

        $url = $_SERVER['REQUEST_URI'];
        $url= trim($url, '/');
        $question_mark= strpos($url, '?');
        if($question_mark){$url = $url.'&';} else {$url = $url.'?';}
        return $url;
    }

    public static function washfromRepetition($item = ''){

        $url = $_SERVER['REQUEST_URI'];
        $url= trim($url, '/');
        $url= explode('?', $url);
        $url= $url[0];
        //$variables= $url[1];

        $i=0;
        foreach ($_GET as $key=> $value){
            if($key == $item or $value =='catalog' or $key=='url') continue;
            if($key=='p') {$p=$value; continue;}
            if($i == 0){$url.='?'.$key.'='.$value; } else {$url.='&'.$key.'='.$value; }
            $i++;

        }


        $question_mark= strpos($url, '?');
        if($question_mark){$url = $url.'&';} else {$url = $url.'?';}

        return $url;

    }

    public static function ifChecked($key, $value)
    {
        if(isset($_GET[$key]) AND $_GET[$key]==$value) echo "checked";
    }

    public static function ifSelected($key, $value)
    {
        if(isset($_GET[$key]) AND $_GET[$key]==$value) echo "selected";
    }


    public static function tomail( $message, $from, $name, $phone){
         $time_now = Lib_LangService::rus_date("j F Y H:i ", time());
         $to= ADMINEMAIL;
         $title = $time_now. "\n Повидомлення з сайту Имя ".$name." Телефон ".$phone;
        // $message= $message;
         $from = $from;
//Возвращает TRUE, если письмо было принято для передачи, иначе FALSE.
        $mail= mail($to, $title, $message, 'From '.$from);
       
     }



}