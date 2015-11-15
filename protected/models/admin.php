<?php

class Protected_Models_Admin extends Core_DateBase
{


    function getAdmin($data)
    {
        if (!isset($data['login']) OR !isset($data['password'])) return false;
        $sql = "SELECT login, password FROM users";
        $stmt = $this->conn->query($sql);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['login'] == $data['login'] && $row['password'] == md5($data['password'])) {
                $_SESSION['login'] = $data['login'];
                return true;
            }
        }
        return false;
    }


}
?>