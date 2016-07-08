<?php
function pageSwitcher( $switcher, $default_message )
{
	if ( isset($_GET[$switcher]) ) {
		switch ($_GET[$switcher]) {
			case 'about':
				include 'about.php';
				break;
			case 'contacts':
				include 'contacts.php';
				break;
			case 'tests':
				include 'tests.php';
				break;
			case 'shop':
				include 'shop.php';
				break;
			default:
				echo "<p>Задание по практике</p>";
				break;
		}
	} else {
		echo $default_message;
	}
}

function printForm()
{
	echo "
		<a href=\"#x\" class=\"overlay\" id=\"win\"></a>
		<div class=\"popup\">
			<form class=\"popup-form\" action=\"submit.php\" id=\"popup-form\" method=\"POST\">
				<div class=\"input-wrap\">
					<label for=\"fio\">ФИО</label>
					<input type=\"text\" name=\"fio\" id=\"fio\">
					<label for=\"fio\">Телефон*</label>
					<input type=\"tel\" name=\"tel\" id=\"tel\">
					<label for=\"fio\">E-Mail*</label>
					<input type=\"email\" name=\"email\" id=\"email\">
					<input type=\"hidden\" name=\"name\" value=\"{$product['name']}\">
					<input type=\"hidden\" name=\"brand\" value=\"{$product['brand']}\">
					<input type=\"hidden\" name=\"amount\" value=\"{$product['amount']}\">
					<input type=\"hidden\" name=\"date\" value=\"{$product['date']}\">
					<input type=\"hidden\" name=\"price\" value=\"{$product['price']}\">
					<input type=\"hidden\" name=\"image\" value=\"{$product['image']}\">
				</div>
				<div class=\"submit-wrap\">
					<input type=\"button\" class=\"btn btn-green\" value=\"Оформить заказ\" onclick=\"submitContactForm();\">
				</div>
				<div class=\"clear\"></div>
			</form>
			<a href=\"#close\" class=\"close\"></a>
		</div>
	";
}

function printItem()
{
	if ( isset($_GET['id']) ) {
		global $connect;

		$sql = "
			SELECT p.name, p.price, p.amount, b.name AS brand, p.date, p.image FROM product p 
			INNER JOIN brands b ON p.brand = b.id
			WHERE p.id = {$_GET['id']}
		";

		$product = $connect->query($sql)->fetch_assoc();

		echo "
			<div class=\"post\">
				<div class=\"post-image-wrap\">
					<img class=\"post-image\" src=\"{$product['image']}\" data-large=\"{$product['image']}\">
				</div>
				<div class=\"post-details\">
					<h2 class=\"post-title\">{$product['name']}</h2>
					<span class=\"post-price\">{$product['price']} руб.</span>
					Брэнд: {$product['brand']} <br>
					На складе: {$product['amount']} шт.<br>
					Изготовлен: {$product['date']} <br>
					<a href=\"#win\" class=\"btn btn-green\">Купить</a>
				</div>
				<div class=\"clear\"></div>
			</div>
			<a href=\"#x\" class=\"overlay\" id=\"win\"></a>
		<div class=\"popup\">
			<form class=\"popup-form\" action=\"submit.php\" id=\"popup-form\" method=\"POST\">
				<div class=\"input-wrap\">
					<label for=\"fio\">ФИО</label>
					<input type=\"text\" name=\"fio\" id=\"fio\">
					<label for=\"fio\">Телефон*</label>
					<input type=\"tel\" name=\"tel\" id=\"tel\">
					<label for=\"fio\">E-Mail*</label>
					<input type=\"email\" name=\"email\" id=\"email\">
					<input type=\"hidden\" name=\"name\" value=\"{$product['name']}\">
					<input type=\"hidden\" name=\"brand\" value=\"{$product['brand']}\">
					<input type=\"hidden\" name=\"amount\" value=\"{$product['amount']}\">
					<input type=\"hidden\" name=\"date\" value=\"{$product['date']}\">
					<input type=\"hidden\" name=\"price\" value=\"{$product['price']}\">
					<input type=\"hidden\" name=\"image\" value=\"{$product['image']}\">
				</div>
				<div class=\"submit-wrap\">
					<input type=\"button\" class=\"btn btn-green\" value=\"Оформить заказ\" onclick=\"submitContactForm();\">
				</div>
				<div class=\"clear\"></div>
			</form>
			<a href=\"#close\" class=\"close\"></a>
		</div>
		";
	}
}

function printCatList()
{
	if ( isset($_GET['id']) ) {
		global $connect;

		$sql = "
			SELECT p.id, p.name, b.name AS brand, p.date FROM product p 
			INNER JOIN brands b ON p.brand = b.id
			WHERE p.category = {$_GET['id']}
		";
		$products = $connect->query($sql);

		echo "<ul>";
		while ($row = $products->fetch_assoc()) {
			echo "<li><a href=\"?page=shop&type=item&id=" . $row['id'] . "\">" . $row['name'] . ' - ' . $row['brand'] . '</a></li><br>';
		}
		echo "</ul>";
	} else {
		return false;
	}
}

function printBrandList()
{
	if ( isset($_GET['id']) ) {
		global $connect;

		$sql = "
			SELECT p.id, p.name, b.name AS brand, p.date FROM product p 
			INNER JOIN brands b ON p.brand = b.id
			WHERE p.brand = {$_GET['id']}
		";
		$products = $connect->query($sql);

		echo "<ul>";
		while ($row = $products->fetch_assoc()) {
			echo "<li><a href=\"?page=shop&product_id=" . $row['id'] . "\">" . $row['name'] . ' - ' . $row['brand'] . '</a></li><br>';
		}
		echo "</ul>";
	} else {
		return false;
	}
}

function getBrandMenu()
{
	global $connect;

	if ( isset($_GET['page']) ) {
		if ( $_GET['page'] == 'shop' ) {
			if ( isset($_GET['type']) ) {
				switch ($_GET['type']) {
					case 'cat-list':
						if ( isset($_GET['id']) ) {
							$sql = "
								SELECT DISTINCT b.id, b.name AS brand FROM product p
					 			INNER JOIN brands b ON p.brand = b.id
					 			WHERE p.category = {$_GET['id']}
							";
							$result = $connect->query($sql);
						} else {
							$result = $connect->query("SELECT * from brands");
						}

						break;
					
					default:
						$result = $connect->query("SELECT * from brands");
						break;
				}
			}
		} else {
			$result = $connect->query("SELECT * from brands");
		}
	} else {
		$result = $connect->query("SELECT * from brands");
	}

	return $result->fetch_all(MYSQLI_NUM);
}

function printBrandMenu()
{
	echo "<h2 class='btn-brand-menu'>Бренды</h2>";
	echo "<ul class='cat-menu'>";

	$brands = getBrandMenu();
	for ($i = 0; $i < count($brands); $i++) {
		echo "<li><a href=\"?page=shop&type=brand-list&id=" . $brands[$i][0] . "\">" . $brands[$i][1] . "</a></li>";
	}

	echo "</ul>";
}