<?php

class Admin_Controllers_Comment extends Core_BaseController{

    public function index()
    {
        $model = new Protected_Models_Comment();
        $comments= $model->getComments();
        $pages = $model->countPages();


        $nop = Lib_HelperService::washfromRepetition('p');

        $message = $model->getMessage();

        return ['view'=>'comments.php', 'comments'=>$comments, 'message'=> $message, 'nop'=>$nop, 'pages'=>$pages];
    }







}