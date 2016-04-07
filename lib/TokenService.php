<?php

class Lib_TokenService
{
    public static function _token($action )
    {

        if (DEBUG_MODE) { $period = 300; } else { $period = 86400; }//aбо доба або 5min

        if (!isset($_SESSION['_token']['time']) OR ($_SESSION['_token']['time'] + $period < time()) ) {

            self::fire();
        }

        $_token = $_SESSION['_token'];

        echo $_token[$action];
    }


    public static function fire()
    {
        $_SESSION['_token']['time'] = time();
        $random = uniqid(rand(), true);

        $_SESSION['_token']['add_into_busket'] = md5('add_into_busket' . $random);//+

        $_SESSION['_token']['order_form'] = md5('order_form' . $random);//+
        $_SESSION['_token']['update_small_busket'] = md5('update_small_busket' . $random);//+
        $_SESSION['_token']['update_busket'] = md5('update_busket' . $random);//+

        $_SESSION['_token']['upload_image'] = md5('upload_image' . $random);//+

        $_SESSION['_token']['comment_form'] = md5('comment_form' . $random);//+
        $_SESSION['_token']['enter_admin'] = md5('enter_admin' . $random);

        $_SESSION['_token']['update_product'] = md5('update_product' . $random);
        $_SESSION['_token']['add_product'] = md5('add_product' . $random);
        $_SESSION['_token']['delete_product'] = md5('delete_product' . $random);

        $_SESSION['_token']['create_new_category'] = md5('create_new_category' . $random);
        $_SESSION['_token']['update_category'] = md5('update_category' . $random);
        $_SESSION['_token']['delete_category'] = md5('delete_category' . $random);

        $_SESSION['_token']['create_new_manufacturer'] = md5('create_new_manufacturer' . $random);
        $_SESSION['_token']['update_manufacturer'] = md5('update_manufacturer' . $random);
        $_SESSION['_token']['delete_manufacturer'] = md5('delete_manufacturer' . $random);

        $_SESSION['_token']['update_comment'] = md5('update_comment' . $random);
        $_SESSION['_token']['general_purpose_comment'] = md5('general_purpose_comment' . $random);

        $_SESSION['_token']['create_new_slider'] = md5('create_new_slider' . $random);
        $_SESSION['_token']['update_slider'] = md5('update_slider' . $random);
        $_SESSION['_token']['delete_slider'] = md5('delete_slider' . $random);

        $_SESSION['_token']['create_new_carousel'] = md5('create_new_carousel' . $random);
        $_SESSION['_token']['update_carousel'] = md5('update_carousel' . $random);
        $_SESSION['_token']['delete_carousel'] = md5('delete_carousel' . $random);

        $_SESSION['_token']['about_us'] = md5('about_us' . $random);
        $_SESSION['_token']['contacts'] = md5('contacts' . $random);

    }

    public static function check($action)
    {

        if(!isset($_POST['_token']) OR $_POST['_token']!= $_SESSION['_token'][$action]) {

            if(isset($_POST['ajax'])) {
                echo json_encode(["message"=>"Something went wrong!", "error"=> true ]); exit();
            }

            header('Location:'.$_SERVER['HTTP_REFERER']); exit();
        } else {

            return true;
        }
    }

    public static function checkAdmin(){

        if(!isset($_POST['_token']) OR $_POST['_token']!= $_SESSION['_token']['enter_admin'])  return ['view'=>'index.php'];
    }
}