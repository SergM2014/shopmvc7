<?php

class Protected_Models_Slider extends Core_DataBase{

    private $sliders;
    private  $errors;
    
    public function getSliders()
    {
        $result= $this->conn->query("SELECT * from `slider` ORDER BY `id` DESC");
        $this->sliders = $result->fetchAll(PDO::FETCH_ASSOC);
        return $this->sliders;
    }

    public function checkSliderInputs()
    {
        $url= htmlspecialchars($_POST['slider_url']);
        $title = htmlspecialchars($_POST['slider_title']);
        $this->errors=[];

       if(empty($url)){
           $this->errors['slider_url']='There is no url';
       }

        if(empty($url)){
            $this->errors['slider_title']='There is no title';
        }

        if(!isset($_SESSION['slider']) ){
            $this->errors['slider_image']='No image for slider';
        }

        return $this->errors;
    }

    public function getSliderPageInfo()
    {
        $slider_url= htmlspecialchars($_POST['slider_url']);
        $slider_title= htmlspecialchars($_POST['slider_title']);
        $image=(isset($_SESSION['slider']))? $_SESSION['slider']: null;

        return compact('slider_url', 'slider_title', 'image');
    }

    public function saveNewslider(){

        $slider_url= htmlspecialchars($_POST['slider_url']);
        $slider_title= htmlspecialchars($_POST['slider_title']);
        $sql="INSERT INTO `slider`  (`image`, `url`, `title`) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $_SESSION['slider'], PDO::PARAM_STR);
        $stmt->bindParam(2, $slider_url, PDO::PARAM_STR);
        $stmt->bindParam(3, $slider_title, PDO::PARAM_STR);
        $res = $stmt->execute();

        unset($_SESSION['slider']);

        return $res;

    }


    public function getOneSlider()
    {
        $sql="SELECT * FROM `slider` WHERE `id` =?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['slider']= $result['image'];

        return $result;
    }


    public function saveUpdatedSlider()
    {
        $slider_url= htmlspecialchars($_POST['slider_url']);
        $sql="UPDATE `slider` SET `image`=?, `url`=? WHERE `id`=?";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(1,$_SESSION['slider'], PDO::PARAM_STR);
        $stmt->bindParam(2, $slider_url, PDO::PARAM_STR);
        $stmt->bindParam(3, $_POST['id'], PDO::PARAM_INT);
        $res= $stmt->execute();

        unset($_SESSION['slider']);

        return $res;
    }

    public function destroySlider()
    {

        $sql="DELETE FROM `slider` WHERE `id`=?";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(1, $_POST['id'], PDO::PARAM_INT);
        $res= $stmt->execute();

        if($res){
            $response=["message"=>"The slider# {$_POST['id']} deleted!", "success"=> true ];
            return $response;
        }
    }

}