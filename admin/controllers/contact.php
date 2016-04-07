<?php 

class Admin_Controllers_Contact extends Core_BaseController{

	public function index()
	{
		$model= new Protected_Models_Contacts;
		$contacts = $model->getContacts();

		return['view'=>'contacts/index.php', 'contacts'=>$contacts];
	}


	public function update()
    {
        Lib_TokenService::check('contacts');
        $model= new Protected_Models_Contacts;
        $response = $model->saveUpdatedContact();
        echo json_encode($response);
        exit();
    }


}