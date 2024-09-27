<?php
/**
 * Template part for displaying the primary navigation menu.
 *
 * @package    scaffold
 * @copyright  Copyright (c) 2019, Danny Cooper
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

?>

<input id="menu-toggle" type="checkbox" />
<label for="menu-toggle" aria-controls="site-menu" aria-expanded="false">
	<button class="menu-toggle" >
		<?php esc_html_e( 'Site Navigation', 'scaffold' ); ?>
	</button>
<label>
<nav id="site-navigation" class="menu-1">
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'menu-1',
			'menu_id'        => 'site-menu',
		)
	);
	?>
</nav><!-- .menu-1 -->
