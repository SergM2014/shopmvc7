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
		<div class="container">
		   <div id="message" class="message"></div>
		<header class="clearfix">
	
			<h1>Добро пожаловать в панель администрирования системы!</h1>
			
			 



			<nav >
				<a href="<?php echo URL; ?>/" class="left menu_button">Back to site </a>
				
				<a href="/admin" class="left menu_button">back to main admin</a>
				<a href="/admin/product/lists" class="left menu_button">Products</a>
                <a href="/admin/category/lists" class="left menu_button">Categories</a>
                <a href="/admin/manufacturer/lists" class="left menu_button">Manufacturers</a>
                <a href="/admin/category/lists" class="left menu_button">Categories</a>
                <a href="/admin/comment/lists" class="left menu_button">Coments</a>
                <a href="/admin/aboutus" class="left menu_button">About Us</a>
                <a href="/admin/contact" class="left menu_button">Contacts</a>
				
				<div id="admin_exit_btn" class="right menu_button"> <?php echo $_SESSION['login']; ?> (<a href="/admin/exit">Выход</a>)</div>
					

			</nav>
		</header>

    <?php else: ?>
    <div style="width:350px; margin:0 auto;">
    <?php endif; ?>

		