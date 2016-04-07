<?php

class Protected_Models_Contacts extends Core_DataBase
{
    use Lib_CheckProductFieldsService;

    private $errors;
    
    public function getContacts()
    {
        $sql="SELECT `contacts` FROM `background`";
        $res= $this->conn->query($sql);
        $result= $res->fetch(PDO::FETCH_ASSOC);
        
        return $result['contacts'];
    }

     public function saveUpdatedContact()
    {

        $content_to_save= $this->stripTags($_POST['about_us']);

        $sql= "UPDATE `background` SET `contacts`= ?";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(1, $content_to_save, PDO::PARAM_STR);
        $res= $stmt->execute();


        if($res){
            $response=array( "message" => "Contact Information is saved successfully!", "success" => true);
        } else{
            $response=array( "message" => "Something is wrong!", "error" => true);
        }
        $response['time'] =Lib_LangService::rus_date("j F Y H:i:s ", time());


        return $response;
    }


    public function findErrors(){

        $this->errors=array();

        if(strlen($_POST['name'])<3) {$this->errors['name']='Имя должно состоять больше чем из 3 букв';}

        $pattern='/^\\+?(38)?(\\-|\\s)?(\\([0-9]{3}\\)|[0-9]{3})?[0-9\\-\\s]{6,10}$/';
        if(!preg_match( $pattern, $_POST['phone'])){$this->errors['phone']='Введите правильный телефон';};
        if(strlen($_POST['phone'])<8){$this->errors['phone']='телефон должен иметь не меньще чем 8 цифр';}

        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){$this->errors['email']='Неверный email';}
        if(empty($_POST['email'])){$this->errors['email']='Пустое поле';}

        if(empty($_POST['message'])){$this->errors['message']='Пустое поле';}



        if( $_SESSION['captcha_keystring']!= $_POST['keystring']){$this->errors['keystring']='неверная капча';}
        if(empty($_POST['keystring'])){$this->errors['keystring']='Пустое поле';}


        unset($_SESSION['captcha_keystring']);

        return $this->errors;
    }



}