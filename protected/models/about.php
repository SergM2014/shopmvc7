<?php

class Protected_Models_About extends Core_DataBase{

    public function getInfo()
    {
        $sql="SELECT `about` FROM `background`";
        $res= $this->conn->query($sql);
        $result = $res->fetch(PDO::FETCH_ASSOC);

        return $result['about'];

    }

}