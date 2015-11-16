<?php
 class Language{
      public static function rus_date() {
// Перевод
    $translate = array(
    "am" => "дп",
    "pm" => "пп",
    "AM" => "ДП",
    "PM" => "ПП",
    "Monday" => "Понедельник",
    "Mon" => "Пн",
    "Tuesday" => "Вторник",
    "Tue" => "Вт",
    "Wednesday" => "Среда",
    "Wed" => "Ср",
    "Thursday" => "Четверг",
    "Thu" => "Чт",
    "Friday" => "Пятница",
    "Fri" => "Пт",
    "Saturday" => "Суббота",
    "Sat" => "Сб",
    "Sunday" => "Воскресенье",
    "Sun" => "Вс",
    "January" => "Января",
    "Jan" => "Янв",
    "February" => "Февраля",
    "Feb" => "Фев",
    "March" => "Марта",
    "Mar" => "Мар",
    "April" => "Апреля",
    "Apr" => "Апр",
    "May" => "Мая",
    "June" => "Июня",
    "Jun" => "Июн",
    "July" => "Июля",
    "Jul" => "Июл",
    "August" => "Августа",
    "Aug" => "Авг",
    "September" => "Сентября",
    "Sep" => "Сен",
    "October" => "Октября",
    "Oct" => "Окт",
    "November" => "Ноября",
    "Nov" => "Ноя",
    "December" => "Декабря",
    "Dec" => "Дек",
    "st" => "ое",
    "nd" => "ое",
    "rd" => "е",
    "th" => "ое"
    );
 // если передали дату, то переводим ее
    if (func_num_args() > 1) {
    $timestamp = func_get_arg(1);
    return strtr(date(func_get_arg(0), $timestamp), $translate);
    } else {
// иначе текущую дату
    return strtr(date(func_get_arg(0)), $translate);
    }
    }
 /*rus_date("j F Y H:i ", $result['create_date']);
получим	
20 Декабря 2012 20:13*/

 }



class AppUser {
    //makeinput klean
	public static function cleanInput($arr, $esc){
	   
	  foreach($arr as $key=>$value){ 
	      if ($esc!= $key){$arr[$key]=htmlspecialchars($value);}	  
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









?>