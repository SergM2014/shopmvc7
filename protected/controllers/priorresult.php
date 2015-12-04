<?php

class Protected_Controllers_Priorresult extends Core_BaseController
{
    public function search(){
        $model = new Protected_Models_Search();
        $results= $model->search();

        return ['view'=>'priorresult.php', 'results'=>$results, 'ajax'=>true];
    }

}