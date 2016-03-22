<?php

class Protected_Controllers_Product  extends Core_BaseController
{
    public function index()
    {
        $model = new Protected_Models_Product();
        //get informatiom for left vertical menu
        $product = $model->getProduct();
        $comments = $model->getComments();


      return ['view'=>'product.php', 'product'=>$product, 'comments'=>$comments ];
    }

    public function comment()
    {
        Lib_TokenService::check('comment_form');

        $model = new Protected_Models_Comment();
        $error = $model->checkComment();
        if (!empty($error)) {
            $post = $model->cleanInput($_POST, 'message');
            return ['view' => 'commentBlock.php', 'error' => $error, 'post' => $post, 'ajax' => true];
        }

        $model->saveComment($_POST);


       return ['view' => 'savedComment.php', 'ajax' => true];



    }

    public function orderComment()
    {
            $model= new Protected_Models_Product();
            $comments= $model->getComments($_POST['order']);

            return ['view'=>'orderedComments.php', 'comments'=>$comments, 'ajax'=> true ];
    }

}