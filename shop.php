<?php

if ( isset($_GET['page']) && isset($_GET['type']) ) {
	
	switch ($_GET['type']) {
		case 'cat-list':
			printCatList();
			break;
		case 'brand-list':
			printBrandList();
			break;
		case 'item':
			printItem();
			break;
		
		default:
			// Изменить!
			printCatList();
			break;
	}

}

?>