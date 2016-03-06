<?php

class Admin_Controllers_Manufacturer extends Core_BaseController{

    public function index()
    {
        $model = new Protected_Models_Catalog();
        $manufacturers = $model-> getManufacturers();

        $message = $model->getMessage();

        return ['view'=>'manufacturers.php', 'manufacturers'=>$manufacturers, 'message'=> $message];
    }


    public function create()
    {


        return ['view'=>'create_manufacturer.php'];
    }


    public function store()
    {
        Lib_TokenService::check('create_new_manufacturer');


        $model = new Protected_Models_Admin;
        $error = $model->checkManufacturerInput();

        if (!empty($error)) {
            $page = $model->getManufacturerPageInfo();
            extract($page);

            return ['view' => 'create_manufacturer.php', 'manufacturer_name' => $manufacturer_name, 'manufacturer_url'=>$manufacturer_url,  'error' => $error];
        } else {
            $result= $model->saveNewManufacturer();

            if ($result) {

                $_SESSION['message'] ="The new manufacturer is created";

                header('Location: /admin/manufacturer');
            }
        }
    }


    public function edit(){

        $model = new Protected_Models_Admin();
        $manufacturer = $model->getOneManufacturer();

        return ['view' => 'update_manufacturer.php', 'manufacturer_name' => $manufacturer['title'], 'manufacturer_url'=>$manufacturer['url'], 'manufacturer_id'=>(int)$_GET['id']];
    }


    public function update()
    {
        Lib_TokenService::check('update_manufacturer');


        $model = new Protected_Models_Admin;
        $error = $model->checkManufacturerInput();

        if (!empty($error)) {
            $page = $model->getManufacturerPageInfo();
            extract($page);

            return ['view' => 'update_manufacturer.php', 'manufacturer_name' => $manufacturer_name, 'manufacturer_url'=>$manufacturer_url, 'manufacturer_id'=>$manufacturer_id, 'error' => $error];
        } else {
            $result= $model->saveUpdatedManufacturer();

            if ($result) {

                $_SESSION['message'] ="The Manufacturer # {$_POST['manufacturer_id']} was successfull updated";

                header('Location: /admin/manufacturer');
            }
        }
    }


    public function destroy()
    {

        Lib_TokenService::check('delete_manufacturer');
        $model= new Protected_Models_Admin;
        $error = $model->checkManufacturerDeleteErrors();
        if($error !=''){
            $response = array("message" => $error, "error"=> true);
            echo json_encode($response);
            exit();
        }

        $model->destroyManufacturer();

        echo json_encode(array("success"=>"the Manufacturer# {$_POST['id']} was successfully deleted"));
        exit();


    }




}