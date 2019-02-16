<?php


/**
 * bcn functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package bcn
 */
$theme = wp_get_theme();

if (!function_exists('bcn_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function bcn_setup()
	{
		/*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on bcn, use a find and replace
         * to change 'bcn' to the name of your theme in all the template files.
         */
		load_theme_textdomain('bcn', get_template_directory() . '/languages');

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
		register_nav_menus(array(
			'menu-1' => esc_html__('Primary', 'bcn'),
		));

		/*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

		// Set up the WordPress core custom background feature.
//		add_theme_support( 'custom-background', apply_filters( 'bcn_custom_background_args', array(
//			'default-color' => 'ffffff',
//			'default-image' => '',
//		) ) );

		// Add theme support for selective refresh for widgets.
//		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
//		add_theme_support( 'custom-logo', array(
//			'height'      => 250,
//			'width'       => 250,
//			'flex-width'  => true,
//			'flex-height' => true,
//		)
//        );


//        add_action('admin_enqueue_scripts', 'dfd_themes_admin_scripts');
	}
endif;
add_action('after_setup_theme', 'bcn_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bcn_content_width()
{
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters('bcn_content_width', 640);
}

add_action('after_setup_theme', 'bcn_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bcn_widgets_init()
{
	register_sidebar(array(
		'name' => esc_html__('Default Sidebar', 'bcn'),
		'id' => 'up-sidebar-default',
		'description' => esc_html__('Add widgets here.', 'bcn'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));

	register_sidebar(array(
		'name' => esc_html__('Flip Page', 'bcn'),
		'id' => 'up-sidebar-flip',
		'description' => esc_html__('Add widgets here.', 'bcn'),
		'before_widget' => ' ',
		'after_widget' => ' ',
		'before_title' => '<h2 class="uk-h2 widget-title">',
		'after_title' => '</h2>',
	));

	register_sidebar(array(
		'name' => 'Footer 1',
		'id' => 'up-sidebar-footer1',
		'before_widget' => '<section class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<div class="block-title"><span>',
		'after_title' => '</span></div>'
	));

	register_sidebar(array(
		'name' => 'Footer 2',
		'id' => 'up-sidebar-footer2',
		'before_widget' => '<section class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<div class="block-title"><span>',
		'after_title' => '</span></div>'
	));
}

add_action('widgets_init', 'bcn_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function bcn_scripts()
{
	wp_enqueue_style('bcn-style', get_stylesheet_uri());

	wp_enqueue_style('bcn-theme-style', get_template_directory_uri() . '/css/style.min.css', array(), time());

	//    header libraries
	wp_enqueue_script('bcn-uikit', get_template_directory_uri() . '/js/libraries/uikit.min.js', array(), time());
	wp_enqueue_script('bcn-uikit-icons', get_template_directory_uri() . '/js/libraries/uikit-icons.min.js', array(), time());

	//    footer libraries
	wp_enqueue_script('bcn-library-jquery-2.2.4', get_template_directory_uri() . '/js/libraries/jquery-2.2.4.min.js', array(), time(), true);
	wp_enqueue_script('bcn-library-css-var-polyfill', get_template_directory_uri() . '/js/libraries/css-var-polyfill.min.js', array(), time(), true);
	wp_enqueue_script('bcn-library-sticky-sidebar', get_template_directory_uri() . '/js/libraries/sticky-sidebar.min.js', array(), time(), true);
	wp_enqueue_script('bcn-library-slick', get_template_directory_uri() . '/js/libraries/slick.min.js', array(), time(), true);
	wp_enqueue_script('bcn-library-resizesensor', get_template_directory_uri() . '/js/libraries/resizesensor.min.js', array(), time(), true);

	//    scripts
//    wp_enqueue_script('bcn-navigation', get_template_directory_uri() . '/js/navigation.js', array(),  time(), true);
//    wp_enqueue_script('bcn-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(),  time(), true);
	wp_enqueue_script('bcn-app-min', get_template_directory_uri() . '/js/app.min.js', array(), time(), true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}

add_action('wp_enqueue_scripts', 'bcn_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

//require_once (dirname(__FILE__) . '/redux-framework/config.php');

/**
 * Theme Options
 */
if (!isset($theme_options) && file_exists(get_template_directory() . '/inc/theme-options.php')) {
	require_once(get_template_directory() . '/inc/theme-options.php');
}

/**
 * Theme Options css
 */

function addPanelCSS() {
	wp_register_style(
		'redux-custom-css',
		get_template_directory_uri() . '/css/redux-admin.min.css',
		array( 'redux-admin-css' ), // Be sure to include redux-admin-css so it's appended after the core css is applied
		time(),
		'all'
	);
	wp_enqueue_style('redux-custom-css');
}
// This example assumes your opt_name is set to redux_demo, replace with your opt_name value
add_action( 'redux/page/theme_options/enqueue', 'addPanelCSS' );

/**
 * include templates
 **/

if (!function_exists('up_get_template')) {
	/*
     * get template parts
     */
	function up_get_template($template, $name = null){
		get_template_part( 'template-parts/' . $template, $name);
	}
}
