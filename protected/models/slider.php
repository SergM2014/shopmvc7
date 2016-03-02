<?php

class Protected_Models_Slider extends Core_DataBase{

    public function getSliders()
    {
        $result= $this->conn->query("SELECT * from `slider`");
        $sliders = $result->fetchAll(PDO::FETCH_ASSOC);
        return $sliders;
    }


}