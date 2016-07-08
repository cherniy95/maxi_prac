<?php 

if ( isset($_POST['fio']) ) {
	$fio = htmlspecialchars( $_POST['fio'] );
	$tel = htmlspecialchars( $_POST['tel'] );
	$email = htmlspecialchars( $_POST['email'] );

	$p_name = htmlspecialchars( $_POST['name'] );
	$p_brand = htmlspecialchars( $_POST['brand'] );
	$p_amount = htmlspecialchars( $_POST['amount'] );
	$p_date = htmlspecialchars( $_POST['date'] );
	$p_price = htmlspecialchars( $_POST['price'] );
	$p_image = htmlspecialchars( $_POST['image'] );

	$message = "
	<!DOCTYPE html>
	<html>
	<head>
		<title>Заказ товара</title>
	</head>
	<body>
	";

	$fio == '' ?: $message .= "Привет, " . htmlspecialchars( $_POST['fio'] ) . "<br>";
	$message .= "<b>Ваш телефон: </b>" . $tel . "<br>";
	$message .= "<br>";
	$message .= "<h3>О товаре</h3>";
	$message .= "<b>Наименование: </b>" . $p_name . "<br>";
	$message .= "<b>Производитель: </b>" . $p_brand . "<br>";
	$message .= "<b>Количество штук: </b>" . $p_amount . "<br>";
	$message .= "<b>Дата изготовления: </b>" . $p_date . "<br>";
	$message .= "<b>Цена: </b>" . $p_price . " руб.<br>";

	$message .= "<b>Изображение:</b><br><img src=\"http://" . $_SERVER['HTTP_HOST'] . $p_image . "\" width='50%' />";

	$message .= "
	</body>
	</html>
	";

	$headers = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	mail($email, "Покупка товара", $message, $headers);

	header("Location: {$_SERVER['HTTP_REFERER']}");
} else {
	header("Location: http://{$_SERVER['HTTP_HOST']}");
}