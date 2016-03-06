<?php

class Protected_Models_Carousel extends Core_DataBase{

    public function getCarouselImage()
    {
        $result= $this->conn->query("SELECT `id`, `image`, `url` from `carousel` ORDER BY `id` DESC");
        $sliders = $result->fetchAll(PDO::FETCH_ASSOC);
        return $sliders;
    }

    public function checkCarouselInputs()
    {
        $url= htmlspecialchars($_POST['carousel_url']);

        $error=[];

       if(empty($url)){
           $error['carousel_url']='There is no url';
       }

        if(!isset($_SESSION['carousel'])){
            $error['carousel_image']='No image for slider';
        }

        return $error;
    }

    public function getCarouselPageInfo()
    {
        $carousel_url= htmlspecialchars($_POST['carousel_url']);
        return compact('carousel_url');
    }

    public function saveNewCarousel(){

        $carousel_url= htmlspecialchars($_POST['carousel_url']);
        $sql="INSERT INTO `carousel`  (`image`, `url`) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $_SESSION['carousel'], PDO::PARAM_STR);
        $stmt->bindParam(2, $carousel_url, PDO::PARAM_STR);
        $res = $stmt->execute();

        unset($_SESSION['carousel']);

        return $res;

    }


    public function getOneCarousel()
    {
        $sql="SELECT * FROM `carousel` WHERE `id` =?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['carousel']= $result['image'];

        return $result;
    }


    public function saveUpdatedCarousel()
    {
        $carousel_url= htmlspecialchars($_POST['carousel_url']);
        $sql="UPDATE `carousel` SET `image`=?, `url`=? WHERE `id`=?";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(1,$_SESSION['carousel'], PDO::PARAM_STR);
        $stmt->bindParam(2, $carousel_url, PDO::PARAM_STR);
        $stmt->bindParam(3, $_POST['id'], PDO::PARAM_INT);
        $res= $stmt->execute();

        unset($_SESSION['carousel']);

        return $res;
    }

    public function destroyCarousel()
    {

        $sql="DELETE FROM `carousel` WHERE `id`=?";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(1, $_POST['id'], PDO::PARAM_INT);
        $res= $stmt->execute();

        if($res){
            $response=["message"=>"The carousel# {$_POST['id']} deleted!", "success"=> true ];
            return $response;
        }
    }

}