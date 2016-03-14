<?php

class Lib_LangService{

    public static function translite_in_Latin($translit_from)
    {
        $translit_in_latin = array(
            'ы'=>'yii',

            'й'=>'ji',
            'ё'=>'yo',
            'я'=>'ya',
            'щ'=>'shc',
            'ш'=>'sh',
            'я'=>'ea',
            'й'=>'ii',
            'ж'=>'zh',
            'ч'=>'ch',
            'ю'=>'iy',
            'ц'=>'ts',
            'у'=>'u',
            'в'=>'w',
            'в'=>'v',
            'и'=>'i',
            'у'=>'y',
            'д'=>'d',
            'т'=>'t',
            'б'=>'b',
            'п'=>'p',
            'н'=>'n',
            'ф'=>'f',
            'з'=>'z',
            'л'=>'l',
            'к'=>'k',
            'с'=>'c',
            'м'=>'m',
            'р'=>'r',
            'с'=>'s',
            'х'=>'h',
            'ж'=>'j',
            'г'=>'g',
            'а'=>'a'
        );

        
        $initial_string = strtolower($translit_from);
        $translited = strtr($initial_string, $translit_in_latin);

        return $translited;
    }


    public static function translite_in_rus($translit_from)
    {
        $translit_in_rus = array(
            'yii'=>'ы',
            'ji'=>'й',
            'yo'=>'ё',
            'ya'=>'я',
            'shc'=>'щ',
            'sh'=>'ш',
            'ea'=>'я',
            'ii'=>'й',
            'zh'=>'ж',
            'ch'=>'ч',
            'iy'=>'ю',
            'ts'=>'ц',
            'u'=>'у',
            'w'=>'в',
            'v'=>'в',
            'i'=>'и',
            'y'=>'у',
            'd'=>'д',
            't'=>'т',
            'b'=>'б',
            'p'=>'п',
            'q'=>'к',
            'n'=>'н',
            'f'=>'ф',
            'z'=>'з',
            'l'=>'л',
            'k'=>'к',
            'c'=>'с',
            'm'=>'м',
            'r'=>'р',
            's'=>'с',
            'h'=>'х',
            'j'=>'ж',
            'g'=>'г',
            '_'=>'',
            'a'=>'а'
        );

             $initial_string = strtolower($translit_from);
        $translited = strtr($initial_string, $translit_in_rus);

        return $translited;
    }

    public static function rus_date()
    {
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
 +получим   
 +20 Декабря 2012 20:13*/


}