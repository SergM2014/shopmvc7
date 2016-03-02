<!DOCTYPE html>
<html lang="ru">
    <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Admin</title>

	</head>
	
	<body>

	    <?php if (isset($_SESSION['admin'])): ?>

        <div id="message_box" <?php if(!isset($message)) { ?> class="invisible" <?php } ?>><img src="/img/close.png" id="message_close">
            <span><?php if(isset($message)) echo $message; ?></span>
        </div>



		<div class="container">

		<header class="clearfix">
	
			<h1>Добро пожаловать в панель администрирования системы!</h1>
			
			 



			<nav>

				<a href="<?php echo URL; ?>" class="left menu_button">Back to site </a>
				<a href="/admin" class="left menu_button">back to main admin</a>
				<a href="/admin/product/index" class="left menu_button">Products</a>
                <a href="/admin/category/index" class="left menu_button">Categories</a>
                <a href="/admin/manufacturer/index" class="left menu_button">Manufacturers</a>
                <a href="/admin/comment/index" class="left menu_button">Comments</a>
                <a href="/admin/slider/index" class="left menu_button">Slider</a>
                <a href="/admin/carousel/index" class="left menu_button">Carousel</a>
                <a href="/admin/aboutus" class="left menu_button">About Us</a>
                <a href="/admin/contact" class="left menu_button">Contacts</a>
				
				<div id="admin_exit_btn" class="right menu_button"> <?php echo $_SESSION['login']; ?> (<a href="/admin/exit">Выход</a>)</div>

			</nav>
		</header>

			<div id="popup_menu" class="invisible">
				<p><a id="rewiev_item">review</a></p>
				<p><a id="update_item">edit</a></p>
				<p><span id="delete_item">delete</span</p>
			</div>

    <?php else: ?>
    <div style="width:350px; margin:0 auto;">
    <?php endif; ?>

