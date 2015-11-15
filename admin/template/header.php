<!DOCTYPE html>
<html lang="ru">
    <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Admin</title>

	</head>
	
	<body>
		
	    <?php if (isset($_SESSION['login'])): ?>
		<div class="container">
		   <div id="message" class="message"></div>
		<header class="clearfix">
	
			<h1>Добро пожаловать в панель администрирования системы!</h1>
			
			 
		   <?php else: ?>
			   <div style="width:350px; margin:0 auto;">
			<?php endif; ?>


			<nav >
				<a href="<?php echo URL; ?>/admin" class="left">Главная</a>   

				<?php if(isset($_SESSION['login'])): ?>
				
				<a href="/admin/comments" class="left">Коментарии</a>
				
				<div class="right"> <?php echo $_SESSION['login']; ?> (<a href="/admin/exit">Выход</a>)</div>
					
				<?php endif; ?>
			</nav>
		</header>	
		
		