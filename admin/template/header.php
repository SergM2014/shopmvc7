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
				<a href="<?php echo URL; ?>/admin" class="left">Главная</a>
				
				<a href="/admin/###" class="left">#####</a>
				
				<div class="right"> <?php echo $_SESSION['login']; ?> (<a href="/admin/exit">Выход</a>)</div>
					

			</nav>
		</header>

    <?php else: ?>
    <div style="width:350px; margin:0 auto;">
    <?php endif; ?>

		