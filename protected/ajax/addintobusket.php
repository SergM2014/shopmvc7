<?php

class Protected_Ajax_Addintobusket  extends Core_BaseController
{
    function index()
    {

        $id= $_POST['id'];


        $_SESSION['busket'][$id]= (isset($_SESSION['busket'][$id])) ? $_SESSION['busket'][$id]+1 : 1;

        $_SESSION['totalsum']= (isset($_SESSION['totalsum'])) ? $_SESSION['totalsum']+$_POST['the_price'] : $_POST['the_price'];

        $_SESSION['totalamount']=0;
        foreach($_SESSION['busket'] as $one){
            $_SESSION['totalamount']+= $one;
        }
        ?>
        <span>Количество: <b><?php echo (isset($_SESSION['totalamount'])) ? $_SESSION['totalamount'] : 0 ; ?></b> шт.</span>
        <span>Сума: <b><?php echo (isset($_SESSION['totalsum'])) ? $_SESSION['totalsum'] : 0 ; ?></b> грн.</span>
    <?php
        exit();
    }
}
