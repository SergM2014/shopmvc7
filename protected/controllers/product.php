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

    public function comment(){
        //check token
        if(isset($_POST['_token']) && $_POST['_token']== $_SESSION['_token']['commentForm']) {


            $model = new Protected_Models_Comment();
            $error = $model->checkComment();
            if (!empty($error)) {
                $post = $model->decodePost();
                return ['view' => 'commentBlock.php', 'error' => $error, 'post' => $post, 'ajax' => true];
            }

            $success = $model->saveComment($_POST);
            if ($success) {
                if (isset($_SESSION['avatar'])) {
                    unset($_SESSION['avatar']);
                }
                return ['view' => 'savedComment.php', 'ajax' => true];
            }
        } else {
            return ['view'=>'commentBlock.php', 'ajax'=>true ];
        }

    }

    public function orderComment(){
        if(isset($_POST['_token']) && $_POST['_token']== $_SESSION['_token']['commentsOrder']) {

            $model= new Protected_Models_Product();
            $comments= $model->getComments($_POST['order']);

            return ['view'=>'orderedComments.php', 'comments'=>$comments, 'ajax'=> true ];

        }
        exit();
    }

}