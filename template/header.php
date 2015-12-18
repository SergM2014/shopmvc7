<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Studing, training, e-shop ">
    <meta name="description" content="Studing of creating of e-shop">
    <title>Shopmvc7!!!</title>

	<link href="/css/default.css" rel="stylesheet" />



    </head>
    <body>
    <div class="wrapper">

        <header class="site-header clearfix">
            <header>
            <h1>Herzlich willkommen in unserem Laden!</h1>
            </header>

            <nav class="site-header clearfix">

                <a href="#" class="logo left">НАШ БРЕНД</a>

                <div  id="touch-button" class="left">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </div>



                 <ul id="menu" >
                     <li class="left"><a href="<?php echo URL; ?>">Главная</a></li>
                     <li class="left"><a href="<?php echo URL.'catalog'; ?>">Каталог</a></li>
                     <li class="left"><a href="<?php echo URL.'about'; ?>">О нас</a></li>
                     <li class="left"><a href="<?php echo URL.'downloads'; ?>">Скачать прайс</a></li>
                     <li class="left"><a href="<?php echo URL.'contacts'; ?>">Контакты</a></li>
                     <li class="left"><a href="<?php echo URL.'admin'; ?>"><?php if(isset($_SESSION['login'])){echo "Админзона";}else {echo "Войти";};  ?></a></li>


                </ul>

                 <span class="right"><label id="search_label" for="search">Поиск </label><input type="text" id="search" name="search" maxlength="20" autofocus ><span>
                <input type="hidden" id="searchPriorResult" value="<?php  echo AppUser::_token('searchPriorResult') ?>">

             </nav>

        <div id="busket">
            <a href="#" class="left">
                <img src="/img/busket.jpg" id="img" >
            </a>
            <div id="busket_content" class="left">
                <p id="updateSmallBusket_token" class="invisible"><?php echo AppUser::_token('updateSmallBusket'); ?></p>
                <span>Количество: <b><?php echo (isset($_SESSION['totalamount']))? $_SESSION['totalamount']: '0'; ?></b> шт.</span>
                <span>Сума: <b><?php echo (isset($_SESSION['totalsum']))? $_SESSION['totalsum']: '0'; ?></b> грн.</span>
            </div>
        </div>

        <div id="prior_result"></div>

        </header><!--/site-header-->

       <section class="content">
