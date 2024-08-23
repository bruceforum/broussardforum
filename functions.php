<?php

/**
 * Scaffold functions and definitions
 *
 * @link       https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package    scaffold
 * @copyright  Copyright (c) 2019, Danny Cooper
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

define('SCAFFOLD_VERSION', '1.2.3');

if (! function_exists('scaffold_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function scaffold_setup()
	{

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__('Primary Menu', 'scaffold'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'scaffold_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Set up block styles
		if (function_exists('register_block_style')) {
			register_block_style(
				'core/button',
				array(
					'name'         => 'reversed',
					'label'        => __('Reversed', 'textdomain'),
					'is_default'   => false,
				)
			);
			register_block_style(
				'core/button',
				array(
					'name'         => 'ghost',
					'label'        => __('Ghost', 'textdomain'),
					'is_default'   => false,
				)
			);
		}

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		// Add image size for blog posts, 600px wide (and unlimited height).
		add_image_size('scaffold-blog', 600);
		// Add image size for full width template, 1040px wide (and unlimited height).
		add_image_size('scaffold-full-width', 1040);

		// Add stylesheet for the WordPress editor.
		add_editor_style('style.css');

		// Add custom color pallete
		add_theme_support('editor-color-palette', array(
			array(
				'name'  => __('Primary', 'scaffold'),
				'slug'  => 'primary',
				'color'	=> '#1724A0',
			),
			array(
				'name'  => __('Secondary', 'scaffold'),
				'slug'  => 'secondary',
				'color' => '#1C52AD',
			),
			array(
				'name'  => __('Font', 'scaffold'),
				'slug'  => 'font',
				'color'	=> '#2E3339',
			),
			array(
				'name'  => __('Font Reversed', 'scaffold'),
				'slug'  => 'font-reversed',
				'color'	=> '#FFFFFF',
			),
		));

		// Add support for custom logo.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 100,
				'width'       => 400,
				'flex-height' => true,
				'flex-width'  => true,
				'header-text' => array('site-title', 'site-description'),
			)
		);

		// Add support for WooCommerce.
		add_theme_support('woocommerce');
		add_theme_support('wc-product-gallery-zoom');
		add_theme_support('wc-product-gallery-lightbox');
		add_theme_support('wc-product-gallery-slider');
	}
endif;
add_action('after_setup_theme', 'scaffold_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function scaffold_content_width()
{
	$GLOBALS['content_width'] = apply_filters('scaffold_content_width', 1040);
}
add_action('after_setup_theme', 'scaffold_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function scaffold_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'scaffold'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'scaffold'),
			'before_widget' => '<section class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action('widgets_init', 'scaffold_widgets_init');

/**
 * Enqueue scripts, fonts, and styles.
 */
function scaffold_scripts()
{
	wp_enqueue_style('scaffold-fonts', get_template_directory_uri() . '/assets/fonts/fonts.css', array(), SCAFFOLD_VERSION);

	wp_enqueue_style('scaffold-style', get_stylesheet_uri(), array(), SCAFFOLD_VERSION);

	wp_enqueue_script('scaffold-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), SCAFFOLD_VERSION, true);

	wp_enqueue_script('scaffold-version', get_template_directory_uri() . '/assets/js/version.js', array(), SCAFFOLD_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	if (class_exists('WooCommerce')) {
		wp_enqueue_style('scaffold-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', 'scaffold-style', SCAFFOLD_VERSION);
	}

	wp_dequeue_style('classic-theme-styles');
}
add_action('wp_enqueue_scripts', 'scaffold_scripts');

/**
 * Custom blocks
 */
add_action('enqueue_block_editor_assets', function () {
	wp_enqueue_script('scaffold-custom-blocks', get_template_directory_uri() . '/assets/js/custom-blocks.js', ['wp-edit-post']);
});

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Load Customizer Settings.
 */
require get_template_directory() . '/inc/customizer/customizer-helper-settings.php';

/**
 * If the WooCommerce plugin is active, load the related functions.
 */
if (class_exists('WooCommerce')) {
	require get_template_directory() . '/woocommerce/functions.php';
}

/**
 * Display the admin notice.
 */
function scaffold_admin_notice()
{
	global $current_user;
	$user_id = $current_user->ID;

	if (! get_user_meta($user_id, 'scaffold_ignore_customizer_notice')) {
?>

		<div class="notice notice-info">
			<p>
				<strong>New!</strong> Easily customize your Scaffold theme design with our new settings - <a target="_blank" href="https://docs.olympusthemes.com/kb/scaffold-theme/customizer-settings-scaffold/?utm_source=notice">Learn More</a>
				<span style="float:right">
					<a href="?scaffold_ignore_customizer_notice=0"><?php esc_html_e('Hide Notice', 'scaffold'); ?></a>
				</span>
			</p>
		</div>

<?php
	}
}
add_action('admin_notices', 'scaffold_admin_notice');

/**
 * Dismiss the admin notice.
 */
function scaffold_dismiss_admin_notice()
{
	global $current_user;
	$user_id = $current_user->ID;
	/* If user clicks to ignore the notice, add that to their user meta */
	if (isset($_GET['scaffold_ignore_customizer_notice']) && '0' === $_GET['scaffold_ignore_customizer_notice']) {
		add_user_meta($user_id, 'scaffold_ignore_customizer_notice', 'true', true);
	}
}
add_action('admin_init', 'scaffold_dismiss_admin_notice');

/**
 * Create a custom query for the Press page
 */
add_filter('query_vars', function ($vars) {
	$vars[] = 'qls'; // As query-loop-search.
	return $vars;
});

add_action( 'pre_get_posts', function( \WP_Query $q ) {
	get_query_var('qls');
    if ( $q->is_search() && !empty(get_query_var('qls'))) {
		$q->set( 'category_name', 'press' );
		$q->set( 's', get_query_var('qls') );
    }
} );

/**
 * Create the Breadcrumbs
 */
function scaffold_breadcrumbs()
{

	// Check if is front/home page, return
	if (is_front_page()) {
		return;
	}

	// Define
	global $post;
	$custom_taxonomy  = ''; // If you have custom taxonomy place it here

	$defaults = array(
		'seperator'   =>  '>',
		'id'          =>  '',
		'classes'     =>  'breadcrumbs container',
		'home_title'  =>  esc_html__('Homepage', '')
	);

	$sep  = '<li class="seperator">' . esc_html($defaults['seperator']) . '</li>';

	// Start the breadcrumb with a link to your homepage
	echo '<ul id="' . esc_attr($defaults['id']) . '" class="' . esc_attr($defaults['classes']) . '">';

	// Creating home link
	echo '<li class="item"><a href="' . get_home_url() . '">' . esc_html($defaults['home_title']) . '</a></li>' . $sep;

	if (is_single()) {

		// Get posts type
		$post_type = get_post_type();

		// If post type is not post
		if ($post_type != 'post') {

			$post_type_object   = get_post_type_object($post_type);
			$post_type_link     = get_post_type_archive_link($post_type);

			echo '<li class="item item-cat"><a href="' . $post_type_link . '">' . $post_type_object->labels->name . '</a></li>' . $sep;
		}

		// Get categories
		$category = get_the_category($post->ID);

		// If category not empty
		if (!empty($category)) {

			// Arrange category parent to child
			$category_values      = array_values($category);
			$get_last_category    = end($category_values);
			// $get_last_category    = $category[count($category) - 1];
			$get_parent_category  = rtrim(get_category_parents($get_last_category->term_id, true, ','), ',');
			$cat_parent           = explode(',', $get_parent_category);

			// Store category in $display_category
			$display_category = '';
			foreach ($cat_parent as $p) {
				$display_category .=  '<li class="item item-cat">' . $p . '</li>' . $sep;
			}
		}

		// If it's a custom post type within a custom taxonomy
		$taxonomy_exists = taxonomy_exists($custom_taxonomy);

		if (empty($get_last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

			$taxonomy_terms = get_the_terms($post->ID, $custom_taxonomy);
			$cat_id         = $taxonomy_terms[0]->term_id;
			$cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
			$cat_name       = $taxonomy_terms[0]->name;
		}

		// Check if the post is in a category
		if (!empty($get_last_category)) {

			echo $display_category;
			echo '<li class="item item-current">' . get_the_title() . '</li>';
		} else if (!empty($cat_id)) {

			echo '<li class="item item-cat"><a href="' . $cat_link . '">' . $cat_name . '</a></li>' . $sep;
			echo '<li class="item-current item">' . get_the_title() . '</li>';
		} else {

			echo '<li class="item-current item">' . get_the_title() . '</li>';
		}
	} else if (is_archive()) {

		if (is_tax()) {
			// Get posts type
			$post_type = get_post_type();

			// If post type is not post
			if ($post_type != 'post') {

				$post_type_object   = get_post_type_object($post_type);
				$post_type_link     = get_post_type_archive_link($post_type);

				echo '<li class="item item-cat item-custom-post-type-' . $post_type . '"><a href="' . $post_type_link . '">' . $post_type_object->labels->name . '</a></li>' . $sep;
			}

			$custom_tax_name = get_queried_object()->name;
			echo '<li class="item item-current">' . $custom_tax_name . '</li>';
		} else if (is_category()) {

			$parent = get_queried_object()->category_parent;

			if ($parent !== 0) {

				$parent_category = get_category($parent);
				$category_link   = get_category_link($parent);

				echo '<li class="item"><a href="' . esc_url($category_link) . '">' . $parent_category->name . '</a></li>' . $sep;
			}

			echo '<li class="item item-current">' . single_cat_title('', false) . '</li>';
		} else if (is_tag()) {

			// Get tag information
			$term_id        = get_query_var('tag_id');
			$taxonomy       = 'post_tag';
			$args           = 'include=' . $term_id;
			$terms          = get_terms($taxonomy, $args);
			$get_term_name  = $terms[0]->name;

			// Display the tag name
			echo '<li class="item-current item">' . $get_term_name . '</li>';
		} else if (is_day()) {

			// Day archive

			// Year link
			echo '<li class="item-year item"><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . ' Archives</a></li>' . $sep;

			// Month link
			echo '<li class="item-month item"><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('M') . ' Archives</a></li>' . $sep;

			// Day display
			echo '<li class="item-current item">' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</li>';
		} else if (is_month()) {

			// Month archive

			// Year link
			echo '<li class="item-year item"><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . ' Archives</a></li>' . $sep;

			// Month Display
			echo '<li class="item-month item-current item">' . get_the_time('M') . ' Archives</li>';
		} else if (is_year()) {

			// Year Display
			echo '<li class="item-year item-current item">' . get_the_time('Y') . ' Archives</li>';
		} else if (is_author()) {

			// Auhor archive

			// Get the author information
			global $author;
			$userdata = get_userdata($author);

			// Display author name
			echo '<li class="item-current item">' . 'Author: ' . $userdata->display_name . '</li>';
		} else {

			echo '<li class="item item-current">' . post_type_archive_title() . '</li>';
		}
	} else if (is_page()) {

		// Standard page
		if ($post->post_parent) {

			// If child page, get parents
			$anc = get_post_ancestors($post->ID);

			// Get parents in the right order
			$anc = array_reverse($anc);

			// Parent page loop
			if (!isset($parents)) $parents = null;
			foreach ($anc as $ancestor) {

				$parents .= '<li class="item-parent item"><a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a></li>' . $sep;
			}

			// Display parent pages
			echo $parents;

			// Current page
			echo '<li class="item-current item">' . get_the_title() . '</li>';
		} else {

			// Just display current page if not parents
			echo '<li class="item-current item">' . get_the_title() . '</li>';
		}
	} else if (is_home()) {

		// posts page
		echo '<li class="item-current item">' . apply_filters('the_title', get_the_title(get_option('page_for_posts'))) . '</li>';
	} else if (is_search()) {

		// Search results page
		echo '<li class="item-current item">Search results for: ' . get_search_query() . '</li>';
	} else if (is_404()) {

		// 404 page
		echo '<li class="item-current item">' . 'Error 404' . '</li>';
	}

	// End breadcrumb
	echo '</ul>';
}
