<?php

class Protected_Models_Manufacturer extends Core_DataBase
{
    private $errors;
    
    public function checkManufacturerInput()
    {
        $this->errors=[];
        $add_new_manufacturer = htmlspecialchars($_POST['add_manufacturer_name']);
        if(empty($add_new_manufacturer))$this->errors['add_manufacturer_name'] = "Нет названия производителя";

        $add_manufacturer_url = htmlspecialchars(($_POST['add_manufacturer_url']));
        if(empty($add_manufacturer_url)) $this->errors['add_manufacturer_url']= "Введите урл производителя";

        return $this->errors;
    }


    public function getManufacturerPageInfo()
    {
        $manufacturer_id = (isset($_GET['id']))? $_GET['id']: false;
        if(isset($_POST['manufacturer_id']))$manufacturer_id = $_POST['manufacturer_id'];

        $manufacturer_name = htmlspecialchars($_POST['add_manufacturer_name']);

        $manufacturer_url = htmlspecialchars(($_POST['add_manufacturer_url']));

        return compact('manufacturer_name', 'manufacturer_url', 'manufacturer_id');

    }

    public function  saveNewManufacturer(){

        $manufacturer_name = htmlspecialchars($_POST['add_manufacturer_name']);
        $manufacturer_url = htmlspecialchars(($_POST['add_manufacturer_url']));
        $translited_titel = Lib_LangService::translite_in_latin($manufacturer_name);

        $sql = "INSERT INTO `manufacturer` (`title`, `translited_title`,  `url`) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt -> bindParam(1, $manufacturer_name, PDO::PARAM_STR);
        $stmt -> bindParam(2, $translited_titel, PDO::PARAM_STR);
        $stmt -> bindParam(3, $manufacturer_url, PDO::PARAM_INT);
        $stmt->execute();

        return true;
    }

    public function getOneManufacturer()
    {
        $sql="SELECT `title`, `url` FROM `manufacturer` WHERE `id`=?";
        $stmt = $this ->conn ->prepare($sql);
        $stmt -> bindParam(1, $_GET['id'], PDO::PARAM_INT);
        $stmt -> execute();
        $res = $stmt ->fetch(PDO::FETCH_ASSOC);
        $res['id'] = (int)$_GET['id'];

        return $res;

    }

    public function saveUpdatedManufacturer()
    {
        $manufacturer_name = htmlspecialchars($_POST['add_manufacturer_name']);
        $manufacturer_url = htmlspecialchars(($_POST['add_manufacturer_url']));
        $manufacturer_id = (int)$_POST['manufacturer_id'];
        $translited_title = Lib_LangService::translite_in_latin($manufacturer_name);


        $sql = "UPDATE `manufacturer` SET `title` =?, `translited_title`=?, `url`= ?  WHERE `id`=?";
        $stmt = $this -> conn ->prepare($sql);
        $stmt -> bindParam(1, $manufacturer_name, PDO::PARAM_STR);
        $stmt -> bindParam(2, $translited_title, PDO::PARAM_STR);
        $stmt -> bindParam(3, $manufacturer_url, PDO::PARAM_STR);

        $stmt -> bindParam(4, $manufacturer_id, PDO::PARAM_INT);

        $stmt -> execute();

        return true;

    }

    public function checkManufacturerDeleteErrors()
    {
        $this->errors = "";
        if(!Lib_TokenService::check('delete_manufacturer')) $this->errors.= 'Something is wrong';

        if($this->findItemsOfManufacturer()) $this->errors.= "There is Items of the Manufacturer. Impossible to delete!";

        return $this->errors;
    }

    private function findItemsOfManufacturer()
    {
        $sql="SELECT `id` FROM `products` WHERE `manf_id`=?";
        $stmt = $this ->conn->prepare($sql);
        $stmt ->bindParam(1, $_POST['id'], PDO::PARAM_INT);
        $stmt ->execute();
        $res = $stmt ->fetch();

        return $res;
    }


    public function destroyManufacturer()
    {
        $sql = "DELETE FROM `manufacturer` WHERE `id`=?";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(1, $_POST['id'], PDO::PARAM_INT);
        $res = $stmt->execute();

        if($res){
            return array("success"=>"the Manufacturer# {$_POST['id']} was successfully deleted");
        }

    }

}