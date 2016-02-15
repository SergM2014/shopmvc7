<?php

class Lib_SessionService {
    static protected function getValue($value)
    {
        $value = $_SESSION[$value];
        return $value;
    }
    static protected function destroySessionValue($value)
    {
        unset($_SESSION[$value]);
    }

    static public function getSessionValue($action)
    {
        $var = self::getValue($action);
        self::destroySessionValue($action);
        return $var;
    }
}