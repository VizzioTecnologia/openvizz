<?php
	
	$menu_items = array_menu_to_array_tree( $menu_items, 'id', 'parent' );
	
	echo '<nav class="module-wrapper menu-module">' . ul_menu( $menu_items ) . '</nav>';
	
?>
