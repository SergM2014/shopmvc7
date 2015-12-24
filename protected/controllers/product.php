<?php

class Protected_Controllers_Product  extends Core_BaseController
{
    public function index()
    {
        $model = new Protected_Models_Product();
        //get informatiom for left vertical menu
        $product = $model->getProduct();

      return ['view'=>'product.php', 'product'=>$product];
    }

    public function comment(){
        //die(var_dump($_POST));
        $model = new Protected_Models_Comment();
        $error = $model->checkComment();
        if(!empty($error)){
            $post= $model->decodePost();
           return ['view'=>'commentBlock.php','error'=>$error, 'post'=> $post, 'ajax'=> true ];
        }

       $success = $model->saveComment($_POST);
        if($success) {
            if(isset($_SESSION['avatar'])){ unset($_SESSION['avatar']);}
            return ['view' => 'savedComment.php', 'ajax' => true];
        }

    }

}