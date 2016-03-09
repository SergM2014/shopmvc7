<?php

class Admin_Controllers_Comment extends Core_BaseController{

    public function index()
    {
        $model = new Protected_Models_Comment();
        $comments= $model->getComments();
        $pages = $model->countPages();


        $nop = Lib_HelperService::washfromRepetition('p');

        $message = $model->getMessage();

        return ['view'=>'comments/comments.php', 'comments'=>$comments, 'message'=> $message, 'nop'=>$nop, 'pages'=>$pages];
    }


    public function edit()
    {
        $model = new Protected_Models_Comment();
        $comment= $model ->selectOneComment();
        return ['view'=> 'comments/edit_comment.php', 'comment'=>$comment];
    }

    public function update()
    {
        Lib_TokenService::check('update_comment');

        $model = new Protected_Models_Comment();
        $error = $model->checkAdminCommentFields();

        if (!empty($error)) {
            $page = $model->getCommentPageInfo();
            extract($page);

            return ['view' => 'comments/edit_comment.php', 'comment'=>$comment, 'error'=>$error];
        } else {
            $result= $model->saveUpdatedComment();
            if ($result) {
                $_SESSION['message'] ="The comment #{$_POST['id']} was successfull updated";
                $this->redirect('index');
            }
        }
    }


    public function destroy()
    {
        Lib_TokenService::check('general_purpose_comment');
        $model = new Protected_Models_Comment();
        $response = $model->destroyComment();
        echo json_encode($response);
        exit();
    }


    public function unpublish()
    {
        Lib_TokenService::check('general_purpose_comment');
        $model = new Protected_Models_Comment();
        $response = $model->unpublishComment();
        echo json_encode($response);
        exit();
    }

    public function publish()
    {
        Lib_TokenService::check('general_purpose_comment');
        $model = new Protected_Models_Comment();
        $response = $model->publishComment();
        echo json_encode($response);
        exit();
    }








}