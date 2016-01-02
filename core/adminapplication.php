<?php

class Core_AdminApplication extends Core_Application {

    public function runController($controller){

        if(isset($controller['admin']) && $controller['admin']=='admin'){$name_contr= 'Admin_Controllers_'.$controller[0];}


        $contr = new $name_contr($controller);

        if($contr->notAuthorized) return ['view'=>'index.php'];

        $action = $controller[1];
        $data=call_user_func(array($contr, $action));

        return $data;
    }

    public function getView ($view)//получить представление для контролера
    {
            $view_path = '/admin/views/'.$view;

        return PATH_SITE.$view_path;
    }

}