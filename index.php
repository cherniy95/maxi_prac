<?php require_once 'init.php'; ?>
<?php require_once 'include/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="css/style.css">
	<script src="https://yastatic.net/jquery/2.2.3/jquery.min.js"></script>
	<script src="js/zoomsl-3.0.js"></script>
	<script src="js/script.js"></script>
</head>
<body>
	<div class="wrap">
		<div class="header-wrap">
			<div class="header">
				<span class="hello-message">
					Практическое задание
				</span>
			</div>
			<ul class="site-menu">
				<li><a href="http://<?= $_SERVER['HTTP_HOST'] ?>">Главная</a></li>
				<li><a href="?page=about">О себе</a></li>
				<li><a href="?page=contacts">Контакты</a></li>
				<li><a href="?page=tests">Тесты</a></li>
			</ul>
		</div>
		<div class="main-wrap">
			<div class="l-bar">
				<button id="cat-button" class="btn-cat-menu">Показать категории</button>
				<div id="cat-menu-wrap" class="cat-menu-wrap">
				</div>
			</div>
			<div class="content">
				<?php 
					pageSwitcher( 'page', "<p>Задание по практике</p>" );
				?>
			</div>
			<div class="r-bar">
				<?php printBrandMenu(); ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="footer">
			<a href="mailto:cherniy.95@yandex.ru?subject=Вопрос по HTML:">Черноусиков Станислав</a>
		</div>
	</div>
	<script>
		$(".post-image").imagezoomsl({
			zoomrange: [3, 3],
			magnifiersize: [530, 340]
		});
	</script>
</body>
</html>