<?php

class Core_DataBase {
	protected $conn;
    function __construct(){

     try{ 

           $this->conn = new PDO('mysql:dbname='.NAME_BD.';host='.HOST.'', USER, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES\'UTF8\''));
        }catch(PDOException $e) {die("Ошибка соединения с базой или хостом:".$e->getMessage());}

        if(DEBUG_MODE){
         //на время разработки
         $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	   }
       // die(var_dump($this->conn));
    }

    public function getMessage()
    {
        $message = (isset($_SESSION['message']))? $_SESSION['message']: null;
        unset($_SESSION['message']);

        return $message;
    }

}

?>
