<?php

class Core_CustomApplication extends Core_Application {

    public function runController($controller){

        $name_contr = 'Protected_Controllers_'.$controller[0];

        $action = $controller[1];
        $contr = new $name_contr($controller);

        $data=call_user_func(array($contr, $action));

        return $data;

    }


    public function getView ($view)//получить представление для контролера $view
    {
            $view_path = '/protected/views/'.$view;

        return PATH_SITE.$view_path;
    }



}