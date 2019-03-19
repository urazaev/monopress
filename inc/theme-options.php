<?php
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if (!class_exists('Redux')) {
	return;
}

// This is your option name where all the Redux data is stored.
$opt_name = "theme_options";

// This line is only for altering the demo. Can be easily removed.
$opt_name = apply_filters('theme_options/opt_name', $opt_name);

/*
 *
 * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
 *
 */

$sampleHTML = '';
if (file_exists(dirname(__FILE__) . '/info-html.html')) {
	Redux_Functions::initWpFilesystem();

	global $wp_filesystem;

	$sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
}

// Background Patterns Reader
$sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
$sample_patterns_url = ReduxFramework::$_url . '../sample/patterns/';
$sample_patterns = array();

if (is_dir($sample_patterns_path)) {

	if ($sample_patterns_dir = opendir($sample_patterns_path)) {
		$sample_patterns = array();

		while (($sample_patterns_file = readdir($sample_patterns_dir)) !== false) {

			if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
				$name = explode('.', $sample_patterns_file);
				$name = str_replace('.' . end($name), '', $sample_patterns_file);
				$sample_patterns[] = array(
					'alt' => $name,
					'img' => $sample_patterns_url . $sample_patterns_file
				);
			}
		}
	}
}

/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
	// TYPICAL -> Change these values as you need/desire
	'opt_name' => $opt_name,
	// This is where your data is stored in the database and also becomes your global variable name.
	'display_name' => 'BCN ' . esc_html__('Options', 'bcn') . '',
	// Name that appears at the top of your panel
	'display_version' => $theme->get('Version'),
	// Version that appears at the top of your panel
	'menu_type' => 'menu',
	//Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
	'allow_sub_menu' => true,
	// Show the sections below the admin menu item or not
	'menu_title' => __('Theme Options', 'bcn'),
	'page_title' => __('Theme Options', 'bcn'),
	// You will need to generate a Google API key to use this feature.
	// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
	'google_api_key' => '',
	// Set it you want google fonts to update weekly. A google_api_key value is required.
	'google_update_weekly' => false,
	// Must be defined to add google fonts to the typography module
	'async_typography' => false,
	// Use a asynchronous font on the front end or font string
	//'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
	'admin_bar' => true,
	// Show the panel pages on the admin bar
	'admin_bar_icon' => 'dashicons-portfolio',
	// Choose an icon for the admin bar menu
	'admin_bar_priority' => 50,
	// Choose an priority for the admin bar menu
	'global_variable' => '',
	// Set a different name for your global variable other than the opt_name
	'dev_mode' => false,
	// Show the time the page took to load, etc
	'update_notice' => true,
	// If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
	'customizer' => true,
	// Enable basic customizer support
	//'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
	//'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

	// OPTIONAL -> Give you extra features
	'page_priority' => 2,
	// Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
	'page_parent' => 'themes.php',
	// For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	'page_permissions' => 'manage_options',
	// Permissions needed to access the options panel.
	'menu_icon' => '',
	// Specify a custom URL to an icon
	'last_tab' => '',
	// Force your panel to always open to a specific tab (by id)
	'page_icon' => 'icon-themes',
	// Icon displayed in the admin panel next to your menu_title
	'page_slug' => 'up_options',
	// Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
	'save_defaults' => true,
	// On load save the defaults to DB before user clicks save or not
	'default_show' => false,
	// If true, shows the default value next to each field that is not the default value.
	'default_mark' => '',
	// What to print by the field's title if the value shown is default. Suggested: *
	'show_import_export' => true,
	// Shows the Import/Export panel when not used as a field.

	// CAREFUL -> These options are for advanced use only
	'transient_time' => 60 * MINUTE_IN_SECONDS,
	'output' => true,
	// Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
	'output_tag' => true,
	// Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
	// 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

	// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
	'database' => '',
	// possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
	'use_cdn' => true,
	// If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

	// HINTS
	'hints' => array(
		'icon' => 'el el-question-sign',
		'icon_position' => 'right',
		'icon_color' => 'lightgray',
		'icon_size' => 'normal',
		'tip_style' => array(
			'color' => 'red',
			'shadow' => true,
			'rounded' => false,
			'style' => '',
		),
		'tip_position' => array(
			'my' => 'top left',
			'at' => 'bottom right',
		),
		'tip_effect' => array(
			'show' => array(
				'effect' => 'slide',
				'duration' => '500',
				'event' => 'mouseover',
			),
			'hide' => array(
				'effect' => 'slide',
				'duration' => '500',
				'event' => 'click mouseleave',
			),
		),
	)
);

// ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
$args['admin_bar_links'][] = array(
	'id' => 'bcn-docs',
	'href' => 'https://docs.urazaev.com/bcn-wp/',
	'title' => __('Documentation', 'bcn'),
);

$args['admin_bar_links'][] = array(
	//'id'    => 'bcn-support',
	'href' => 'https://up.ticksy.com/',
	'title' => __('Support', 'bcn'),
);

$args['share_icons'][] = array(
	'url' => 'https://www.facebook.com/urazaev.com',
	'title' => 'Like us on Facebook',
	'icon' => 'el el-facebook'
);
$args['share_icons'][] = array(
	'url' => 'https://twitter.com/UrazaevCom',
	'title' => 'Follow us on Twitter',
	'icon' => 'el el-twitter'
);


// Panel Intro text -> before the form
if (!isset($args['global_variable']) || $args['global_variable'] !== false) {
	if (!empty($args['global_variable'])) {
		$v = $args['global_variable'];
	} else {
		$v = str_replace('-', '_', $args['opt_name']);
	}
	$args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'bcn'), $v);
} else {
	$args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'bcn');
}

// Add content after the form.
$args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'bcn');

Redux::setArgs($opt_name, $args);

/*
 * ---> END ARGUMENTS
 */


/*
 * ---> START HELP TABS
 */
//
//$tabs = array(
//    array(
//        'id' => 'redux-help-tab-1',
//        'title' => __('Theme Information 1', 'bcn'),
//        'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'bcn')
//    ),
//    array(
//        'id' => 'redux-help-tab-2',
//        'title' => __('Theme Information 2', 'bcn'),
//        'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'bcn')
//    )
//);
//Redux::setHelpTab($opt_name, $tabs);
//
//// Set the help sidebar
//$content = __('<p>This is the sidebar content, HTML is allowed.</p>', 'bcn');
//Redux::setHelpSidebar($opt_name, $content);


/*
 * <--- END HELP TABS
 */


/*
 *
 * ---> START SECTIONS
 *
 */

/*

    As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


 */

// -> START Header
Redux::setSection($opt_name, array(
	'title' => __('+ Header', 'bcn'),
	'id' => 'header',
	'desc' => __('Header options', 'bcn'),
	'icon' => 'el el-adjust-alt'
));

Redux::setSection($opt_name, array(
	'title' => __('Header and main menu', 'bcn'),
	'id' => 'header-style',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'header-layout',
			'type' => 'image_select',
			'title' => __('Header style', 'bcn'),
//            TODO: paste icons
			'subtitle' => __('Select the layout in which the header elements will be arranged', 'bcn'),
			'options' => array(
				'1' => array(
					'alt' => '1 Column',
					'img' => ReduxFramework::$_url . 'assets/img/1col.png'
				),
				'2' => array(
					'alt' => '2 Column Left',
					'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
				),
			),
			'default' => '1'
		),
		array(
			'id' => 'header-bg-title',
			'type' => 'section',
			'title' => __('Header background', 'bcn'),
			'subtitle' => __('You can overwrite the template on each block and widget.', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
			'output' => 'header',
		),
		array(
			'id' => 'header-bg',
			'type' => 'background',
			'output' => array('header.page-header'),
			'title' => __('Header background', 'bcn'),
			'background-color' => 'false',

		),
//        array(
//            'id' => 'header-bg-opacity',
//            'type' => 'text',
//            'title' => __('Background opacity', 'bcn'),
//            'subtitle' => __('Set the background image transparency (Example: 0.5)', 'bcn'),
////            'default' => __('0.5', 'bcn'),
//// TODO: for newest version
//        ),
		array(
			'id' => 'main-menu-title',
			'type' => 'section',
			'title' => __('Main menu', 'bcn'),
			'subtitle' => __('You can overwrite the template on each block and widget.', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'main-menu-select',
			'type' => 'select',
			'data' => 'menus',
			'title' => __('Header menu (main)', 'bcn'),
			'subtitle' => __('Select a menu for the main header section', 'bcn'),
		),
		array(
			'id' => 'main-menu-sticky',
			'type' => 'switch',
			'title' => __('Sticky menu', 'bcn'),
			'subtitle' => __('How to display the header menu on scroll', 'bcn'),
			'default' => 'false',
		),
//        array(
//            'id' => 'main-menu-sticky-logo',
//            'type' => 'select',
//            'title' => __('- Logo on sticky menu', 'bcn'),
//            'subtitle' => __('Show / Hide the Logo on sticky menu'),
//            'description' => __('Notice: If you choose Mobile logo, upload a logo in <b>Logo for Mobile</b> section'),
//            'options' => array(
////                'false' => 'Disabled',
//                'header' => 'Header logo',
//                'mobile' => 'Mobile logo',
//            ),
//            'default' => 'header',
//            // TODO: for newest version
//        ),

		array(
			'id' => 'main-menu-date',
			'type' => 'switch',
			'title' => __('Show date', 'bcn'),
			'subtitle' => __('Hide or show the date in the top menu', 'bcn'),
			'default' => 1,
			'on' => 'Enabled',
			'off' => 'Disabled',
		),
		array(
			'id' => 'main-menu-weather',
			'type' => 'switch',
			'title' => __('Show weather', 'bcn'),
			'subtitle' => __('Hide or show the weather info in the top menu', 'bcn'),
			'default' => 1,
			'on' => 'Enabled',
			'off' => 'Disabled',
		),
		array(
			'id' => 'main-menu-search',
			'type' => 'switch',
			'title' => __('Show search icon', 'bcn'),
			'subtitle' => __('Show or hide search icon', 'bcn'),
			'description' => __('Hide or show the search dialog info in the top menu.', 'bcn'),
			'default' => 1,
			'on' => 'Enabled',
			'off' => 'Disabled',
		),
		array(
			'id' => 'main-menu-flip',
			'type' => 'switch',
			'title' => __('Show flip panel', 'bcn'),
			'subtitle' => __('Show or hide the flip', 'bcn'),
			'description' => __('The flip panel uses sidebar to show information. To add content to the flip panel go to the widgets section and drag widget to the Flip Panel sidebar.', 'bcn'),
			'default' => 1,
			'on' => 'Enabled',
			'off' => 'Disabled',
		),
	)
));

//Redux::setSection($opt_name, array(
//    'title' => __('Search position', 'bcn'),
//    'id' => 'search-position',
//    'subsection' => true,
//    'desc' => __('For full documentation on this field, visit: ', 'bcn') . '<a href="//docs.reduxframework.com/core/fields/radio/" target="_blank">docs.reduxframework.com/core/fields/radio/</a>',
//    'fields' => array()
//    // TODO: for newest version
//));

//Redux::setSection($opt_name, array(
//    'title' => __('Top bar', 'bcn'),
//    'id' => 'top-bar',
//    'subsection' => true,
//    'desc' => __('For full documentation on this field, visit: ', 'bcn') . '<a href="//docs.reduxframework.com/core/fields/sortable/" target="_blank">docs.reduxframework.com/core/fields/sortable/</a>',
//    'fields' => array()
//    // TODO: for newest version
//));


Redux::setSection($opt_name, array(
	'title' => __('Logo & favicon ', 'bcn'),
	'id' => 'logo-favicon',
	'subsection' => true,
	'fields' => array(

		array(
			'id' => 'favicon-title',
			'type' => 'section',
			'title' => __('Favicon', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'favicon',
			'type' => 'media',
			'url' => true,
			'title' => __('Site favicon', 'bcn'),
			'compiler' => 'true',
			'subtitle' => __('Optional - upload a favicon image .png', 'bcn'),
		),
		array(
			'id' => 'logo-type-title',
			'type' => 'section',
			'title' => __('Text or img logo', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'logo-type',
			'type' => 'switch',
			'title' => __('Show the image for logos or text', 'bcn'),
			'subtitle' => __('Text or img logo', 'bcn'),
			'default' => 1,
			'on' => 'Image',
			'off' => 'Text',
		),
		array(
			'required' => array('logo-type', '=', '1'),
			'id' => 'logo-desktop-title',
			'type' => 'section',
			'title' => __('Logo for desktop', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'logo',
			'type' => 'media',
			'url' => true,
			'title' => __('Logo upload', 'bcn'),
			'compiler' => 'true',
			'subtitle' => __('Upload your logo .png or .jpg', 'bcn'),
		),
		array(
			'id' => 'logo-retina',
			'type' => 'media',
			'url' => true,
			'title' => __('Retina logo upload', 'bcn'),
			'compiler' => 'true',
			'subtitle' => __('Upload your retina logo .png or .jpg.<ul><li>If you do not set any retina logo, the site will load the normal logo on retina displays</li><li>The retina logo has to have the same file format with the normal logo</li></ul>', 'bcn'),
		),
		array(
			'id' => 'logo-alt',
			'type' => 'text',
			'title' => __('Logo alt attribute', 'bcn'),
			'subtitle' => __('Alt attribute for the logo.', 'bcn'),
			'description' => __('This is the alternative text if the logo cannot be displayed. It\'s useful for SEO and generally is the name of the site.', 'bcn'),
		),
		array(
			'id' => 'logo-title',
			'type' => 'text',
			'title' => __('Logo title attribute', 'bcn'),
			'subtitle' => __('Title attribute for the logo.', 'bcn'),
		),
		array(
			'required' => array('logo-type', '=', '1'),
			'id' => 'logo-mobile-title',
			'type' => 'section',
			'title' => __('Logo for mobile', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'logo-mobile',
			'type' => 'media',
			'url' => true,
			'title' => __('Logo mobile', 'bcn'),
			'compiler' => 'true',
			'subtitle' => __('Upload your logo', 'bcn'),
		),
		array(
			'id' => 'logo-mobile-retina',
			'type' => 'media',
			'url' => true,
			'title' => __('Retina logo mobile', 'bcn'),
			'compiler' => 'true',
			'subtitle' => __('Upload your retina logo (double size)', 'bcn'),
		),
		array(
			'required' => array('logo-type', '=', '0'),
			'id' => 'logo-txt-title',
			'type' => 'section',
			'title' => __('Plain text logo', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'logo-txt',
			'type' => 'text',
			'title' => __('Text logo', 'bcn'),
			'subtitle' => __('Write a text logo', 'bcn'),
		),
//        array(
//            'id' => 'logo-title',
//            'type' => 'text',
//            'title' => __('Text logo tagline', 'bcn'),
//            'subtitle' => __('Write a tagline for the text logo.', 'bcn'),
//            'description' => __('This attribute specifies extra information about the logo. Most browsers will show a tooltip with this text on logo hover.', 'bcn'),
//        ),
//// TODO: for newest version

	)
));

Redux::setSection($opt_name, array(
	'title' => __('Ios bookmarklet', 'bcn'),
	'id' => 'ios-bookmarklet',
	'desc' => __('The bookmarklets work on iOS and Android. When a user adds your site to the home screen, the phone will download one of the icons from here (based on the screen size and device type) and your site will appear with that icon on the homes creen', 'bcn'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'bookmarklet-76',
			'type' => 'media',
			'url' => true,
			'title' => __('Image 76 x 76', 'bcn'),
			'compiler' => 'true',
			//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'subtitle' => __('Upload your icon (76 x 76px).png', 'bcn'),
		),
		array(
			'id' => 'bookmarklet-114',
			'type' => 'media',
			'url' => true,
			'title' => __('Image 114 x 114', 'bcn'),
			'compiler' => 'true',
			//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'subtitle' => __('Upload your icon (114 x 114px).png', 'bcn'),
		),
		array(
			'id' => 'bookmarklet-120',
			'type' => 'media',
			'url' => true,
			'title' => __('Image 120 x 120', 'bcn'),
			'compiler' => 'true',
			//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'subtitle' => __('Upload your icon (120 x 120px).png', 'bcn'),
		),
		array(
			'id' => 'bookmarklet-144',
			'type' => 'media',
			'url' => true,
			'title' => __('Image 144 x 144', 'bcn'),
			'compiler' => 'true',
			//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'subtitle' => __('Upload your icon (144 x 144px).png', 'bcn'),
		),
		array(
			'id' => 'bookmarklet-152',
			'type' => 'media',
			'url' => true,
			'title' => __('Image 152 x 152', 'bcn'),
			'compiler' => 'true',
			//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'subtitle' => __('Upload your icon (152 x 152px).png', 'bcn'),
		),
	)
));

// -> START Footer
Redux::setSection($opt_name, array(
	'title' => __('+ Footer', 'bcn'),
	'id' => 'footer',
	'icon' => 'el el-edit',
));

Redux::setSection($opt_name, array(
	'title' => __('Footer settings', 'bcn'),
	'id' => 'footer-settings',
	//'icon'  => 'el el-home'
	'desc' => __('The footer uses sidebars to show information. Here you can customize the number of sidebars and the layout. To add content to the footer head go to the widgets section and drag widget to the Footer 1, Footer 2 and Footer 3 sidebars.', 'bcn'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'footer-on',
			'type' => 'switch',
			'title' => __('Show footer', 'bcn'),
			'subtitle' => __('Show or hide the footer', 'bcn'),
			'default' => 0,
			'on' => 'Enabled',
			'off' => 'Disabled',
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-layout',
			'type' => 'image_select',
			'title' => __('Footer templates', 'bcn'),
			'subtitle' => __('Set the footer template', 'bcn'),
//            'desc' => __('This uses some of the built in images, you can use them for layout options.', 'bcn'),
			//Must provide key => value(array:title|img) pairs for radio options
			'options' => array(
//                TODO: set the footer templates
				'1' => array(
					'alt' => 'First',
					'img' => get_template_directory_uri() . '/images/admin/preview-01.jpg'
				),
				'2' => array(
					'alt' => 'Second',
					'img' => get_template_directory_uri() . '/images/admin/preview-02.jpg'
				),
				'3' => array(
					'alt' => 'Third',
					'img' => get_template_directory_uri() . '/images/admin/preview-03.jpg'
				),
			),
			'default' => '1',
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-bg-title',
			'type' => 'section',
			'title' => __('Footer background', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
			'output' => 'footer::after',
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-bg',
			'type' => 'background',
			'output' => array('footer'),
			'title' => __('Footer background', 'bcn'),
			'background-color' => 'false',
		),
//    array(
//      'required' => array('footer-on', '=', '1'),
//      'id' => 'footer-bg-opacity',
//      'type' => 'text',
//      'title' => __('Background opacity', 'bcn'),
//      'subtitle' => __('Set the background image transparency (Example: 0.5)', 'bcn'),
//      'default' => __('0.5', 'bcn'),
//    ),
//    // TODO: for newest version
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-content-title',
			'type' => 'section',
			'title' => __('Footer content', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-logo',
			'type' => 'media',
			'url' => true,
			'title' => __('Footer logo', 'bcn'),
			'desc' => __('Upload your logo.', 'bcn'),
			'subtitle' => __('Different one from the header logo. If footer logo is not specified, the site will load the default normal logo.', 'bcn'),
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-logo-retina',
			'type' => 'media',
			'url' => true,
			'title' => __('Footer retina logo', 'bcn'),
			'desc' => __('Upload your retina logo (double size)', 'bcn'),
			'subtitle' => __('Different one from the header logo. If footer logo is not specified, the site will load the default retina logo.', 'bcn'),
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-logo-alt',
			'type' => 'text',
			'title' => __('Logo alt attribute', 'bcn'),
			'subtitle' => __('Alt attribute for the logo.', 'bcn'),
			'description' => __('This is the alternative text if the logo cannot be displayed. It\'s useful for SEO and generally is the name of the site.', 'bcn'),
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-logo-title',
			'type' => 'text',
			'title' => __('Logo title attribute', 'bcn'),
			'subtitle' => __('Title attribute for the logo.', 'bcn'),
			'description' => __('This attribute specifies extra information about the logo. Most browsers will show a tooltip with this text on logo hover.', 'bcn'),
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-text',
			'type' => 'textarea',
			'title' => __('Footer text', 'bcn'),
			'subtitle' => __('Write here your footer text', 'bcn'),
			'description' => __('Usually it\'s a text about your sites topic', 'bcn'),
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-email',
			'type' => 'text',
			'title' => __('Your email address', 'bcn'),
			'subtitle' => __('Your email address', 'bcn'),
			'description' => __('Your contact email address', 'bcn'),
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-social',
			'type' => 'switch',
			'title' => __('Show social icons', 'bcn'),
			'subtitle' => __('Show or hide the social icons, to setup the Social icons go to Miscellaneous > Social Networks', 'bcn'),
			//'options' => array('on', 'off'),
			'default' => false,
		),
	),
));

Redux::setSection($opt_name, array(
	'title' => __('Instagram section', 'bcn'),
	'id' => 'instagram',
	'subsection' => true,
	'desc' => __('From this section you can set and configure the Footer Instagram Section - this area appears above the footer section on all pages', 'bcn'),
	'fields' => array(
		array(
			'id' => 'instagram-on',
			'type' => 'switch',
			'title' => __('Show the footer instagram section', 'bcn'),
			'subtitle' => __('Show or hide the instagram section', 'bcn'),
			'default' => 0,
			'on' => 'Enabled',
			'off' => 'Disabled',
		),
		array(
			'required' => array('instagram-on', '=', '1'),
			'id' => 'instagram-id',
			'type' => 'text',
			'title' => __('Instagram id', 'bcn'),
			'subtitle' => __('Enter the ID as it appears after the instagram url ( ex. instagram.com/myID )', 'bcn'),
		),
		array(
			'required' => array('instagram-on', '=', '1'),
			'id' => 'instagram-images',
			'type' => 'select',
			'title' => __('Number of images', 'bcn'),
			'subtitle' => __('Set the number of images displayed from instagram.', 'bcn'),
			//Must provide key => value pairs for select options
			'options' => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
				'7' => '7',
				'8' => '8',
				'9' => '9',
			),
			'default' => '3'
		),
		array(
			'required' => array('instagram-on', '=', '1'),
			'id' => 'instagram-columns',
			'type' => 'select',
			'title' => __('Number of columns', 'bcn'),
			'subtitle' => __('The number of columns in your feed. 1 - 10.', 'bcn'),
			//Must provide key => value pairs for select options
			'options' => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
				'7' => '7',
				'8' => '8',
				'9' => '9',
			),
			'default' => '1'
		),
		array(
			'required' => array('instagram-on', '=', '1'),
			'id' => 'instagram-gap',
			'type' => 'select',
			'title' => __('Image gap', 'bcn'),
			'subtitle' => __('Set a gap between images (default: No gap)', 'bcn'),
			//Must provide key => value pairs for select options
			'options' => array(
				'0' => 'No gap',
				'2' => '2 px',
				'5' => '5 px',
			),
			'default' => '0'
		),
	)
));

Redux::setSection($opt_name, array(
	'title' => __('Sub footer settings', 'bcn'),
	'id' => 'sub-footer-settings',
	'subsection' => true,
	'desc' => __('The sub footer section is the content under the main footer. It usually includes a copyright text and a menu spot on the right', 'bcn'),
	'fields' => array(
		array(
			'id' => 'subfooter-on',
			'type' => 'switch',
			'title' => __('Show sub-footer', 'bcn'),
			'subtitle' => __('Show or hide the sub-footer', 'bcn'),
			'default' => 0,
			'on' => 'Enabled',
			'off' => 'Disabled',
		),
//        array(
//            'required' => array('subfooter-on', '=', '1'),
//            'id' => 'subfooter-layout',
//            'type' => 'image_select',
//            'title' => __('Sub footer templates', 'bcn'),
//            'subtitle' => __('Set the sub footer template', 'bcn'),
////            'desc' => __('This uses some of the built in images, you can use them for layout options.', 'bcn'),
//            //Must provide key => value(array:title|img) pairs for radio options
//            'options' => array(
////                TODO: set the sub footer templates
//                '1' => array(
//                    'alt' => '1 Column',
//                    'img' => get_template_directory_uri() . '/images/admin/preview-01.jpg'
//                ),
//                '2' => array(
//                    'alt' => '2 Column Left',
//                    'img' => get_template_directory_uri() . '/images/admin/preview-02.jpg'
//                ),
//                '3' => array(
//                    'alt' => '2 Column Right',
//                    'img' => get_template_directory_uri() . '/images/admin/preview-03.jpg'
//                ),
//                '4' => array(
//                    'alt' => '3 Column Middle',
//                    'img' => get_template_directory_uri() . '/images/admin/preview-04.jpg'
//                ),
//                '5' => array(
//                    'alt' => '3 Column Left',
//                    'img' => get_template_directory_uri() . '/images/admin/preview-05.jpg'
//                ),
//                '6' => array(
//                    'alt' => '3 Column Right',
//                    'img' => get_template_directory_uri() . '/images/admin/preview-06.jpg'
//                ),
//                '7' => array(
//                    'alt' => '3 Column Right',
//                    'img' => get_template_directory_uri() . '/images/admin/preview-07.jpg'
//                ),
//                '8' => array(
//                    'alt' => '3 Column Right',
//                    'img' => get_template_directory_uri() . '/images/admin/preview-09.jpg'
//                ),
//                '9' => array(
//                    'alt' => '3 Column Right',
//                    'img' => get_template_directory_uri() . '/images/admin/preview-11.jpg'
//                ),
//            ),
//            'default' => '2',
//        ),
		array(
			'required' => array('subfooter-on', '=', '1'),
			'id' => 'subfooter-text',
			'type' => 'textarea',
			'title' => __('Sub footer copyright text', 'bcn'),
			'subtitle' => __('Set sub footer copyright text', 'bcn'),
		),
		array(
			'required' => array('subfooter-on', '=', '1'),
			'id' => 'subfooter-copy',
			'type' => 'switch',
			'title' => __('Copyright symbol', 'bcn'),
			'subtitle' => __('Show or hide the footer copyright symbol', 'bcn'),
			'default' => 0,
			'on' => 'Enabled',
			'off' => 'Disabled',
		),
		array(
			'required' => array('subfooter-on', '=', '1'),
			'id' => 'subfooter-menu',
			'type' => 'select',
			'data' => 'menus',
			'title' => __('Footer menu', 'bcn'),
			'subtitle' => __('Select a menu for the sub footer', 'bcn'),
		),
	),
));

//// -> START Portfolio settings
//Redux::setSection($opt_name, array(
//    'title' => __('Portfolio', 'bcn'),
//    'id' => 'Portfolio',
//    'desc' => __('', 'bcn'),
//    'icon' => 'el el-photo'
//    // TODO: for newest version
//));

// -> START Advertisement
Redux::setSection($opt_name, array(
	'title' => __('-- Advertisement', 'bcn'),
	'id' => 'ads',
	'desc' => __('', 'bcn'),
	'icon' => 'el el-usd'
));

Redux::setSection($opt_name, array(
	'title' => __('Background click ad', 'bcn'),
	'id' => 'bg-click-ad',
	'desc' => __('NOTICE: Please go to BACKGROUND tab if you also need a background image', 'bcn'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'bg-click-url',
			'type' => 'text',
			'title' => __('Url', 'bcn'),
			'subtitle' => __('Paste your link here like: http://www.domain.com', 'bcn'),
		),
		array(
			'id' => 'bg-click-window',
			'type' => 'switch',
			'title' => __('Open in new window', 'bcn'),
			'subtitle' => __('If enabled, this option will open the URL in a new window. Leave disabled for the URL to be loaded in current page', 'bcn'),
			//'options' => array('on', 'off'),
			'default' => false,
		),
	),

));

Redux::setSection($opt_name, array(
	'title' => __('block 1', 'bcn'),
	'id' => 'block1',
	'desc' => __('Custom advertise block 1', 'bcn'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'ads-block1',
			'type' => 'ace_editor',
			'full_width' => true,
			'title' => __('Your ad code', 'bcn'),
			'subtitle' => __('Paste your ad code here.', 'bcn'),
			'mode' => 'plain_text',
			'theme' => 'chrome',
			'desc' => '',
			'default' => ""
		),
	)
));

Redux::setSection($opt_name, array(
	'title' => __('block 2', 'bcn'),
	'id' => 'block2',
	'desc' => __('Custom advertise block 2', 'bcn'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'ads-block2',
			'type' => 'ace_editor',
			'full_width' => true,
			'title' => __('Your ad code', 'bcn'),
			'subtitle' => __('Paste your ad code here.', 'bcn'),
			'mode' => 'plain_text',
			'theme' => 'chrome',
			'desc' => '',
			'default' => ""
		),
	)
));

Redux::setSection($opt_name, array(
	'title' => __('block 3', 'bcn'),
	'id' => 'block3',
	'desc' => __('Custom advertise block 3', 'bcn'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'ads-block3',
			'type' => 'ace_editor',
			'full_width' => true,
			'title' => __('Your ad code', 'bcn'),
			'subtitle' => __('Paste your ad code here.', 'bcn'),
			'mode' => 'plain_text',
			'theme' => 'chrome',
			'desc' => '',
			'default' => ""
		),
	)
));

Redux::setSection($opt_name, array(
	'title' => __('block 4', 'bcn'),
	'id' => 'block4',
	'desc' => __('Custom advertise block 4', 'bcn'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'ads-block4',
			'type' => 'ace_editor',
			'full_width' => true,
			'title' => __('Your ad code', 'bcn'),
			'subtitle' => __('Paste your ad code here.', 'bcn'),
			'mode' => 'plain_text',
			'theme' => 'chrome',
			'desc' => '',
			'default' => ""
		),
	)
));


// -> START Layouts settings
Redux::setSection($opt_name, array(
	'title' => __('Layouts settings', 'bcn'),
	'id' => 'layouts-settings',
	'desc' => __('', 'bcn'),
	'icon' => 'el el-align-justify'
));

Redux::setSection($opt_name, array(
	'title' => __('Template settings', 'bcn'),
	'id' => 'template-settings',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'template-settings-preloader',
			'type' => 'section',
			'title' => __(' + Preloader', 'bcn'),
			'subtitle' => __('From here you can configure show or hide preloader. For color customization go to Miscellaneous > Theme colors > Preloader', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'template-settings-preloader-show',
			'type' => 'switch',
			'title' => __('Show preloader', 'bcn'),
			'subtitle' => __('Show or hide the preloader.', 'bcn'),
			'default' => true,
		),
		array(
			'id' => 'template-settings-breadcrumbs',
			'type' => 'section',
			'title' => __('Breadcrumbs', 'bcn'),
			'subtitle' => __('From here you can customize the breadcrumbs that appear on your site. The breadcrumbs are a very useful navigation element that looks like this \'Home > My category > My article title\'. Since the breadcrumbs are so important for humans and search engines crawlers, Newspaper comes with extensive configuration options for them.', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'template-settings-breadcrumbs-show',
			'type' => 'switch',
			'title' => __('Show breadcrumbs', 'bcn'),
			'subtitle' => __('Enable or disable the breadcrumbs.', 'bcn'),
			'default' => true,
		),
		array(
			'id' => 'template-settings-breadcrumbs-home',
			'type' => 'switch',
			'title' => __('Show breadcrumbs home link', 'bcn'),
			'subtitle' => __('Show or hide the home link in breadcrumbs.', 'bcn'),
			'default' => true,
		),
		array(
			'id' => 'template-settings-breadcrumbs-parent',
			'type' => 'switch',
			'title' => __('Show parent category', 'bcn'),
			'subtitle' => __('Show or hide the parent category link ex: Home > parent category > category.', 'bcn'),
			'default' => true,
		),
		array(
			'id' => 'template-settings-breadcrumbs-title',
			'type' => 'switch',
			'title' => __('Show article title', 'bcn'),
			'subtitle' => __('Show or hide the article title on post pages.', 'bcn'),
			'default' => true,
		),
		array(
			'id' => 'page-template',
			'type' => 'section',
			'title' => __('Page template', 'bcn'),
			'subtitle' => __('Select the page sidebar position and sidebar from here. The two settings are changeable on a per page basis.', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'page-template-sidebar',
			'type' => 'image_select',
			'title' => __('Sidebar position', 'bcn'),
			'subtitle' => __('Sidebar position and custom sidebars.', 'bcn'),
			'options' => array(
				'1' => array(
					'alt' => '1 Column',
					'img' => ReduxFramework::$_url . 'assets/img/1col.png'
				),
				'2' => array(
					'alt' => '2 Column Left',
					'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
				),
				'3' => array(
					'alt' => '2 Column Right',
					'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
				),
			),
			'default' => '2'
		),
		array(
			'id' => 'page-template-comments',
			'type' => 'switch',
			'title' => __('Disable comments on pages', 'bcn'),
			'subtitle' => __('Enable or disable the comments on pages, on the entire site. This option is disabled by default', 'bcn'),
			'default' => false,
		),
		array(
			'id' => 'woocommerce-template',
			'type' => 'section',
			'title' => __('WooCommerce template', 'bcn'),
			'subtitle' => __('Set the sidebar and position for the WooCommerce pages.', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'woocommerce-template-sidebar',
			'type' => 'image_select',
			'title' => __('Shop homepage + archives', 'bcn'),
			'subtitle' => __('Sidebar position and custom sidebar.', 'bcn'),
			'options' => array(
				'1' => array(
					'alt' => '1 Column',
					'img' => ReduxFramework::$_url . 'assets/img/1col.png'
				),
				'2' => array(
					'alt' => '2 Column Left',
					'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
				),
				'3' => array(
					'alt' => '2 Column Right',
					'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
				),
			),
			'default' => '2'
		),
		array(
			'id' => 'woocommerce-product-sidebar',
			'type' => 'image_select',
			'title' => __('Shop single product page', 'bcn'),
			'subtitle' => __('Sidebar position and custom sidebar.', 'bcn'),
			'options' => array(
				'1' => array(
					'alt' => '1 Column',
					'img' => ReduxFramework::$_url . 'assets/img/1col.png'
				),
				'2' => array(
					'alt' => '2 Column Left',
					'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
				),
				'3' => array(
					'alt' => '2 Column Right',
					'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
				),
			),
			'default' => '2'
		),
	),
));

Redux::setSection($opt_name, array(
	'title' => __('++ Categories template', 'bcn'),
	'id' => 'categories-template',
	'desc' => __('Set the default layout for all the categories.', 'bcn'),
	'subsection' => true,
	'fields' => array(
//        array(
//            'id' => 'category-template',
//            'type' => 'switch',
//            'title' => __('Category template', 'bcn'),
//            'subtitle' => __('This is the header of the category'),
//            'default' => true,
//            // TODO: for newest version
//        ),
//        array(
//            'id' => 'category-template-filter',
//            'type' => 'switch',
//            'title' => __('Category pull-down filter', 'bcn'),
//            'subtitle' => __('This setting controls the display of the category pull-down filter.'),
//            'default' => true,
//            // TODO: for newest version
//        ),
//        array(
//            'id' => 'category-template-top-style',
//            'type' => 'switch',
//            'title' => __('Category top posts style', 'bcn'),
//            'subtitle' => __('Set top post style.'),
//            'default' => true,
//            // TODO: for newest version
//        ),
//        array(
//            'id' => 'category-template-top-grid-style',
//            'type' => 'switch',
//            'title' => __('Category top posts grid style', 'bcn'),
//            'subtitle' => __('Each category grid supports multiple styles.'),
//            'default' => true,
//            // TODO: for newest version
//        ),
//		array(
//			'id' => 'category-template-author',
//			'type' => 'switch',
//			'title' => __('Show or hide author name and link.', 'bcn'),
//			'subtitle' => __('Show or hide author on post listings.', 'bcn'),
//			'default' => true,
//			'on' => 'Show',
//			'off' => 'Hide',
//		),
//		array(
//			'id' => 'category-template-date',
//			'type' => 'switch',
//			'title' => __('Show or hide date.', 'bcn'),
//			'subtitle' => __('Show or hide date on post listings.', 'bcn'),
//			'default' => true,
//			'on' => 'Show',
//			'off' => 'Hide',
//		),
		array(
			'id' => 'category-article-display',
			'type' => 'image_select',
			'title' => __('Article display view', 'bcn'),
			'subtitle' => __('Select a module type, this is how your article list will be displayed.', 'bcn'),
			'options' => array(
				'2' => array(
					'alt' => '2',
					'img' => get_template_directory_uri() . '/images/admin/preview-02.jpg'
				),
				'3' => array(
					'alt' => '3',
					'img' => get_template_directory_uri() . '/images/admin/preview-03.jpg'
				),
				'4' => array(
					'alt' => '4',
					'img' => get_template_directory_uri() . '/images/admin/preview-04.jpg'
				),
				'5' => array(
					'alt' => '5',
					'img' => get_template_directory_uri() . '/images/admin/preview-05.jpg'
				),
//				'6' => array(
//					'alt' => '6',
//					'img' => get_template_directory_uri() . '/images/admin/preview-06.jpg'
//				),
				'7' => array(
					'alt' => '7',
					'img' => get_template_directory_uri() . '/images/admin/preview-07.jpg'
				),
//				'8' => array(
//					'alt' => '8',
//					'img' => get_template_directory_uri() . '/images/admin/preview-08.jpg'
//				),
				'9' => array(
					'alt' => '9',
					'img' => get_template_directory_uri() . '/images/admin/preview-09.jpg'
				),
//				'10' => array(
//					'alt' => '9',
//					'img' => get_template_directory_uri() . '/images/admin/preview-10.jpg'
//				),
				'11' => array(
					'alt' => '9',
					'img' => get_template_directory_uri() . '/images/admin/preview-11.jpg'
				),
//				'12' => array(
//					'alt' => '9',
//					'img' => get_template_directory_uri() . '/images/admin/preview-12.jpg'
//				),
				'14' => array(
					'alt' => '9',
					'img' => get_template_directory_uri() . '/images/admin/preview-14.jpg'
				),
//				'15' => array(
//					'alt' => '9',
//					'img' => get_template_directory_uri() . '/images/admin/preview-15.jpg'
//				),
//				'16' => array(
//					'alt' => '9',
//					'img' => get_template_directory_uri() . '/images/admin/preview-16.jpg'
//				),
//			TODO: miss the file?
//				'17' => array(
//					'alt' => '9',
//					'img' => get_template_directory_uri() . '/images/admin/preview-17.jpg'
//				),
				'18' => array(
					'alt' => '9',
					'img' => get_template_directory_uri() . '/images/admin/preview-18.jpg'
				),
				'19' => array(
					'alt' => '9',
					'img' => get_template_directory_uri() . '/images/admin/preview-19.jpg'
				),
//				'20' => array(
//					'alt' => '9',
//					'img' => get_template_directory_uri() . '/images/admin/preview-20.jpg'
//				),
				'21' => array(
					'alt' => '9',
					'img' => get_template_directory_uri() . '/images/admin/preview-21.jpg'
				),
			),
			'default' => '2',
		),
		array(
			'id' => 'category-pagination',
			'type' => 'select',
			'title' => __('Pagination style', 'bcn'),
			'subtitle' => __('Set a pagination style for all categories.', 'bcn'),
			'options' => array(
				'1' => 'Normal pagination',
				'2' => 'Infinite loading',
//				'3' => 'Infinite loading + Load more',
//			TODO for newest options
			),
			'default' => '1',
		),
		array(
			'id' => 'category-sidebar',
			'type' => 'image_select',
			'title' => __('Sidebar position', 'bcn'),
			'subtitle' => __('Sidebar position and custom sidebars.', 'bcn'),
			'options' => array(
				'1' => array(
					'alt' => 'No sidebar',
					'img' => ReduxFramework::$_url . 'assets/img/1col.png'
				),
				'2' => array(
					'alt' => '2 Column Left',
					'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
				),
				'3' => array(
					'alt' => '2 Column Right',
					'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
				),
			),
			'default' => '2'
		),
	)
));

Redux::setSection($opt_name, array(
	'title' => __('++ Post settings', 'bcn'),
	'id' => 'post-settings',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'post-and-custom-post',
			'type' => 'section',
			'title' => __('Post and Custom Post Types', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'post-show-categories',
			'type' => 'switch',
			'title' => __('Show categories tags', 'bcn'),
			'subtitle' => __('Enable or disable the categories tags (on single posts and custom post types)', 'bcn'),
			'default' => true,
		),
//        array(
//            'id' => 'post-categories-tags-order',
//            'type' => 'switch',
//            'title' => __('Category tags display order', 'bcn'),
//            'subtitle' => __('Set the post category tags display order.'),
//            'default' => false,
//    // TODO: for newest version
//        ),
		array(
			'id' => 'post-show-author-name',
			'type' => 'switch',
			'title' => __('Show author name', 'bcn'),
			'subtitle' => __('Enable or disable the author name (on single post page)', 'bcn'),
			'default' => true,
		),
		array(
			'id' => 'post-show-date',
			'type' => 'switch',
			'title' => __('Show date', 'bcn'),
			'subtitle' => __('Enable or disable the post date (on single post page)', 'bcn'),
			'default' => true,
		),
//		array(
//			'id' => 'post-show-views',
//			'type' => 'switch',
//			'title' => __('Show post views', 'bcn'),
//			'subtitle' => __('Enable or disable the post views (on single post page)', 'bcn'),
//			'default' => false,
//		),
//		// TODO: for newest version
		array(
			'id' => 'post-show-comments-numbers',
			'type' => 'switch',
			'title' => __('Show comment count', 'bcn'),
			'subtitle' => __('Enable or disable comment number (on single post page)', 'bcn'),
			'default' => false,
		),
		array(
			'id' => 'block-show-tags',
			'type' => 'switch',
			'title' => __('Show tags', 'bcn'),
			'subtitle' => __('Enable or disable the post tags (bottom of single post pages and CPT)', 'bcn'),
			'default' => true,
		),
		array(
			'id' => 'block-show-next-previous',
			'type' => 'switch',
			'title' => __('Show next and previous posts', 'bcn'),
			'subtitle' => __('Show or hide `next` and `previous` posts (bottom of single post pages)', 'bcn'),
			'default' => true,
		),
		array(
			'id' => 'block-show-author-box',
			'type' => 'switch',
			'title' => __('Show author box', 'bcn'),
			'subtitle' => __('Enable or disable the author box (bottom of single post pages)', 'bcn'),
			'default' => true,
		),
		array(
			'id' => 'block-show-comments',
			'type' => 'switch',
			'title' => __('Enable comments on posts', 'bcn'),
			'subtitle' => __('Enable or disable the posts\' comments, for the entire site.', 'bcn'),
			'default' => true,
		),
//		array(
//			'id' => 'block-show-general-modal',
//			'type' => 'switch',
//			'title' => __('General modal image', 'bcn'),
//			'subtitle' => __('<p>Enable or disable general modal image viewer over all post images, so you won\'t have to go on each post to set them individually.</p><p>Consider that disabling this feature, the individual settings of an image post are applied.</p>', 'bcn'),
//			'default' => false,
//			// TODO: for newest version
//		),
		array(
			'id' => 'post-template-title',
			'type' => 'section',
			'title' => __('Default post template (site wide)', 'bcn'),
			'subtitle' => __('This template will be applied to the whole site. The theme will also try to adjust the default widgets to look in the same style with the block template selected here.', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'post-template-default',
			'type' => 'image_select',
			'title' => __('Default site post template', 'bcn'),
			'subtitle' => __('Setting this option will make all post pages, that don\'t have a post template set, to be displayed using this template. You can overwrite this setting on a per post basis.', 'bcn'),
//            'desc' => __('This uses some of the built in images, you can use them for layout options.', 'bcn'),
			//Must provide key => value(array:title|img) pairs for radio options
			'options' => array(
				'1' => array(
					'alt' => '1 Column',
					'img' => get_template_directory_uri() . '/images/admin/preview-01.jpg'
				),
				'2' => array(
					'alt' => '2 Column Left',
					'img' => get_template_directory_uri() . '/images/admin/preview-02.jpg'
				),
				'3' => array(
					'alt' => '2 Column Right',
					'img' => get_template_directory_uri() . '/images/admin/preview-03.jpg'
				),
// Todo: set the layouts for default site post template
			),
			'default' => '1',
		),
		array(
			'id' => 'post-featured-images-title',
			'type' => 'section',
			'title' => __('Featured images', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'post-featured-images-show',
			'type' => 'switch',
			'title' => __('Show featured image', 'bcn'),
			'subtitle' => __('Show or hide featured image. Also when a post doesn\'t have a featured image set, the theme will load a placeholder image.', 'bcn'),
			'default' => false,
		),
//		array(
//			'id' => 'post-featured-images-placeholder',
//			'type' => 'switch',
//			'title' => __('Featured image placeholder', 'bcn'),
//			'subtitle' => __('When a post doesn\'t have a featured image set, the theme will load a placeholder image.', 'bcn'),
//			'default' => false,
//			// TODO: for newest version
//		),
//		array(
//			'id' => 'post-featured-images-lightbox',
//			'type' => 'switch',
//			'title' => __('Featured image lightbox', 'bcn'),
//			'subtitle' => __('What to do when the featured image is clicked inside a post. (on single post page).', 'bcn'),
//			'default' => false,
//			// TODO: for newest version
//		),
		array(
			'id' => 'post-related-title',
			'type' => 'section',
			'title' => __('Related article', 'bcn'),
			'subtitle' => __('On each single post, the theme shows three or five similar posts in the related articles section.', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'post-related-show',
			'type' => 'switch',
			'title' => __('Show related article', 'bcn'),
			'subtitle' => __('Enable or disable the related article section.', 'bcn'),
			'default' => true,
		),
		array(
			'id' => 'post-sharing-title',
			'type' => 'section',
			'title' => __('Sharing', 'bcn'),
			'subtitle' => __('All the articles of BCN have sharing buttons at the start of the article (usually under the title) and at the end of the article (after tags). You can sort the social networks with drag and drop.', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'post-sharing-top',
			'type' => 'switch',
			'title' => __('Top article sharing', 'bcn'),
			'subtitle' => __('Show or hide the top article sharing on single post.', 'bcn'),
			'default' => true,
		),
//		array(
//			'id' => 'post-sharing-top-like',
//			'type' => 'switch',
//			'title' => __('Top article like', 'bcn'),
//			'subtitle' => __('Show or hide the top article like on single post.', 'bcn'),
//			'default' => true,
//			// TODO: for newest version
//		),
//		array(
//			'id' => 'post-sharing-top-text',
//			'type' => 'switch',
//			'title' => __('Top article share text', 'bcn'),
//			'subtitle' => __('Show or hide the top article share text on single post.', 'bcn'),
//			'default' => true,
//			// TODO: for newest version
//		),
//        array(
//            'id' => 'post-sharing-top-style',
//            'type' => 'switch',
//            'title' => __('Top share buttons style', 'bcn'),
//            'subtitle' => __('Change the appearance of the top sharing buttons.', 'bcn'),
//            'default' => false,
//            // TODO: for newest version
//        ),
		array(
			'id' => 'post-sharing-bottom',
			'type' => 'switch',
			'title' => __('Bottom article sharing', 'bcn'),
			'subtitle' => __('Show or hide the bottom article sharing on post.', 'bcn'),
			'default' => true,
		),
//		array(
//			'id' => 'post-sharing-bottom-like',
//			'type' => 'switch',
//			'title' => __('Bottom article like', 'bcn'),
//			'subtitle' => __('Show or hide the bottom article like on post.', 'bcn'),
//			'default' => true,
//			// TODO: for newest version
//		),
//		array(
//			'id' => 'post-sharing-bottom-text',
//			'type' => 'switch',
//			'title' => __('Bottom article share text', 'bcn'),
//			'subtitle' => __('Change the appearance of the bottom sharing buttons.', 'bcn'),
//			'default' => true,
//			// TODO: for newest version
//		),
//        array(
//            'id' => 'post-sharing-bottom-style',
//            'type' => 'switch',
//            'title' => __('Bottom share buttons style', 'bcn'),
//            'subtitle' => __('Change the appearance of the bottom sharing buttons.', 'bcn'),
//            'default' => false,
//            // TODO: for newest version
//        ),
//        array(
//            'id' => 'post-sharing-twitter-username',
//            'type' => 'switch',
//            'title' => __('Twitter username', 'bcn'),
//            'subtitle' => __('<p>This will be used in the tweet for the via parameter. The site name will be used if no twitter username is provided. </p><p>Do not include the @</p>', 'bcn'),
//            'default' => false,
//            // TODO: for newest version
//        ),
//        array(
//            'id' => 'post-sharing-socials',
//            'type' => 'switch',
//            'title' => __('Social networks', 'bcn'),
//            'subtitle' => __('Select active social share links and sort them with drag and drop:', 'bcn'),
//            'default' => false,
//            // TODO: for newest version
//        ),
	)
));

Redux::setSection($opt_name, array(
	'title' => __('Portfolio', 'bcn'),
	'id' => 'portfoilo',
//    'desc' => __('Default portfolio template ', 'bcn'),
	'subtitle' => __('.', 'bcn'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'portfolio-template-default',
			'type' => 'image_select',
			'title' => __('Default portfolio template', 'bcn'),
			'subtitle' => __('This template will be applied to the portfolio whole site.', 'bcn'),
			'options' => array(
				'1' => array(
					'alt' => '1 Column',
					'img' => get_template_directory_uri() . '/images/admin/preview-01.jpg'
				),
				'2' => array(
					'alt' => '2 Column Left',
					'img' => get_template_directory_uri() . '/images/admin/preview-02.jpg'
				),
				'3' => array(
					'alt' => '2 Column Right',
					'img' => get_template_directory_uri() . '/images/admin/preview-03.jpg'
				),
// Todo: set the layouts for default site post template
			),
			'default' => '1',
		),
		array(
			'id' => 'portfolio-show-filter',
			'type' => 'switch',
			'title' => __('Show filter', 'bcn'),
			'subtitle' => __('Change the appearance of the bottom sharing buttons.', 'bcn'),
			'default' => true,
		),
		array(
			'id' => 'portfolio-show-title',
			'type' => 'switch',
			'title' => __('Show item title', 'bcn'),
			'subtitle' => __('Change the appearance of the bottom sharing buttons.', 'bcn'),
			'default' => false,
		),
		array(
			'id' => 'portfolio-show-plus',
			'type' => 'switch',
			'title' => __('Show plus icon on hover', 'bcn'),
			'subtitle' => __('Change the appearance of the bottom sharing buttons.', 'bcn'),
			'default' => true,
		),
		array(
			'id' => 'portfolio-show-modal',
			'type' => 'switch',
			'title' => __('Enable modal image', 'bcn'),
			'subtitle' => __('Change the appearance of the bottom sharing buttons.', 'bcn'),
			'default' => true,
		),
	)
));

// -> START Miscellaneous
Redux::setSection($opt_name, array(
	'title' => __('+ Miscellaneous', 'bcn'),
	'id' => 'miscellaneous',
	'desc' => __('', 'bcn'),
	'icon' => 'el el-cog'
));


Redux::setSection($opt_name, array(
	'title' => __('Block settings', 'bcn'),
	'id' => 'block-settings',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'block-settings-title',
			'type' => 'section',
			'title' => __('Global Block Template', 'bcn'),
			'subtitle' => __('This template will be applied to the whole site. The theme will also try to adjust the default widgets to look in the same style with the block template selected here.', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'block-settings-display',
			'type' => 'image_select',
			'title' => __('Block template', 'bcn'),
			'subtitle' => __('You can overwrite the template on each block and widget.', 'bcn'),
			'options' => array(
				'2' => array(
					'alt' => '2',
					'img' => get_template_directory_uri() . '/images/admin/preview-02.jpg'
				),
				'3' => array(
					'alt' => '3',
					'img' => get_template_directory_uri() . '/images/admin/preview-03.jpg'
				),
				'4' => array(
					'alt' => '4',
					'img' => get_template_directory_uri() . '/images/admin/preview-04.jpg'
				),
				'5' => array(
					'alt' => '5',
					'img' => get_template_directory_uri() . '/images/admin/preview-05.jpg'
				),
//				'6' => array(
//					'alt' => '6',
//					'img' => get_template_directory_uri() . '/images/admin/preview-06.jpg'
//				),
				'7' => array(
					'alt' => '7',
					'img' => get_template_directory_uri() . '/images/admin/preview-07.jpg'
				),
//				'8' => array(
//					'alt' => '8',
//					'img' => get_template_directory_uri() . '/images/admin/preview-08.jpg'
//				),
				'9' => array(
					'alt' => '9',
					'img' => get_template_directory_uri() . '/images/admin/preview-09.jpg'
				),
//				'10' => array(
//					'alt' => '9',
//					'img' => get_template_directory_uri() . '/images/admin/preview-10.jpg'
//				),
				'11' => array(
					'alt' => '9',
					'img' => get_template_directory_uri() . '/images/admin/preview-11.jpg'
				),
//				'12' => array(
//					'alt' => '9',
//					'img' => get_template_directory_uri() . '/images/admin/preview-12.jpg'
//				),
				'14' => array(
					'alt' => '9',
					'img' => get_template_directory_uri() . '/images/admin/preview-14.jpg'
				),
//				'15' => array(
//					'alt' => '9',
//					'img' => get_template_directory_uri() . '/images/admin/preview-15.jpg'
//				),
//				'16' => array(
//					'alt' => '9',
//					'img' => get_template_directory_uri() . '/images/admin/preview-16.jpg'
//				),
//			TODO: miss the file?
//				'17' => array(
//					'alt' => '9',
//					'img' => get_template_directory_uri() . '/images/admin/preview-17.jpg'
//				),
				'18' => array(
					'alt' => '9',
					'img' => get_template_directory_uri() . '/images/admin/preview-18.jpg'
				),
				'19' => array(
					'alt' => '9',
					'img' => get_template_directory_uri() . '/images/admin/preview-19.jpg'
				),
//				'20' => array(
//					'alt' => '9',
//					'img' => get_template_directory_uri() . '/images/admin/preview-20.jpg'
//				),
				'21' => array(
					'alt' => '9',
					'img' => get_template_directory_uri() . '/images/admin/preview-21.jpg'
				),
			),
			'default' => '2',
		),
		array(
			'id' => 'block-settings-meta-title',
			'type' => 'section',
			'title' => __('Meta info on Modules/Blocks', 'bcn'),
			'subtitle' => __('You can overwrite the template on each block and widget.', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'block-settings-meta-author',
			'type' => 'switch',
			'title' => __('Show author name', 'bcn'),
			'subtitle' => __('Enable or disable the author name (on blocks and modules)', 'bcn'),
			'default' => false,
		),
		array(
			'id' => 'block-settings-meta-date',
			'type' => 'switch',
			'title' => __('Show date', 'bcn'),
			'subtitle' => __('Enable or disable the post date (on blocks and modules)', 'bcn'),
			'default' => false,
		),
		array(
			'id' => 'block-settings-meta-comments',
			'type' => 'switch',
			'title' => __('Show comment count', 'bcn'),
			'subtitle' => __('Enable or disable comment number (on blocks and modules)', 'bcn'),
			'default' => false,
		),
//		array(
//			'id' => 'block-settings-meta-reviews',
//			'type' => 'switch',
//			'title' => __('Show review', 'bcn'),
//			'subtitle' => __('Enable or disable reviews (on blocks and modules)', 'bcn'),
//			'default' => false,
//			// TODO: for newest version
//		),
	)
));

Redux::setSection($opt_name, array(
	'title' => __('Background', 'bcn'),
	'id' => 'background',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'background-theme',
			'type' => 'background',
//            'output' => array('body'),
			'title' => __('Theme background', 'bcn'),
			'background-color' => 'false',
			'output' => '.up-container',
		),
		array(
			'id' => 'background-search',
			'type' => 'background',
//            'output' => array('body'),
			'title' => __('Search panel background', 'bcn'),
			'background-color' => 'false',
			'output' => '.usernav__search-search--open',
		),
		array(
			'id' => 'background-flip',
			'type' => 'background',
//            'output' => array('body'),
			'title' => __('Flip panel background', 'bcn'),
			'background-color' => 'false',
			'output' => '.flip-block--open',
		),
//		array(
//			'id' => 'background-mobile-menu',
//			'type' => 'background',
////            'output' => array('body'),
//			'title' => __('? Mobile menu background', 'bcn'),
//			'background-color' => 'false',
//		),
//// TODO: for newest version

		array(
			'id' => 'background-portfolio',
			'type' => 'background',
//           'output' => array('body'),
			'title' => __('Portfolio background', 'bcn'),
			'background-color' => 'false',
			'output' => '.container--portfolio, .container--portfolio-03, .container--portfolio-02'
		),

//        array(
//            'id' => 'background-theme',
//            'type' => 'background',
////            'output' => array('body'),
//            'title' => __('Footer background', 'bcn'),
//            'background-color' => 'false',
//        ),
	),
));

//Redux::setSection($opt_name, array(
//	'title' => __('Excerpts', 'bcn'),
//	'id' => 'excerpts',
//	'desc' => __('Adding a text as excerpt on post edit page (Excerpt box), will overwrite the theme excerpts ', 'bcn'),
//	'subsection' => true,
//	'fields' => array(
//		array(
//			'id' => 'title-lenght',
//			'type' => 'text',
//			'title' => __('Title lenght', 'bcn'),
//			'subtitle' => __('In words', 'bcn'),
//			'desc' => __('Example: 12', 'bcn'),
//			'default' => '12',
//		),
//		array(
//			'id' => 'excerpts-lenght',
//			'type' => 'text',
//			'title' => __('Excerpts lenght', 'bcn'),
//			'subtitle' => __('In words', 'bcn'),
//			'desc' => __('Example: 256', 'bcn'),
//			'default' => '12',
//		),
//	)
//));

Redux::setSection($opt_name, array(
	'title' => __('Theme colors', 'bcn'),
	'id' => 'theme-color',
//    'desc' => __('For full documentation on this field, visit: ', 'bcn') . '<a href="//docs.reduxframework.com/core/fields/slides/" target="_blank">docs.reduxframework.com/core/fields/slides/</a>',
	'subsection' => true,
	'fields' => array(

//      General colors

		array(
			'id' => 'colors-general-title',
			'type' => 'section',
			'title' => __('General theme colors', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'colors-general-accent',
			'type' => 'color',
			'title' => __('Theme accent color', 'bcn'),
			'subtitle' => __('Select theme accent color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => 'body b,body strong, .content, .entry-content b, .entry-content strong, .entry-title span, .entry-title b, .entry-title strong',
				'--active-word' => ':root',
			),
//		TODO: think much more about it
		),


		array(
			'id' => 'colors-general-bg',
			'type' => 'color',
			'title' => __('Background color', 'bcn'),
			'subtitle' => __('Select theme background color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => 'body',
			),


		),
//		array(
//			'id' => 'colors-general-headers-bg',
//			'type' => 'color',
//			'title' => __('Headers background color', 'bcn'),
//			'subtitle' => __('Select a global header background color', 'bcn'),
//			'default' => false,
//			'validate' => 'color',
////			TODO: for newest version
//		),
		array(
			'id' => 'colors-general-headers',
			'type' => 'color',
			'title' => __('Headers text color', 'bcn'),
			'subtitle' => __('Select a global header text color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.post-block-02__header a:hover, .post-block-03__widget-title a:hover, .post-block-04__header a:hover, .post-block-05__header a:hover, .post-block-07__header a:hover, .post-block-09__header a:hover, .post-block-11__header a:hover, .post-block-14__header a:hover, .post-block-18__header a:hover, .post-block-19__widget-title a:hover, .post-block-21__header a:hover, .post-block-02__header a, .post-block-03__widget-title a, .post-block-04__header a, .post-block-05__header a, .post-block-07__header a, .post-block-09__header a, .post-block-11__header a, .post-block-14__header a, .post-block-18__header a, .post-block-19__widget-title a, .post-block-21__header a, .post-block-02__item:hover .post-block-02__header-link, .post-block-03__item:hover .post-block-03__header-link, .post-block-04__item:hover .post-block-04__header-link, .post-block-05__item:hover .post-block-05__header-link, .post-block-07__item:hover .post-block-07__header-link, .post-block-09__item:hover .post-block-09__header-link, .post-block-11__item:hover .post-block-11__header-link, .post-block-14__item:hover .post-block-14__header-link, .post-block-18__item:hover .post-block-18__header-link, .post-block-19__item:hover .post-block-19__header-link, .post-block-21__item:hover .post-block-21__header-link',
				'border-bottom-color' => '.post-block-02__item:hover .post-block-02__header-link, .post-block-03__item:hover .post-block-03__header-link, .post-block-04__item:hover .post-block-04__header-link, .post-block-05__item:hover .post-block-05__header-link, .post-block-07__item:hover .post-block-07__header-link, .post-block-09__item:hover .post-block-09__header-link, .post-block-11__item:hover .post-block-11__header-link, .post-block-14__item:hover .post-block-14__header-link, .post-block-18__item:hover .post-block-18__header-link, .post-block-19__item:hover .post-block-19__header-link, .post-block-21__item:hover .post-block-21__header-link'
			)
		),

//      Preloader

		array(
			'id' => 'colors-preloader-title',
			'type' => 'section',
			'title' => __('Preloader', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'colors-preloader-bg',
			'type' => 'color_rgba',
			'title' => __('Preloader background color', 'bcn'),
			'subtitle' => __('Select preloader background color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.loading-spinner'
			),
		),
		array(
			'id' => 'colors-preloader',
			'type' => 'color_rgba',
			'title' => __('Preloader color', 'bcn'),
			'subtitle' => __('Select preloader color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.loading-spinner__item .loading-spinner__item-cube:before'
			),
		),

//      Header

		array(
			'id' => 'colors-header-title',
			'type' => 'section',
			'title' => __('Header', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.

		),
		array(
			'id' => 'colors-header-bg',
			'type' => 'color',
			'title' => __('Header background color', 'bcn'),
			'subtitle' => __('Select header background color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.page-header'
			),
		),

		array(
			'id' => 'colors-header-text',
			'type' => 'color',
			'title' => __('Header text color', 'bcn'),
			'subtitle' => __('Select header text color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.page-header'
			),
		),
		array(
			'id' => 'colors-header-b',
			'type' => 'color',
			'title' => __('Header accent text color', 'bcn'),
			'subtitle' => __('Select header accent text color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.page-header b'
			),
		),
		array(
			'id' => 'colors-header-logo',
			'type' => 'color',
			'title' => __('Text logo color', 'bcn'),
			'subtitle' => __('Select text logo color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.main-nav__logo, .main-nav__logo:hover'
			),
		),
		array(
			'id' => 'colors-menu-bg',
			'type' => 'color',
			'title' => __('Menu background color', 'bcn'),
			'subtitle' => __('Select menu background color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.header-menu'
			),
		),
		array(
			'id' => 'colors-menu-hover',
			'type' => 'color',
			'title' => __('Menu active & hover color', 'bcn'),
			'subtitle' => __('Select the active and hover color for menu and submenu', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => '.header-menu .menu-item a:hover, .header-menu .menu-item a:focus, .header-menu .menu-item a:active',
		),
		array(
			'id' => 'colors-menu-txt',
			'type' => 'color',
			'title' => __('Menu text color', 'bcn'),
			'subtitle' => __('Select menu text color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.header-menu .menu-item a',
				'background-color' => '.header-menu .menu-item a::before',
			),
		),
		array(
			'id' => 'colors-menu-accent-txt',
			'type' => 'color',
			'title' => __('Menu accent text color', 'bcn'),
			'subtitle' => __('Select menu accent text color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => '.header-menu .menu-item > a >strong',
		),

//      Header -> Submenu

		array(
			'id' => 'colors-submenu-bg',
			'type' => 'color',
			'title' => __('Sub-menu background color', 'bcn'),
			'subtitle' => __('Select sub-menu background color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.header-menu .menu-item-has-children:hover .sub-menu, .header-menu .sub-menu',
			),
		),
		array(
			'id' => 'colors-submenu-color',
			'type' => 'color',
			'title' => __('Sub-menu text color', 'bcn'),
			'subtitle' => __('Select sub-menu text color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.header-menu .sub-menu a',
				'background-color' => '.header-menu .sub-menu a::before',
			),
		),
		array(
			'id' => 'colors-submenu-hover-bg',
			'type' => 'color',
			'title' => __('Sub-menu active & hover background', 'bcn'),
			'subtitle' => __('Active and hover background color for sub-menus', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.header-menu .sub-menu a:hover, .header-menu .sub-menu a:focus,.header-menu .sub-menu a:active',
			),
		),
		array(
			'id' => 'colors-submenu-hover-color',
			'type' => 'color',
			'title' => __('Sub-menu active & hover text color', 'bcn'),
			'subtitle' => __('Active and hover text color for sub-menus', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.header-menu .sub-menu a:hover, .header-menu .sub-menu a:focus, .header-menu .sub-menu a:active',
				'background-color' => '.header-menu .sub-menu a:hover::before',
			),
		),

//      Header -> icons

		array(
			'id' => 'colors-menu-icons',
			'type' => 'color',
			'title' => __('Menu icons color', 'bcn'),
			'subtitle' => __('Select menu icons color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.usernav button',
				'background-color' => '.usernav__hamburger span',
				'--header-icon-color' => ':root'
			),
		),
		array(
			'id' => 'colors-menu-icons-hover',
			'type' => 'color',
			'title' => __('Menu icons hover color', 'bcn'),
			'subtitle' => __('Select menu icons hover color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.usernav button:hover',
				'background-color' => '.sub-menu a:hover::before',
				'--header-icon-color-hover' => ':root'
			),
		),

//      Header ->  social
//
//		array(
//			'id' => 'colors-menu-soc-icons',
//			'type' => 'color',
//			'title' => __('- Social icons color', 'bcn'),
//			'subtitle' => __('Select social icons color', 'bcn'),
//			'default' => false,
//			'validate' => 'color',
//			'output' => '',
//		),
//		array(
//			'id' => 'colors-menu-soc-icons-hover',
//			'type' => 'color',
//			'title' => __('- Social icons hover color', 'bcn'),
//			'subtitle' => __('Select social icons hover color', 'bcn'),
//			'default' => false,
//			'validate' => 'color',
//			'output' => '',
//		),

//		TODO: for newest version

//      Sidebar

		array(
			'id' => 'colors-sidebar-title',
			'type' => 'section',
			'title' => __('Sidebar', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'colors-sidebar-bg',
			'type' => 'color',
			'title' => __('Sidebar background color', 'bcn'),
			'subtitle' => __('Select sidebar background color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.post-widget, .post-widget .sidebar__inner',
			),
		),
		array(
			'id' => 'colors-sidebar-color',
			'type' => 'color',
			'title' => __('Sidebar text color', 'bcn'),
			'subtitle' => __('Select sidebar text color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => '.post-widget, .post-widget .sidebar__inner',
		),
		array(
			'id' => 'colors-sidebar-links-color',
			'type' => 'color',
			'title' => __('Sidebar links color', 'bcn'),
			'subtitle' => __('Select sidebar links color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.post-widget a, .post-widget .sidebar__inner a',
				'border-bottom-color' => '.post-widget a, .post-widget .sidebar__inner a',
			),
		),

//      Flip panel

		array(
			'id' => 'colors-flip-title',
			'type' => 'section',
			'title' => __('Flip panel', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.

		),
		array(
			'id' => 'colors-flip-bg',
			'type' => 'color',
			'title' => __('Flip panel background color', 'bcn'),
			'subtitle' => __('Select flip panel background color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.flip-block ',
			),
		),
		array(
			'id' => 'colors-flip-color',
			'type' => 'color',
			'title' => __('Flip panel text and icons color', 'bcn'),
			'subtitle' => __('Select text and icons color for flip panel', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => '.flip-block__wrapper, .flip-block__wrapper a',
		),

//      Search panel

		array(
			'id' => 'colors-search-title',
			'type' => 'section',
			'title' => __('Search panel', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'colors-search-bg',
			'type' => 'color',
			'title' => __('Search panel background color', 'bcn'),
			'subtitle' => __('Select search panel background color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.usernav__search-search',
			),
		),
		array(
			'id' => 'colors-search-color',
			'type' => 'color',
			'title' => __('Search panel text and icons color', 'bcn'),
			'subtitle' => __('Select search panel text and icons color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => '.usernav__search-search.usernav__search-search--open  button, .usernav__search-input,.usernav__search-wrapper .usernav__search-input:focus, .usernav__search-input::-webkit-input-placeholder',
		),
		array(
			'id' => 'colors-search-border',
			'type' => 'color',
			'title' => __('Search panel bottom border color', 'bcn'),
			'subtitle' => __('Select search panel bottom border color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'border-bottom-color' => '.usernav__search-input'
			),
		),

//      Posts

		array(
			'id' => 'colors-posts-title',
			'type' => 'section',
			'title' => __('Posts', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'colors-posts-titles',
			'type' => 'color',
			'title' => __('Post title color', 'bcn'),
			'subtitle' => __('Select post title color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => '.post h1',
		),
		array(
			'id' => 'colors-posts-author',
			'type' => 'color',
			'title' => __('Post & block author name color', 'bcn'),
			'subtitle' => __('Select author name color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => '.post .author a',
		),
		array(
			'id' => 'colors-posts-text',
			'type' => 'color',
			'title' => __('Post text color', 'bcn'),
			'subtitle' => __('Select post content color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => '.post .entry-content',
		),
		array(
			'id' => 'colors-posts-h',
			'type' => 'color',
			'title' => __('Post h1, h2, h3, h4, h5, h6 color', 'bcn'),
			'subtitle' => __('Select in post h color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => '.post h1,.post h2,.post h3,.post h4,.post h5,.post h6',
		),
		array(
			'id' => 'colors-posts-blockquote',
			'type' => 'color',
			'title' => __('Post blockquote color', 'bcn'),
			'subtitle' => __('Select in post blockquote color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => '.post blockquote',
		),

//      Pages

		array(
			'id' => 'colors-pages-title',
			'type' => 'section',
			'title' => __('Pages', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'colors-pages-titles',
			'type' => 'color',
			'title' => __('Page title color', 'bcn'),
			'subtitle' => __('Select page title color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => '.page h1',
		),
		array(
			'id' => 'colors-pages-text',
			'type' => 'color',
			'title' => __('Page text color', 'bcn'),
			'subtitle' => __('Select page text color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => '.page ',
		),
		array(
			'id' => 'colors-pages-h',
			'type' => 'color',
			'title' => __('Page h1, h2, h3, h4, h5, h6 color', 'bcn'),
			'subtitle' => __('Select page h color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => '.page h1,.page h2,.page h3,.page h4,.page h5,.page h6',
		),

//      Footer

		array(
			'id' => 'colors-footer-title',
			'type' => 'section',
			'title' => __('Footer', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'colors-footer-bg',
			'type' => 'color',
			'title' => __('Background color', 'bcn'),
			'subtitle' => __('Select footer background color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => 'footer.footer, .footer.footer-first, .footer.footer-second, .footer.footer-third',
			),
		),
		array(
			'id' => 'colors-footer-text',
			'type' => 'color',
			'title' => __('Text color', 'bcn'),
			'subtitle' => __('Select footer text color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => 'footer.footer, .footer.footer-first, .footer.footer-second, .footer.footer-third',
			),
		),
		array(
			'id' => 'colors-footer-links',
			'type' => 'color',
			'title' => __('Links color', 'bcn'),
			'subtitle' => __('Select footer links color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => 'footer.footer a, .footer.footer-first a, .footer.footer-second a, .footer.footer-third a',
			),
		),
		array(
			'id' => 'colors-footer-header',
			'type' => 'color',
			'title' => __('Widgets header text color', 'bcn'),
			'subtitle' => __('Select widgets header text color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => 'footer.footer h2, .footer.footer-first h2, .footer.footer-second h2, .footer.footer-third h2, footer.footer h3, .footer.footer-first h3, .footer.footer-second h3, .footer.footer-third h3',
			),
		),
		array(
			'id' => 'colors-footer-social-bg',
			'type' => 'color',
			'title' => __('Footer social icons background', 'bcn'),
			'subtitle' => __('Select social icons background', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.footer .social-listing li',
			),
		),
		array(
			'id' => 'colors-footer-social',
			'type' => 'color',
			'title' => __('Footer social icons color', 'bcn'),
			'subtitle' => __('Select social icons color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.footer .social-listing a',
			),
		),
		array(
			'id' => 'colors-footer-social-hover',
			'type' => 'color',
			'title' => __('Footer social icons hover color', 'bcn'),
			'subtitle' => __('Select social icons hover color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.footer .social-listing li:hover',
			),
		),

//      sub Footer

		array(
			'id' => 'colors-subfooter-title',
			'type' => 'section',
			'title' => __('Sub footer', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'colors-subfooter-bg',
			'type' => 'color',
			'title' => __('Background color', 'bcn'),
			'subtitle' => __('Select sub footer background color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.sub-footer',
			),
		),
		array(
			'id' => 'colors-subfooter-text',
			'type' => 'color',
			'title' => __('Text color', 'bcn'),
			'subtitle' => __('Select sub footer text color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.sub-footer',
			),
		),
		array(
			'id' => 'colors-subfooter-links',
			'type' => 'color',
			'title' => __('Links color', 'bcn'),
			'subtitle' => __('Select sub footer links color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.sub-footer a',
				'background-color' => '.sub-footer a::before',
			),
		),

//      Portfolio
		array(
			'id' => 'colors-portfolio-title',
			'type' => 'section',
			'title' => __('Portfolio', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'colors-portfolio-bg',
			'type' => 'color',
			'title' => __('Background color', 'bcn'),
			'subtitle' => __('Select portfolio background color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => 'body.portfolio, section.portfolio, .portfolio.portfolio--inverse',
			),
		),
		array(
			'id' => 'colors-portfolio-color',
			'type' => 'color',
			'title' => __('Text color', 'bcn'),
			'subtitle' => __('Select portfolio text color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.portfolio__link, .portfolio__link .uk-h5, .portfolio--grid .portfolio__link, .portfolio--grid .portfolio__link:hover, .portfolio--masonry .portfolio__link, .portfolio--masonry .portfolio__link:hover',
			),
		),
		array(
			'id' => 'colors-portfolio-hover',
			'type' => 'color',
			'title' => __('On hover fade color', 'bcn'),
			'subtitle' => __('Select portfolio item on hover fade color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.portfolio--grid .portfolio__link:hover',
			),
		),
		array(
			'id' => 'colors-portfolio-hover-txt-bg',
			'type' => 'color',
			'title' => __('On hover title background color', 'bcn'),
			'subtitle' => __('Select portfolio item on hover title background color', 'bcn'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.portfolio .uk-overlay-default',
			),
		),

	)
));


Redux::setSection($opt_name, array(
	'title' => __('Theme fonts', 'bcn'),
	'id' => 'theme-fonts',
//    'desc' => __('Font Settings ', 'bcn'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'fonts-body-title',
			'type' => 'section',
			'title' => __('Global fonts setting', 'bcn'),
			'subtitle' => __('Main theme fonts.', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'fonts-body',
			'type' => 'typography',
			'title' => __('Body general font', 'bcn'),
			'google' => true,
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
			'output' => array('body'),
		),
		array(
			'id' => 'fonts-header-title',
			'type' => 'section',
			'title' => __('Header', 'bcn'),
			'indent' => true,
		),
		array(
			'id' => 'fonts-header-logo',
			'type' => 'typography',
			'title' => __('Text logo', 'bcn'),
			'google' => true,
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
			'output' => array('.main-nav__logo'),
		),
		array(
			'id' => 'fonts-header',
			'type' => 'typography',
			'title' => __('Header', 'bcn'),
			'google' => true,
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
			'output' => array('.page-header'),
		),
		array(
			'id' => 'fonts-header-menu',
			'type' => 'typography',
			'title' => __('Top menu', 'bcn'),
			'google' => true,
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
			'output' => array('.header-menu'),
		),
		array(
			'id' => 'fonts-header-submenu',
			'type' => 'typography',
			'title' => __('Top sub menu', 'bcn'),
			'google' => true,
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
			'output' => array('.header-menu .sub-menu'),
		),

//		array(
//			'id' => 'fonts-header-mobile-menu',
//			'type' => 'typography',
//			'title' => __('Mobile menu', 'bcn'),
//			'google' => true,
//			'output' => array(''),
//			'text-align' => false,
//			'color' => false,
//			'default' => false,
//			'text-transform' => true,
//			// TODO: for newest version
//		),
//
//		array(
//			'id' => 'fonts-header-mobile-submenu',
//			'type' => 'typography',
//			'title' => __('Mobile sub menu', 'bcn'),
//			'google' => true,
//			'output' => array(''),
//			'text-align' => false,
//			'color' => false,
//			'default' => false,
//			'text-transform' => true,
//			// TODO: for newest version
//		),
//
//        array(
//            'id' => 'fonts-post-title',
//            'type' => 'section',
//            'title' => __('Post  elements', 'bcn'),
//            'subtitle' => __('Main theme fonts.', 'bcn'),
//            'indent' => true, // Indent all options below until the next 'section' option is set.
//        ),

		array(
			'id' => 'fonts-post-title',
			'type' => 'section',
			'title' => __('Post content', 'bcn'),
			'indent' => true,
		),
		array(
			'id' => 'fonts-post-titles',
			'type' => 'typography',
			'title' => __('Post title', 'bcn'),
			'google' => true,
			'output' => array('.post h1'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
		array(
			'id' => 'fonts-post-content',
			'type' => 'typography',
			'title' => __('Post content', 'bcn'),
			'google' => true,
			'output' => array('.post .entry-content'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
		array(
			'id' => 'fonts-post-blockquote',
			'type' => 'typography',
			'title' => __('Blockquote', 'bcn'),
			'google' => true,
			'output' => array('.post blockquote'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
//		array(
//			'id' => 'fonts-post-boxkquote',
//			'type' => 'typography',
//			'title' => __('Box quote', 'bcn'),
//			'google' => true,
//			'output' => array(''),
//			'text-align' => false,
//			'color' => false,
//			'default' => false,
//			'text-transform' => true,
//			// TODO: for newest version
//		),
//		array(
//			'id' => 'fonts-post-pullquote',
//			'type' => 'typography',
//			'title' => __('Pull quote', 'bcn'),
//			'google' => true,
//			'output' => array(''),
//			'text-align' => false,
//			'color' => false,
//			'default' => false,
//			'text-transform' => true,
//			// TODO: for newest version
//		),
		array(
			'id' => 'fonts-post-lists',
			'type' => 'typography',
			'title' => __('Lists', 'bcn'),
			'google' => true,
			'output' => array('.post ul, .post ol'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
		array(
			'id' => 'fonts-post-h1',
			'type' => 'typography',
			'title' => __('H1', 'bcn'),
			'google' => true,
			'output' => array('.post h1'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
		array(
			'id' => 'fonts-post-h2',
			'type' => 'typography',
			'title' => __('H2', 'bcn'),
			'google' => true,
			'output' => array('.post h2'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
		array(
			'id' => 'fonts-post-h3',
			'type' => 'typography',
			'title' => __('H3', 'bcn'),
			'google' => true,
			'output' => array('.post h3'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
		array(
			'id' => 'fonts-post-h4',
			'type' => 'typography',
			'title' => __('H4', 'bcn'),
			'google' => true,
			'output' => array('.post h4'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
		array(
			'id' => 'fonts-post-h5',
			'type' => 'typography',
			'title' => __('H5', 'bcn'),
			'google' => true,
			'output' => array('.post h5'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
		array(
			'id' => 'fonts-post-h6',
			'type' => 'typography',
			'title' => __('H6', 'bcn'),
			'google' => true,
			'output' => array('.post h6'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),

		array(
			'id' => 'fonts-post-elements-title',
			'type' => 'section',
			'title' => __('Post  elements', 'bcn'),
			'indent' => true,
		),

//		array(
//			'id' => 'fonts-post-elements-category',
//			'type' => 'typography',
//			'title' => __('Category tag', 'bcn'),
//			'google' => true,
//			'output' => array(''),
//			'text-align' => false,
//			'color' => false,
//			'default' => false,
//			'text-transform' => true,
//			// TODO: for newest version
//		),
		array(
			'id' => 'fonts-post-elements-author',
			'type' => 'typography',
			'title' => __('Author', 'bcn'),
			'google' => true,
			'output' => array('.byline'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),

		array(
			'id' => 'fonts-post-elements-date',
			'type' => 'typography',
			'title' => __('Date', 'bcn'),
			'google' => true,
			'output' => array('.posted-on'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),

//		array(
//			'id' => 'fonts-post-elements-views-comments',
//			'type' => 'typography',
//			'title' => __('Views and comments', 'bcn'),
//			'google' => true,
//			'output' => array(''),
//			'text-align' => false,
//			'color' => false,
//			'default' => false,
//			'text-transform' => true,
//			// TODO: for newest version
//		),
		array(
			'id' => 'fonts-post-elements-vst',
			'type' => 'typography',
			'title' => __('Via/source/tags', 'bcn'),
			'google' => true,
			'output' => array('footer.entry-footer'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
		array(
			'id' => 'fonts-post-elements-nptxt',
			'type' => 'typography',
			'title' => __('Next/prev text', 'bcn'),
			'google' => true,
			'output' => array('.post-navigation .nav-previous, .post-navigation .nav-next'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
//		array(
//			'id' => 'fonts-post-elements-nppttxt',
//			'type' => 'typography',
//			'title' => __('+ Next/prev post title', 'bcn'),
//			'google' => true,
//			'output' => array('.site-main .comment-navigation, .site-main .posts-navigation, .site-main .post-navigation'),
//			'text-align' => false,
//			'color' => false,
//			'default' => false,
//			'text-transform' => true,
//			// TODO: for newest version
//		),
		array(
			'id' => 'fonts-post-elements-box-author-name',
			'type' => 'typography',
			'title' => __('Box author name', 'bcn'),
			'google' => true,
			'output' => array('.up-author-name'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
		array(
			'id' => 'fonts-post-elements-box-author-url',
			'type' => 'typography',
			'title' => __('Box author url', 'bcn'),
			'google' => true,
			'output' => array('.up-author-url'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
		array(
			'id' => 'fonts-post-elements-box-author-description',
			'type' => 'typography',
			'title' => __('Box author description', 'bcn'),
			'google' => true,
			'output' => array('.up-author-description'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
//		array(
//			'id' => 'fonts-post-elements-related-article',
//			'type' => 'typography',
//			'title' => __('+ Related article title', 'bcn'),
//			'google' => true,
//			'output' => array('.site-main .comment-navigation, .site-main .posts-navigation, .site-main .post-navigation'),
//			'text-align' => false,
//			'color' => false,
//			'default' => false,
//			'text-transform' => true,
//// TODO: for newest version
//		),

		array(
			'id' => 'fonts-post-elements-share-text',
			'type' => 'typography',
			'title' => __('Share text', 'bcn'),
			'google' => true,
			'output' => array('.pk-share-buttons-wrap'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
		array(
			'id' => 'fonts-post-elements-image-caption',
			'type' => 'typography',
			'title' => __('Image caption', 'bcn'),
			'google' => true,
			'output' => array('.wp-caption-text'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),


		array(
			'id' => 'fonts-pages-title',
			'type' => 'section',
			'title' => __('Pages', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'fonts-pages-titles',
			'type' => 'typography',
			'title' => __('Page title', 'bcn'),
			'google' => true,
			'output' => array('.page h1'),
			'text-align' => false,
			'default' => false,
			'text-transform' => true,
		),

		array(
			'id' => 'fonts-pages-content',
			'type' => 'typography',
			'title' => __('Page content', 'bcn'),
			'google' => true,
			'output' => array('.page'),
			'text-align' => false,
			'default' => false,
			'text-transform' => true,
		),

		array(
			'id' => 'fonts-pages-h1',
			'type' => 'typography',
			'title' => __('H1', 'bcn'),
			'google' => true,
			'output' => array('.page h1'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
		array(
			'id' => 'fonts-pages-h2',
			'type' => 'typography',
			'title' => __('H2', 'bcn'),
			'google' => true,
			'output' => array('.page h2'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
		array(
			'id' => 'fonts-pages-h3',
			'type' => 'typography',
			'title' => __('H3', 'bcn'),
			'google' => true,
			'output' => array('.page h3'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
		array(
			'id' => 'fonts-pages-h4',
			'type' => 'typography',
			'title' => __('H4', 'bcn'),
			'google' => true,
			'output' => array('.page h4'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
		array(
			'id' => 'fonts-pages-h5',
			'type' => 'typography',
			'title' => __('H5', 'bcn'),
			'google' => true,
			'output' => array('.page h5'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
		array(
			'id' => 'fonts-pages-h6',
			'type' => 'typography',
			'title' => __('H6', 'bcn'),
			'google' => true,
			'output' => array('.page h6'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),

		array(
			'id' => 'fonts-footer-title',
			'type' => 'section',
			'title' => __('Footer fonts settings', 'bcn'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'fonts-footer-text',
			'type' => 'typography',
			'title' => __('Footer text', 'bcn'),
			'google' => true,
			'output' => array('footer.footer, .footer.footer-first, .footer.footer-second, .footer.footer-third, footer.footer a, .footer.footer-first a, .footer.footer-second a, .footer.footer-third a, footer.footer h2, .footer.footer-first h2, .footer.footer-second h2, .footer.footer-third h2, footer.footer h3, .footer.footer-first h3, .footer.footer-second h3, .footer.footer-third h3'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
		array(
			'id' => 'fonts-footer-menu',
			'type' => 'typography',
			'title' => __('Footer menu', 'bcn'),
			'google' => true,
			'output' => array('.footer-menu'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),
	),
));

Redux::setSection($opt_name, array(
	'title' => __('Custom css code', 'bcn'),
	'id' => 'custom-code',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'custom-code-css',
			'type' => 'ace_editor',
			'full_width' => true,
			'title' => __('CSS Code', 'bcn'),
			'subtitle' => __('Paste your CSS code here.', 'bcn'),
			'mode' => 'css',
			'theme' => 'monokai',
			'desc' => 'The css from this box will load on all the pages of the site.',
			'default' => ""
		),
	)

));

//   Social networks

Redux::setSection($opt_name, array(
	'title' => __('Social networks', 'bcn'),
	'id' => 'social-networks',
	'desc' => __('Insert a link to your account if you want to display this social network.', 'bcn'),
	'subsection' => true,
	'fields' => array(

//      Most popular socials

		array(
			'id' => 'social-twitter',
			'type' => 'text',
			'title' => __('Twitter', 'bcn'),
			'desc' => __('Link to: twitter', 'bcn'),
		),
		array(
			'id' => 'social-facebook',
			'type' => 'text',
			'title' => __('Facebook', 'bcn'),
			'desc' => __('Link to: facebook', 'bcn'),
		),
		array(
			'id' => 'social-instagram',
			'type' => 'text',
			'title' => __('Instagram', 'bcn'),
			'desc' => __('Link to: instagram', 'bcn'),
		),
		array(
			'id' => 'social-youtube',
			'type' => 'text',
			'title' => __('Youtube', 'bcn'),
			'desc' => __('Link to: youtube', 'bcn'),
		),

//      Regular

		array(
			'id' => 'social-behance',
			'type' => 'text',
			'title' => __('Behance', 'bcn'),
			'desc' => __('Link to: behance', 'bcn'),
		),
		array(
			'id' => 'social-blogger',
			'type' => 'text',
			'title' => __('Blogger', 'bcn'),
			'desc' => __('Link to: blogger', 'bcn'),
		),
		array(
			'id' => 'social-dailymotion',
			'type' => 'text',
			'title' => __('Dailymotion', 'bcn'),
			'desc' => __('Link to: dailymotion', 'bcn'),
		),
		array(
			'id' => 'social-delicious',
			'type' => 'text',
			'title' => __('Delicious', 'bcn'),
			'desc' => __('Link to: delicious', 'bcn'),
		),

		array(
			'id' => 'social-deviantart',
			'type' => 'text',
			'title' => __('Deviantart', 'bcn'),
			'desc' => __('Link to: deviantart', 'bcn'),
		),
		array(
			'id' => 'social-digg',
			'type' => 'text',
			'title' => __('Digg', 'bcn'),
			'desc' => __('Link to: digg', 'bcn'),
		),
		array(
			'id' => 'social-dribbble',
			'type' => 'text',
			'title' => __('Dribbble', 'bcn'),
			'desc' => __('Link to: dribbble', 'bcn'),
		),
		array(
			'id' => 'social-dropbox',
			'type' => 'text',
			'title' => __('Dropbox', 'bcn'),
			'desc' => __('Link to: dropbox', 'bcn'),
		),
		array(
			'id' => 'social-evernote',
			'type' => 'text',
			'title' => __('Evernote', 'bcn'),
			'desc' => __('Link to: evernote', 'bcn'),
		),
		array(
			'id' => 'social-flickr',
			'type' => 'text',
			'title' => __('Flickr', 'bcn'),
			'desc' => __('Link to: flickr', 'bcn'),
		),
		array(
			'id' => 'social-googleplus',
			'type' => 'text',
			'title' => __('Google +', 'bcn'),
			'desc' => __('Link to: googleplus', 'bcn'),
		),
		array(
			'id' => 'social-instagram',
			'type' => 'text',
			'title' => __('Last FM', 'bcn'),
			'desc' => __('Link to: instagram', 'bcn'),
		),
		array(
			'id' => 'social-linkedin',
			'type' => 'text',
			'title' => __('LinkedIN', 'bcn'),
			'desc' => __('Link to: linkedin', 'bcn'),
		),
		array(
			'id' => 'social-picasa',
			'type' => 'text',
			'title' => __('Picasa', 'bcn'),
			'desc' => __('Link to: picasa', 'bcn'),
		),
		array(
			'id' => 'social-pinterest',
			'type' => 'text',
			'title' => __('Pinterest', 'bcn'),
			'desc' => __('Link to: pinterest', 'bcn'),
		),
		array(
			'id' => 'social-rss',
			'type' => 'text',
			'title' => __('RSS', 'bcn'),
			'desc' => __('Link to: rss', 'bcn'),
		),
		array(
			'id' => 'social-tumblr',
			'type' => 'text',
			'title' => __('Tumblr', 'bcn'),
			'desc' => __('Link to: tumblr', 'bcn'),
		),
		array(
			'id' => 'social-vimeo',
			'type' => 'text',
			'title' => __('Vimeo', 'bcn'),
			'desc' => __('Link to: vimeo', 'bcn'),
		),
		array(
			'id' => 'social-wordpress',
			'type' => 'text',
			'title' => __('WordPress', 'bcn'),
			'desc' => __('Link to: wordpress', 'bcn'),
		),
		array(
			'id' => 'social-500pixels',
			'type' => 'text',
			'title' => __('500 pixels', 'bcn'),
			'desc' => __('Link to: 500 pixels', 'bcn'),
		),
		array(
			'id' => 'social-viewbug',
			'type' => 'text',
			'title' => __('ViewBug', 'bcn'),
			'desc' => __('Link to: viewbug', 'bcn'),
		),
		array(
			'id' => 'social-xing',
			'type' => 'text',
			'title' => __('Xing', 'bcn'),
			'desc' => __('Link to: xing', 'bcn'),
		),
		array(
			'id' => 'social-spotify',
			'type' => 'text',
			'title' => __('Spotify', 'bcn'),
			'desc' => __('Link to: spotify', 'bcn'),
		),
		array(
			'id' => 'social-houzz',
			'type' => 'text',
			'title' => __('Houzz', 'bcn'),
			'desc' => __('Link to: houzz', 'bcn'),
		),
		array(
			'id' => 'social-skype',
			'type' => 'text',
			'title' => __('Skype', 'bcn'),
			'desc' => __('Link to: skype', 'bcn'),
		),
		array(
			'id' => 'social-slideshare',
			'type' => 'text',
			'title' => __('Slideshare', 'bcn'),
			'desc' => __('Link to: slideshare', 'bcn'),
		),
		array(
			'id' => 'social-bandcamp',
			'type' => 'text',
			'title' => __('Bandcamp', 'bcn'),
			'desc' => __('Link to: bandcamp', 'bcn'),
		),
		array(
			'id' => 'social-soundcloud',
			'type' => 'text',
			'title' => __('Soundcloud', 'bcn'),
			'desc' => __('Link to: soundcloud', 'bcn'),
		),
		array(
			'id' => 'social-periscope',
			'type' => 'text',
			'title' => __('Periscope', 'bcn'),
			'desc' => __('Link to: periscope', 'bcn'),
		),
		array(
			'id' => 'social-snapchat',
			'type' => 'text',
			'title' => __('Snapchat', 'bcn'),
			'desc' => __('Link to: snapchat', 'bcn'),
		),
		array(
			'id' => 'social-thecity',
			'type' => 'text',
			'title' => __('The City', 'bcn'),
			'desc' => __('Link to: thecity', 'bcn'),
		),
		array(
			'id' => 'social-microsoft-pinpoint',
			'type' => 'text',
			'title' => __('Microsoft Pinpoint', 'bcn'),
			'desc' => __('Link to: microsoft pinpoint', 'bcn'),
		),
		array(
			'id' => 'social-viadeo',
			'type' => 'text',
			'title' => __('Viadeo', 'bcn'),
			'desc' => __('Link to: viadeo', 'bcn'),
		),
		array(
			'id' => 'social-tripadvisor',
			'type' => 'text',
			'title' => __('TripAdvisor', 'bcn'),
			'desc' => __('Link to: tripadvisor', 'bcn'),
		),
		array(
			'id' => 'social-vk',
			'type' => 'text',
			'title' => __('VKontakte', 'bcn'),
			'desc' => __('Link to: vkontakte', 'bcn'),
		),
		array(
			'id' => 'social-ok',
			'type' => 'text',
			'title' => __('Odnoklassniki', 'bcn'),
			'desc' => __('Link to: odnoklassniki', 'bcn'),
		),
		array(
			'id' => 'social-telegram',
			'type' => 'text',
			'title' => __('Telegram', 'bcn'),
			'desc' => __('Link to: telegram', 'bcn'),
		),
	)
));

Redux::setSection($opt_name, array(
	'title' => __('Import - export', 'bcn'),
	'id' => 'import-export',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'import-export',
			'type' => 'import_export',
//            'title' => 'Import Export',
//            'subtitle' => 'Save and restore your Redux options',
			'full_width' => true,
		),
	)
));

/*
 * <--- END SECTIONS
 */

/*
    As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for
 */

/*
 *
 * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
 *
 */

/*
*
* --> Action hook examples
*
*/

// If Redux is running as a plugin, this will remove the demo notice and links
//add_action( 'redux/loaded', 'remove_demo' );

// Function to test the compiler hook and demo CSS output.
// Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
//add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

// Change the arguments after they've been declared, but before the panel is created
//add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

// Change the default value of a field after it's been set, but before it's been useds
//add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

// Dynamically add a section. Can be also used to modify sections/fields
//add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

/**
 * This is a test function that will let you see when the compiler hook occurs.
 * It only runs if a field    set with compiler=>true is changed.
 * */
if (!function_exists('compiler_action')) {
	function compiler_action($options, $css, $changed_values)
	{
		echo '<h1>The compiler hook has run!</h1>';
		echo "<pre>";
		print_r($changed_values); // Values that have changed since the last save
		echo "</pre>";
		//print_r($options); //Option values
		//print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
	}
}

/**
 * Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')) {
	function redux_validate_callback_function($field, $value, $existing_value)
	{
		$error = false;
		$warning = false;

		//do your validation
		if ($value == 1) {
			$error = true;
			$value = $existing_value;
		} elseif ($value == 2) {
			$warning = true;
			$value = $existing_value;
		}

		$return['value'] = $value;

		if ($error == true) {
			$field['msg'] = 'your custom error message';
			$return['error'] = $field;
		}

		if ($warning == true) {
			$field['msg'] = 'your custom warning message';
			$return['warning'] = $field;
		}

		return $return;
	}
}

/**
 * Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')) {
	function redux_my_custom_field($field, $value)
	{
		print_r($field);
		echo '<br/>';
		print_r($value);
	}
}

/**
 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
 * so you must use get_template_directory_uri() if you want to use any of the built in icons
 * */
if (!function_exists('dynamic_section')) {
	function dynamic_section($sections)
	{
		//$sections = array();
		$sections[] = array(
			'title' => __('Section via hook', 'bcn'),
			'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'bcn'),
			'icon' => 'el el-paper-clip',
			// Leave this as a blank section, no options just some intro text set above.
			'fields' => array()
		);

		return $sections;
	}
}

/**
 * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
 * */
if (!function_exists('change_arguments')) {
	function change_arguments($args)
	{
		$args['dev_mode'] = false;

		return $args;
	}
}

/**
 * Filter hook for filtering the default value of any given field. Very useful in development mode.
 * */
if (!function_exists('change_defaults')) {
	function change_defaults($defaults)
	{
		$defaults['str_replace'] = 'Testing filter hook!';

		return $defaults;
	}
}
