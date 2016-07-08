<?php 

require_once 'init.php';

$result = $connect->query("SELECT * FROM category");

echo "<ul id=\"cat-menu\" class=\"cat-menu\">\n";

while ($row = $result->fetch_assoc()) {
	echo "\t<li><a href=\"?page=shop&type=cat-list&id=" . $row['id'] . "\">" . $row['name'] . "</a></li>\n";
}

echo "</ul>\n"

?>