<?php

class Protected_Models_About extends Core_DataBase{

    use Lib_CheckProductFieldsService;

    public function getInfo()
    {
        $sql="SELECT `about` FROM `background`";
        $res= $this->conn->query($sql);
        $result = $res->fetch(PDO::FETCH_ASSOC);

        return $result['about'];
    }

    public function saveUpdatedAboutus()
    {
        $about_us= $this->stripTags($_POST['about_us']);

        $sql= "UPDATE `background` SET `about`= ?";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(1, $about_us, PDO::PARAM_STR);
        $res= $stmt->execute();

        if($res){
            $response=array( "message" => "AboutUs is saved successfully!", "success" => true);
        } else{
            $response=array( "message" => "Something is wrong!", "error" => true);
        }
        $response['time'] = Lib_LangService::rus_date("j F Y H:i:s ", time());

        return $response;
    }

}