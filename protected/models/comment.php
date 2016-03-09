<?php

class Protected_Models_Comment extends Core_DataBase

{

    public function checkComment(){

        $inputs= $this->decodePost();

            $error = array();

            if (strlen($inputs['name']) < 3) {
                $error['name'] = 'Имя должно состоять больше чем из 3 букв';
            }

            if(!filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)){$error['email']='Неверный email';}
            if(empty($inputs['email'])){$error['email']='Пустое поле';}

            if(empty($inputs['message'])){
                $error['message']= 'Пустое поле';
            }

            if ($_SESSION['captcha_keystring'] != $inputs['keystring']) {
                $error['keystring'] = 'неверная капча';
            }
            if (empty($inputs['keystring'])) {
                $error['keystring'] = 'Пустое поле';
            }

            unset($_SESSION['captcha_keystring']);


            return $error;

    }


    public function decodePost(){
        if(isset($_POST['inputs'])) {
            $inputs = json_decode($_POST['inputs']);
            $inputs = (array)$inputs;
            return $inputs;
        }
        return false;
    }


    public function saveComment(){
        $inputs = $this->decodePost();
        $cleaned = AppUser::cleanInput($inputs);
        if(isset($_SESSION['avatar'])) $avatar= $_SESSION['avatar'];


        $sql="INSERT INTO `comments`(`avatar`, `product_id`, `name`, `email`,  `comment`) VALUES (?, ?, ?, ?, ? )";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $avatar, PDO::PARAM_STR);
        $stmt->bindParam(2,$cleaned['product_id'], PDO::PARAM_INT);
        $stmt->bindParam(3, $cleaned['name'], PDO::PARAM_STR);
        $stmt->bindParam(4, $cleaned['email'], PDO::PARAM_STR);

        $stmt->bindParam(5, $cleaned['message'], PDO::PARAM_STR);

        $stmt->execute();
        return true;
    }

    public function getComments()
    {
        $p= (isset($_GET['p']))? $_GET['p']: 0;
        $page = ($p-1)*NUMBERONPAGEADMIN;
        $page = ($page<0)? 0 :$page;

       // $order = (isset($_GET['order']))? $_GET['order']: 'ORDER BY `c`.`created_at` DESC';
        if(!isset($_GET['order'])) $_GET['order']="created_last";

        switch($_GET['order']){
            case "title_abc":
                $order= "ORDER BY `p`.`title` ASC";
                break;
            case "title_cba":
                $order="ORDER BY `p`.`title` DESC";
                break;
            case "name_abc":
                $order= "ORDER BY `c`.`name` ASC";
                break;
            case "name_cba":
                $order="ORDER BY `c`.`name` DESC";
                break;
            case "email_abc":
                $order="ORDER BY `c`.`email` ASC";
                break;
            case "email_cba":
                $order= "ORDER BY `c`.`email` DESC";
                break;
            case "created_first":
                $order = "ORDER BY `c`.`created_at` ASC";
                break;
            case "created_last":
                $order = "ORDER BY `c`.`created_at` DESC";
                break;
            default:
                $order = "ORDER BY `c`.`created_at` DESC";
                break;
        }

        $condition='';

        if(isset($_GET['changed']) && $_GET['changed']!='all'){
            $changed= (int)$_GET['changed'];
            $condition = "WHERE `changed`='$changed'";
        }

        if(isset($_GET['published']) && $_GET['published']!='all'){
            $published = (int)$_GET['published'];
            if($condition!=''){

                $condition.= " AND `c`.`published`= '$published''";
            } else {

                $condition=" WHERE `c`.`published`= '$published'";
            }
        }



        $sql="SELECT `c`.`id`, `c`.`product_id`, `c`.`avatar`, `c`.`name`, `c`.`email`, `c`.`comment`, `c`.`created_at`, `c`.`changed`, `c`.`published`,`p`.`title`
              FROM `comments` `c`
              LEFT JOIN `products` `p` ON `c`.`product_id` = `p`.`id` $condition  $order LIMIT ?,".NUMBERONPAGEADMIN;
        $stmt = $this->conn->prepare($sql);
        $stmt -> bindParam(1,$page, PDO::PARAM_INT);
        $stmt -> execute();

        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //добавляем порядковый номер товарыв для вывода таблиць и розюыраемось з изображениямы
        foreach ($comments as $key=> $value) {
            $number = (!isset($number)) ? ($page + 1) : $number + 1;
            $comments[$key]['number'] = $number;
        }

        return $comments;
    }



    public function countPages()
    {

        $sql= "SELECT COUNT(`id`) AS number FROM `comments`";
        $res= $this->conn->query($sql);
        $res= $res->fetch(PDO::FETCH_ASSOC);
        $pages= ceil($res['number']/NUMBERONPAGEADMIN);

        return $pages;

    }


    public function selectOneComment()
    {
        if(isset($_GET['id'])) $id= $_GET['id'];
        if(isset($_POST['id'])) $id= $_POST['id'];

        $sql = "SELECT `id`, `product_id`, `avatar`, `name`, `email`, `comment`, `created_at`, `changed`, `published`
                FROM  `comments` WHERE `id`=?";
        $stmt = $this->conn ->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt -> execute();
        $comment = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['admin_avatar_change'][$id]= (!is_null($comment['avatar']))? $comment['avatar']: NULL;

        return $comment;
    }


    protected function getCommentInputs()
    {
        $comment =[];
        $comment['name']= htmlspecialchars($_POST['name']);
        $comment['email']= htmlspecialchars($_POST['email']);
        $comment['comment']= htmlspecialchars($_POST['message']);
        if(isset($_POST['id'])) $comment['id']= (int)$_POST['id'];

        return $comment;
    }

    public function checkAdminCommentFields()
    {
        $inputs = $this->getCommentInputs();
;
        $error = array();

        if (strlen($inputs['name']) < 3) {
            $error['name'] = 'Имя должно состоять больше чем из 3 букв';
        }

        if(!filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)){$error['email']='Неверный email';}
        if(empty($inputs['email'])){$error['email']='Пустое поле';}

        if(empty($inputs['comment'])){
            $error['message']= 'Пустое поле';
        }

        return $error;

    }

    public function getCommentPageInfo()
    {
        $comment = $this->getCommentInputs();

        return compact ('comment');
    }





    public function saveUpdatedComment()
    {
         $inputs = $this->getCommentInputs();
         $sql= "UPDATE `comments` SET `avatar`=? ,`name`=?, `email`=?, `comment`=?, `changed`='1', `published`=?  WHERE `id`=?";
         $stmt = $this->conn->prepare($sql);
         $stmt->bindParam(1, $_SESSION['admin_avatar_change'][$_POST['id']], PDO::PARAM_STR);
         $stmt->bindParam(2, $inputs['name'], PDO::PARAM_STR);
         $stmt->bindParam(3, $inputs['email'], PDO::PARAM_STR);
         $stmt->bindParam(4, $inputs['comment'], PDO::PARAM_STR);
         $stmt->bindParam(5, $_POST['published'], PDO::PARAM_STR);

         $stmt->bindParam(6, $_POST['id'], PDO::PARAM_INT);

         $stmt->execute();

         return true;
    }

    public function destroyComment()
    {
       /* $sql="DELETE FROM `comments` WHERE `id`=?";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(1, $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();*/
        $response=["message"=>"The comment# {$_POST['id']} deleted!", "success"=> true ];
        return $response;
    }


    public function unpublishComment()
    {
        $sql="UPDATE `comments` SET `published`='0' WHERE `id` =?";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(1, $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();

        $response=['message'=>"The comment# {$_POST['id']} is unpublished!", "success"=> true];
        return $response;
    }


    public function publishComment()
    {
        $sql="UPDATE `comments` SET `published`='1' WHERE `id` =?";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(1, $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();

        $response=['message'=>"The comment# {$_POST['id']} is published!", "success"=> true];
        return $response;
    }


}