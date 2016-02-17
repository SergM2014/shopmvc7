<?php

class Lib_HelperService {
    //makeinput clean
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
}