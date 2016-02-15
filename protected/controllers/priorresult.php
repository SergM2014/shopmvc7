<?php

class Protected_Controllers_Priorresult extends Core_BaseController
{
    public function search()
    {

        if (isset($_POST['_token']) && $_POST['_token'] == $_SESSION['_token']['search_prior_result']) {

            $model = new Protected_Models_Search();
            $results = $model->search();

            return ['view' => 'priorresult.php', 'results' => $results, 'ajax' => true];
        } else
            return ['view' => 'priorresult.php', 'ajax' => true];
    }

    public function getProduct(){

        $model= new Protected_Models_Search();
        $result= $model->getProduct();

        return ['view'=>'productpreview.php', 'result'=>$result, 'ajax'=> true];
    }

}