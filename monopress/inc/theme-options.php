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
	'display_name' => 'Monopress ' . esc_html__('Options', 'monopress') . '',
	// Name that appears at the top of your panel
	'display_version' => $theme->get('Version'),
	// Version that appears at the top of your panel
	'menu_type' => 'menu',
	//Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
	'allow_sub_menu' => true,
	// Show the sections below the admin menu item or not
	'menu_title' => __('Theme Options', 'monopress'),
	'page_title' => __('Theme Options', 'monopress'),
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
	'update_notice' => false,
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
	'id' => 'monopress-docs',
	'href' => 'https://docs.urazaev.com/monopress-wp/',
	'title' => __('Documentation', 'monopress'),
);

$args['admin_bar_links'][] = array(
	//'id'    => 'monopress-support',
	'href' => 'https://up.ticksy.com/',
	'title' => __('Support', 'monopress'),
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


// Add content after the form.
$args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'monopress');

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
//        'title' => __('Theme Information 1', 'monopress'),
//        'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'monopress')
//    ),
//    array(
//        'id' => 'redux-help-tab-2',
//        'title' => __('Theme Information 2', 'monopress'),
//        'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'monopress')
//    )
//);
//Redux::setHelpTab($opt_name, $tabs);
//
//// Set the help sidebar
//$content = __('<p>This is the sidebar content, HTML is allowed.</p>', 'monopress');
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

// -> START Main Page
Redux::setSection($opt_name, array(
	'title' => __('Main Page', 'monopress'),
	'id' => 'main-page',
	'desc' => __('Main Page options', 'monopress'),
	'icon' => 'el el-adjust-alt',
	'fields' => array(
		array(
			'id' => 'main-page-featured-title',
			'type' => 'section',
			'title' => __('Main page featured block', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'main-page-featured',
			'type' => 'switch',
			'title' => __('Show top featured block', 'monopress'),
			'default' => true,
		),
		array(
			'required' => array('main-page-featured', '=', '1'),
			'id' => 'main-page-featured-cat',
			'type' => 'select',
			'multi' => true,
			'title' => __('Featured post categories', 'monopress'),
			'data' => 'categories',

		),
		array(
			'required' => array('main-page-featured', '=', '1'),
			'id' => 'main-page-featured-num',
			'type' => 'text',
			'title' => __('Featured post limit', 'monopress'),
			'default' => '2',
		),
		array(
			'required' => array('main-page-featured', '=', '1'),
			'id' => 'main-page-featured-display',
			'type' => 'image_select',
			'title' => __('Article display view', 'monopress'),
			'subtitle' => __('Select a module type, this is how your featured list will be displayed.', 'monopress'),
			'options' => array(
				'layout_2' => array(
					'alt' => '2',
					'img' => get_template_directory_uri() . '/images/admin/post-layout-02.png'
				),
				'layout_4' => array(
					'alt' => '4',
					'img' => get_template_directory_uri() . '/images/admin/post-layout-04.png'
				),
				'layout_7' => array(
					'alt' => '7',
					'img' => get_template_directory_uri() . '/images/admin/post-layout-07.png'
				),
				'layout_14' => array(
					'alt' => '14',
					'img' => get_template_directory_uri() . '/images/admin/post-layout-14.png'
				),
				'layout_21' => array(
					'alt' => '21',
					'img' => get_template_directory_uri() . '/images/admin/post-layout-21.png'
				),
				'layout_22' => array(
					'alt' => '22',
					'img' => get_template_directory_uri() . '/images/admin/post-layout-22.png'
				),
			),
			'default' => '2',
		),
		array(
			'id' => 'main-page-display-title',
			'type' => 'section',
			'title' => __('Main page post listing', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'main-page-display',
			'type' => 'image_select',
			'title' => __('Article display view', 'monopress'),
			'subtitle' => __('Select a module type, this is how your article list will be displayed.', 'monopress'),
			'options' => array(
				'layout_2' => array(
					'alt' => '2',
					'img' => get_template_directory_uri() . '/images/admin/post-layout-02.png'
				),
				'layout_4' => array(
					'alt' => '4',
					'img' => get_template_directory_uri() . '/images/admin/post-layout-04.png'
				),
				'layout_7' => array(
					'alt' => '7',
					'img' => get_template_directory_uri() . '/images/admin/post-layout-07.png'
				),
				'layout_14' => array(
					'alt' => '14',
					'img' => get_template_directory_uri() . '/images/admin/post-layout-14.png'
				),
				'layout_21' => array(
					'alt' => '21',
					'img' => get_template_directory_uri() . '/images/admin/post-layout-21.png'
				),
				'layout_22' => array(
					'alt' => '22',
					'img' => get_template_directory_uri() . '/images/admin/post-layout-22.png'
				),
			),
			'default' => '2',
		),
		array(
			'id' => 'main-page-pagination',
			'type' => 'select',
			'title' => __('Pagination style', 'monopress'),
			'subtitle' => __('Set a pagination style for main page.', 'monopress'),
			'options' => array(
				'1' => 'Normal pagination',
				'2' => 'Infinite loading',
//				'3' => 'Infinite loading + Load more',
//			TODO for newest options
			),
			'default' => '1',
		),
		array(
			'id' => 'main-page-sidebar',
			'type' => 'image_select',
			'title' => __('Sidebar position', 'monopress'),
			'subtitle' => __('Sidebar position and custom sidebars.', 'monopress'),
			'options' => array(
				'sidebar_1' => array(
					'alt' => 'No sidebar',
					'img' => get_template_directory_uri() . '/images/admin/layout-no-sidebar.png'

				),
				'sidebar_2' => array(
					'alt' => 'Left sidebar',
					'img' => get_template_directory_uri() . '/images/admin/layout-left-sidebar.png'
				),
				'sidebar_3' => array(
					'alt' => 'Right sidebar',
					'img' => get_template_directory_uri() . '/images/admin/layout-right-sidebar.png'
				),
			),
			'default' => '2'
		),
	)
));


// -> START Header
Redux::setSection($opt_name, array(
	'title' => __('Header', 'monopress'),
	'id' => 'header',
	'desc' => __('Header options', 'monopress'),
	'icon' => 'el el-adjust-alt'
));

Redux::setSection($opt_name, array(
	'title' => __('Header and main menu', 'monopress'),
	'id' => 'header-style',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'header-layout',
			'type' => 'image_select',
			'title' => __('Header style', 'monopress'),
//            TODO: paste icons
			'subtitle' => __('Select the layout in which the header elements will be arranged (horizontal or vertical)', 'monopress'),
			'width' => '1200',
			'options' => array(
				'1' => array(
					'alt' => 'Top',
					'img' => get_template_directory_uri() . '/images/admin/layout-navigation-top.png'
				),
				'2' => array(
					'alt' => 'Left',
					'img' => get_template_directory_uri() . '/images/admin/layout-navigation-left.png'
				),
			),
			'default' => '1'
		),
		array(
			'id' => 'header-bg-title',
			'type' => 'section',
			'title' => __('Header background', 'monopress'),
			'subtitle' => __('You can overwrite the template on each block and widget.', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'header-bg',
			'type' => 'background',
			'output' => array('header.page-header, .vertical-main-sidebar__left'),
			'title' => __('Header background', 'monopress'),
			'background-color' => 'false',

		),
//        array(
//            'id' => 'header-bg-opacity',
//            'type' => 'text',
//            'title' => __('Background opacity', 'monopress'),
//            'subtitle' => __('Set the background image transparency (Example: 0.5)', 'monopress'),
////            'default' => __('0.5', 'monopress'),
//// TODO: for newest version
//        ),
		array(
			'id' => 'main-menu-title',
			'type' => 'section',
			'title' => __('Main menu', 'monopress'),
			'subtitle' => __('You can overwrite the template on each block and widget.', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'main-menu-enabled',
			'type' => 'switch',
			'title' => __('Show header menu (main)', 'monopress'),
			'subtitle' => __('Show a menu for the main header section', 'monopress'),
			'default' => 1,
		),
		array(
			'required' => array('main-menu-enabled', '=', '1'),
			'id' => 'main-menu-select',
			'type' => 'select',
			'data' => 'menu_location',
			'title' => __('Header menu (main)', 'monopress'),
			'subtitle' => __('Select a menu for the main header section', 'monopress'),
		),
		array(
			'required' => array('header-layout', '=', '1'),
			'id' => 'main-menu-sticky',
			'type' => 'switch',
			'title' => __('Sticky menu', 'monopress'),
			'subtitle' => __('How to display the header menu on scroll', 'monopress'),
			'default' => 'false',
		),
//        array(
//            'id' => 'main-menu-sticky-logo',
//            'type' => 'select',
//            'title' => __('- Logo on sticky menu', 'monopress'),
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
			'title' => __('Show date', 'monopress'),
			'subtitle' => __('Hide or show the date in the top menu', 'monopress'),
			'default' => 1,
			'on' => 'Enabled',
			'off' => 'Disabled',
		),
		array(
			'id' => 'main-menu-weather',
			'type' => 'switch',
			'title' => __('Show weather', 'monopress'),
			'subtitle' => __('Hide or show the weather info in the top menu', 'monopress'),
			'default' => 1,
			'on' => 'Enabled',
			'off' => 'Disabled',
		),
		array(
			'required' => array('header-layout', '=', '1'),
			'id' => 'main-menu-search',
			'type' => 'switch',
			'title' => __('Show search icon', 'monopress'),
			'subtitle' => __('Show or hide search icon', 'monopress'),
			'description' => __('Hide or show the search dialog info in the top menu.', 'monopress'),
			'default' => 1,
			'on' => 'Enabled',
			'off' => 'Disabled',
		),
		array(
			'required' => array('header-layout', '=', '1'),
			'id' => 'main-menu-flip',
			'type' => 'switch',
			'title' => __('Show flip panel', 'monopress'),
			'subtitle' => __('Show or hide the flip', 'monopress'),
			'description' => __('The flip panel uses sidebar to show information. To add content to the flip panel go to the widgets section and drag widget to the Flip Panel sidebar.', 'monopress'),
			'default' => 1,
			'on' => 'Enabled',
			'off' => 'Disabled',
		),
	)
));

//Redux::setSection($opt_name, array(
//    'title' => __('Search position', 'monopress'),
//    'id' => 'search-position',
//    'subsection' => true,
//    'desc' => __('For full documentation on this field, visit: ', 'monopress') . '<a href="//docs.reduxframework.com/core/fields/radio/" target="_blank">docs.reduxframework.com/core/fields/radio/</a>',
//    'fields' => array()
//    // TODO: for newest version
//));

//Redux::setSection($opt_name, array(
//    'title' => __('Top bar', 'monopress'),
//    'id' => 'top-bar',
//    'subsection' => true,
//    'desc' => __('For full documentation on this field, visit: ', 'monopress') . '<a href="//docs.reduxframework.com/core/fields/sortable/" target="_blank">docs.reduxframework.com/core/fields/sortable/</a>',
//    'fields' => array()
//    // TODO: for newest version
//));


Redux::setSection($opt_name, array(
	'title' => __('Logo ', 'monopress'),
	'id' => 'logo-favicon',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'logo-type-title',
			'type' => 'section',
			'title' => __('Text or img logo', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'logo-type',
			'type' => 'switch',
			'title' => __('Show the image for logos or text', 'monopress'),
			'subtitle' => __('Text or img logo', 'monopress'),
			'default' => 1,
			'on' => 'Image',
			'off' => 'Text',
		),
		array(
			'required' => array('logo-type', '=', '1'),
			'id' => 'logo-desktop-title',
			'type' => 'section',
			'title' => __('Logo for desktop', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'logo',
			'type' => 'media',
			'url' => true,
			'title' => __('Logo upload', 'monopress'),
			'compiler' => 'true',
			'subtitle' => __('Upload your logo .png or .jpg', 'monopress'),
		),
		array(
			'id' => 'logo-retina',
			'type' => 'media',
			'url' => true,
			'title' => __('Retina logo upload', 'monopress'),
			'compiler' => 'true',
			'subtitle' => __('Upload your retina logo .png or .jpg.<ul><li>If you do not set any retina logo, the site will load the normal logo on retina displays</li><li>The retina logo has to have the same file format with the normal logo</li></ul>', 'monopress'),
		),
		array(
			'id' => 'logo-alt',
			'type' => 'text',
			'title' => __('Logo alt attribute', 'monopress'),
			'subtitle' => __('Alt attribute for the logo.', 'monopress'),
			'description' => __('This is the alternative text if the logo cannot be displayed. It\'s useful for SEO and generally is the name of the site.', 'monopress'),
		),
		array(
			'id' => 'logo-title',
			'type' => 'text',
			'title' => __('Logo title attribute', 'monopress'),
			'subtitle' => __('Title attribute for the logo.', 'monopress'),
		),
		array(
			'required' => array('logo-type', '=', '1'),
			'id' => 'logo-mobile-title',
			'type' => 'section',
			'title' => __('Logo for mobile', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'logo-mobile',
			'type' => 'media',
			'url' => true,
			'title' => __('Logo mobile', 'monopress'),
			'compiler' => 'true',
			'subtitle' => __('Upload your logo', 'monopress'),
		),
		array(
			'id' => 'logo-mobile-retina',
			'type' => 'media',
			'url' => true,
			'title' => __('Retina logo mobile', 'monopress'),
			'compiler' => 'true',
			'subtitle' => __('Upload your retina logo (double size)', 'monopress'),
		),
		array(
			'required' => array('logo-type', '=', '0'),
			'id' => 'logo-txt-title',
			'type' => 'section',
			'title' => __('Plain text logo', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'logo-txt',
			'type' => 'text',
			'title' => __('Text logo', 'monopress'),
			'subtitle' => __('Write a text logo', 'monopress'),
		),
//        array(
//            'id' => 'logo-title',
//            'type' => 'text',
//            'title' => __('Text logo tagline', 'monopress'),
//            'subtitle' => __('Write a tagline for the text logo.', 'monopress'),
//            'description' => __('This attribute specifies extra information about the logo. Most browsers will show a tooltip with this text on logo hover.', 'monopress'),
//        ),
//// TODO: for newest version

	)
));

Redux::setSection($opt_name, array(
	'title' => __('Favicon & ios bookmarklet', 'monopress'),
	'id' => 'ios-bookmarklet',
	'desc' => __('The bookmarklets work on iOS and Android. When a user adds your site to the home screen, the phone will download one of the icons from here (based on the screen size and device type) and your site will appear with that icon on the homes creen', 'monopress'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'favicon',
			'type' => 'media',
			'url' => true,
			'title' => __('Site favicon', 'monopress'),
			'compiler' => 'true',
			'subtitle' => __('Optional - upload a favicon image .png', 'monopress'),
		),
		array(
			'id' => 'bookmarklet-76',
			'type' => 'media',
			'url' => true,
			'title' => __('Image 76 x 76', 'monopress'),
			'compiler' => 'true',
			//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'subtitle' => __('Upload your icon (76 x 76px).png', 'monopress'),
		),
		array(
			'id' => 'bookmarklet-114',
			'type' => 'media',
			'url' => true,
			'title' => __('Image 114 x 114', 'monopress'),
			'compiler' => 'true',
			//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'subtitle' => __('Upload your icon (114 x 114px).png', 'monopress'),
		),
		array(
			'id' => 'bookmarklet-120',
			'type' => 'media',
			'url' => true,
			'title' => __('Image 120 x 120', 'monopress'),
			'compiler' => 'true',
			//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'subtitle' => __('Upload your icon (120 x 120px).png', 'monopress'),
		),
		array(
			'id' => 'bookmarklet-144',
			'type' => 'media',
			'url' => true,
			'title' => __('Image 144 x 144', 'monopress'),
			'compiler' => 'true',
			//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'subtitle' => __('Upload your icon (144 x 144px).png', 'monopress'),
		),
		array(
			'id' => 'bookmarklet-152',
			'type' => 'media',
			'url' => true,
			'title' => __('Image 152 x 152', 'monopress'),
			'compiler' => 'true',
			//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'subtitle' => __('Upload your icon (152 x 152px).png', 'monopress'),
		),
	)
));

// -> START Footer
Redux::setSection($opt_name, array(
	'title' => __('Footer', 'monopress'),
	'id' => 'footer',
	'icon' => 'el el-edit',
));

Redux::setSection($opt_name, array(
	'title' => __('Footer settings', 'monopress'),
	'id' => 'footer-settings',
	//'icon'  => 'el el-home'
	'desc' => __('The footer uses sidebars to show information. Here you can customize the number of sidebars and the layout. To add content to the footer head go to the widgets section and drag widget to the Footer 1, Footer 2 and Footer 3 sidebars.', 'monopress'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'footer-on',
			'type' => 'switch',
			'title' => __('Show footer', 'monopress'),
			'subtitle' => __('Show or hide the footer', 'monopress'),
			'default' => 0,
			'on' => 'Enabled',
			'off' => 'Disabled',
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-layout',
			'type' => 'image_select',
			'title' => __('Footer templates', 'monopress'),
			'subtitle' => __('Set the footer template', 'monopress'),
			'options' => array(
				'1' => array(
					'alt' => 'First',
					'img' => get_template_directory_uri() . '/images/admin/layout-footer-1.png'
				),
				'3' => array(
					'alt' => 'Third',
					'img' => get_template_directory_uri() . '/images/admin/layout-footer-3.png'
				),
				'2' => array(
					'alt' => 'Second',
					'img' => get_template_directory_uri() . '/images/admin/layout-footer-2.png'
				),
			),
			'default' => '1',
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-bg-title',
			'type' => 'section',
			'title' => __('Footer background', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
			'output' => 'footer::after',
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-bg',
			'type' => 'background',
			'output' => array('footer'),
			'title' => __('Footer background', 'monopress'),
			'background-color' => 'false',
		),
//    array(
//      'required' => array('footer-on', '=', '1'),
//      'id' => 'footer-bg-opacity',
//      'type' => 'text',
//      'title' => __('Background opacity', 'monopress'),
//      'subtitle' => __('Set the background image transparency (Example: 0.5)', 'monopress'),
//      'default' => __('0.5', 'monopress'),
//    ),
//    // TODO: for newest version
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-content-title',
			'type' => 'section',
			'title' => __('Footer content', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-logo',
			'type' => 'media',
			'url' => true,
			'title' => __('Footer logo', 'monopress'),
			'desc' => __('Upload your logo.', 'monopress'),
			'subtitle' => __('Different one from the header logo. If footer logo is not specified, the site will load the default normal logo.', 'monopress'),
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-logo-retina',
			'type' => 'media',
			'url' => true,
			'title' => __('Footer retina logo', 'monopress'),
			'desc' => __('Upload your retina logo (double size)', 'monopress'),
			'subtitle' => __('Different one from the header logo. If footer logo is not specified, the site will load the default retina logo.', 'monopress'),
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-logo-alt',
			'type' => 'text',
			'title' => __('Logo alt attribute', 'monopress'),
			'subtitle' => __('Alt attribute for the logo.', 'monopress'),
			'description' => __('This is the alternative text if the logo cannot be displayed. It\'s useful for SEO and generally is the name of the site.', 'monopress'),
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-logo-title',
			'type' => 'text',
			'title' => __('Logo title attribute', 'monopress'),
			'subtitle' => __('Title attribute for the logo.', 'monopress'),
			'description' => __('This attribute specifies extra information about the logo. Most browsers will show a tooltip with this text on logo hover.', 'monopress'),
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-text',
			'type' => 'textarea',
			'title' => __('Footer text', 'monopress'),
			'subtitle' => __('Write here your footer text', 'monopress'),
			'description' => __('Usually it\'s a text about your sites topic', 'monopress'),
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-email',
			'type' => 'text',
			'title' => __('Your email address', 'monopress'),
			'subtitle' => __('Your email address', 'monopress'),
			'description' => __('Your contact email address', 'monopress'),
		),
		array(
			'required' => array('footer-on', '=', '1'),
			'id' => 'footer-social',
			'type' => 'switch',
			'title' => __('Show social icons', 'monopress'),
			'subtitle' => __('Show or hide the social icons, to setup the Social icons go to Miscellaneous > Social Networks', 'monopress'),
			//'options' => array('on', 'off'),
			'default' => false,
		),
	),
));

Redux::setSection($opt_name, array(
	'title' => __('Instagram section', 'monopress'),
	'id' => 'instagram',
	'subsection' => true,
	'desc' => __('From this section you can set and configure the Footer Instagram Section - this area appears above the footer section on all pages', 'monopress'),
	'fields' => array(
		array(
			'id' => 'instagram-on',
			'type' => 'switch',
			'title' => __('Show the footer instagram section', 'monopress'),
			'subtitle' => __('Show or hide the instagram section', 'monopress'),
			'default' => 0,
			'on' => 'Enabled',
			'off' => 'Disabled',
		),
		array(
			'required' => array('instagram-on', '=', '1'),
			'id' => 'instagram-id',
			'type' => 'text',
			'title' => __('Instagram id', 'monopress'),
			'subtitle' => __('Enter the ID as it appears after the instagram url ( ex. instagram.com/myID )', 'monopress'),
		),
//		array(
//			'required' => array('instagram-on', '=', '1'),
//			'id' => 'instagram-token',
//			'type' => 'text',
//			'title' => __('Instagram token', 'monopress'),
//			'subtitle' => __('Enter the instagram token', 'monopress'),
//		),
		array(
			'required' => array('instagram-on', '=', '1'),
			'id' => 'instagram-images',
			'type' => 'select',
			'title' => __('Number of images', 'monopress'),
			'subtitle' => __('Set the number of images displayed from instagram.', 'monopress'),
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
			'title' => __('Number of columns', 'monopress'),
			'subtitle' => __('The number of columns in your feed. 1 - 10.', 'monopress'),
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
			'title' => __('Image gap', 'monopress'),
			'subtitle' => __('Set a gap between images (default: No gap)', 'monopress'),
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
	'title' => __('Sub footer settings', 'monopress'),
	'id' => 'sub-footer-settings',
	'subsection' => true,
	'desc' => __('The sub footer section is the content under the main footer. It usually includes a copyright text and a menu spot on the right', 'monopress'),
	'fields' => array(
		array(
			'id' => 'subfooter-on',
			'type' => 'switch',
			'title' => __('Show sub-footer', 'monopress'),
			'subtitle' => __('Show or hide the sub-footer', 'monopress'),
			'default' => 0,
			'on' => 'Enabled',
			'off' => 'Disabled',
		),

		array(
			'required' => array('subfooter-on', '=', '1'),
			'id' => 'subfooter-text',
			'type' => 'editor',
			'title' => __('Sub footer copyright text', 'monopress'),
			'subtitle' => __('Set sub footer copyright text', 'monopress'),
		),
		array(
			'required' => array('subfooter-on', '=', '1'),
			'id' => 'subfooter-copy',
			'type' => 'switch',
			'title' => __('Copyright symbol', 'monopress'),
			'subtitle' => __('Show or hide the footer copyright symbol', 'monopress'),
			'default' => 0,
			'on' => 'Enabled',
			'off' => 'Disabled',
		),
		array(
			'required' => array('subfooter-on', '=', '1'),
			'id' => 'subfooter-menu',
			'type' => 'select',
			'data' => 'menu_location',
			'title' => __('Footer menu', 'monopress'),
			'subtitle' => __('Select a menu for the sub footer', 'monopress'),
		),
	),
));

//// -> START Portfolio settings
//Redux::setSection($opt_name, array(
//    'title' => __('Portfolio', 'monopress'),
//    'id' => 'Portfolio',
//    'desc' => __('', 'monopress'),
//    'icon' => 'el el-photo'
//    // TODO: for newest version
//));

// -> START Advertisement
Redux::setSection($opt_name, array(
	'title' => __('Advertisement', 'monopress'),
	'id' => 'ads',
	'desc' => __('', 'monopress'),
	'icon' => 'el el-usd'
));

Redux::setSection($opt_name, array(
	'title' => __('block 1', 'monopress'),
	'id' => 'block1',
	'desc' => __('Custom advertise block 1', 'monopress'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'ads-block1',
			'type' => 'ace_editor',
			'full_width' => true,
			'title' => __('Your ad code', 'monopress'),
			'subtitle' => __('Paste your ad code here.', 'monopress'),
			'mode' => 'plain_text',
			'theme' => 'chrome',
			'desc' => '',
			'default' => ""
		),
	)
));

Redux::setSection($opt_name, array(
	'title' => __('block 2', 'monopress'),
	'id' => 'block2',
	'desc' => __('Custom advertise block 2', 'monopress'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'ads-block2',
			'type' => 'ace_editor',
			'full_width' => true,
			'title' => __('Your ad code', 'monopress'),
			'subtitle' => __('Paste your ad code here.', 'monopress'),
			'mode' => 'plain_text',
			'theme' => 'chrome',
			'desc' => '',
			'default' => ""
		),
	)
));

Redux::setSection($opt_name, array(
	'title' => __('block 3', 'monopress'),
	'id' => 'block3',
	'desc' => __('Custom advertise block 3', 'monopress'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'ads-block3',
			'type' => 'ace_editor',
			'full_width' => true,
			'title' => __('Your ad code', 'monopress'),
			'subtitle' => __('Paste your ad code here.', 'monopress'),
			'mode' => 'plain_text',
			'theme' => 'chrome',
			'desc' => '',
			'default' => ""
		),
	)
));

Redux::setSection($opt_name, array(
	'title' => __('block 4', 'monopress'),
	'id' => 'block4',
	'desc' => __('Custom advertise block 4', 'monopress'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'ads-block4',
			'type' => 'ace_editor',
			'full_width' => true,
			'title' => __('Your ad code', 'monopress'),
			'subtitle' => __('Paste your ad code here.', 'monopress'),
			'mode' => 'plain_text',
			'theme' => 'chrome',
			'desc' => '',
			'default' => ""
		),
	)
));


// -> START Layouts settings
Redux::setSection($opt_name, array(
	'title' => __('Layouts settings', 'monopress'),
	'id' => 'layouts-settings',
	'desc' => __('', 'monopress'),
	'icon' => 'el el-align-justify'
));

Redux::setSection($opt_name, array(
	'title' => __('Template settings', 'monopress'),
	'id' => 'template-settings',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'template-settings-preloader',
			'type' => 'section',
			'title' => __('Preloader', 'monopress'),
			'subtitle' => __('From here you can configure show or hide preloader. For color customization go to Miscellaneous > Theme colors > Preloader', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'template-settings-preloader-show',
			'type' => 'switch',
			'title' => __('Show preloader', 'monopress'),
			'subtitle' => __('Show or hide the preloader.', 'monopress'),
			'default' => true,
		),
		array(
			'id' => 'template-settings-breadcrumbs',
			'type' => 'section',
			'title' => __('Breadcrumbs', 'monopress'),
			'subtitle' => __('From here you can customize the breadcrumbs that appear on your site. The breadcrumbs are a very useful navigation element that looks like this \'Home > My category > My article title\'. Since the breadcrumbs are so important for humans and search engines crawlers, Newspaper comes with extensive configuration options for them.', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'template-settings-breadcrumbs-show',
			'type' => 'switch',
			'title' => __('Show breadcrumbs', 'monopress'),
			'subtitle' => __('Enable or disable the breadcrumbs.', 'monopress'),
			'default' => true,
		),
		array(
			'id' => 'template-settings-breadcrumbs-sep',
			'type' => 'text',
			'title' => __('Separator symbol', 'monopress'),
			'subtitle' => __('Set the breadcrumbs separator.', 'monopress'),
			'default' => ' > ',
		),
		array(
			'id' => 'template-settings-breadcrumbs-home',
			'type' => 'switch',
			'title' => __('Show breadcrumbs home link', 'monopress'),
			'subtitle' => __('Show or hide the home link in breadcrumbs.', 'monopress'),
			'default' => true,
		),
		array(
			'id' => 'template-settings-breadcrumbs-parent',
			'type' => 'switch',
			'title' => __('Show parent category', 'monopress'),
			'subtitle' => __('Show or hide the parent category link ex: Home > parent category > category.', 'monopress'),
			'default' => true,
		),
		array(
			'id' => 'template-settings-breadcrumbs-title',
			'type' => 'switch',
			'title' => __('Show article title', 'monopress'),
			'subtitle' => __('Show or hide the article title on post pages.', 'monopress'),
			'default' => true,
		),

//		array(
//			'id' => 'woocommerce-template',
//			'type' => 'section',
//			'title' => __('WooCommerce template', 'monopress'),
//			'subtitle' => __('Set the sidebar and position for the WooCommerce pages.', 'monopress'),
//			'indent' => true, // Indent all options below until the next 'section' option is set.
//		),
//		array(
//			'id' => 'woocommerce-template-sidebar',
//			'type' => 'image_select',
//			'title' => __('Shop homepage + archives', 'monopress'),
//			'subtitle' => __('Sidebar position and custom sidebar.', 'monopress'),
//			'options' => array(
//				'1' => array(
//					'alt' => '1 Column',
//					'img' => ReduxFramework::$_url . 'assets/img/1col.png'
//				),
//				'2' => array(
//					'alt' => '2 Column Left',
//					'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
//				),
//				'3' => array(
//					'alt' => '2 Column Right',
//					'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
//				),
//			),
//			'default' => '2'
//		),
//		array(
//			'id' => 'woocommerce-product-sidebar',
//			'type' => 'image_select',
//			'title' => __('Shop single product page', 'monopress'),
//			'subtitle' => __('Sidebar position and custom sidebar.', 'monopress'),
//			'options' => array(
//				'1' => array(
//					'alt' => '1 Column',
//					'img' => ReduxFramework::$_url . 'assets/img/1col.png'
//				),
//				'2' => array(
//					'alt' => '2 Column Left',
//					'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
//				),
//				'3' => array(
//					'alt' => '2 Column Right',
//					'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
//				),
//			),
//			'default' => '2'
//		),
//	TODO: for the newest version
	),
));


Redux::setSection($opt_name, array(
	'title' => __('Page template', 'monopress'),
	'id' => 'page-template-title',
	'desc' => __('Set the default layout for page template.', 'monopress'),
	'subsection' => true,
	'fields' => array(

		array(
			'id' => 'page-template-sidebar',
			'type' => 'image_select',
			'title' => __('Sidebar position', 'monopress'),
			'subtitle' => __('Sidebar position and custom sidebars.', 'monopress'),
			'options' => array(
				'sidebar_1' => array(
					'alt' => 'No sidebar',
					'img' => get_template_directory_uri() . '/images/admin/layout-no-sidebar.png'

				),
				'sidebar_2' => array(
					'alt' => 'Left sidebar',
					'img' => get_template_directory_uri() . '/images/admin/layout-left-sidebar.png'
				),
				'sidebar_3' => array(
					'alt' => 'Right sidebar',
					'img' => get_template_directory_uri() . '/images/admin/layout-right-sidebar.png'
				),
			),
			'default' => '2'
		),
		array(
			'id' => 'page-template-comments',
			'type' => 'switch',
			'title' => __('Disable comments on pages', 'monopress'),
			'subtitle' => __('Enable or disable the comments on pages, on the entire site. This option is disabled by default', 'monopress'),
			'default' => false,
		),
	)
));

Redux::setSection($opt_name, array(
	'title' => __('Categories template', 'monopress'),
	'id' => 'categories-template',
	'desc' => __('Set the default layout for all the categories.', 'monopress'),
	'subsection' => true,
	'fields' => array(
//        array(
//            'id' => 'category-template',
//            'type' => 'switch',
//            'title' => __('Category template', 'monopress'),
//            'subtitle' => __('This is the header of the category'),
//            'default' => true,
//            // TODO: for newest version
//        ),
//        array(
//            'id' => 'category-template-filter',
//            'type' => 'switch',
//            'title' => __('Category pull-down filter', 'monopress'),
//            'subtitle' => __('This setting controls the display of the category pull-down filter.'),
//            'default' => true,
//            // TODO: for newest version
//        ),
//        array(
//            'id' => 'category-template-top-style',
//            'type' => 'switch',
//            'title' => __('Category top posts style', 'monopress'),
//            'subtitle' => __('Set top post style.'),
//            'default' => true,
//            // TODO: for newest version
//        ),
//        array(
//            'id' => 'category-template-top-grid-style',
//            'type' => 'switch',
//            'title' => __('Category top posts grid style', 'monopress'),
//            'subtitle' => __('Each category grid supports multiple styles.'),
//            'default' => true,
//            // TODO: for newest version
//        ),
//		array(
//			'id' => 'category-template-author',
//			'type' => 'switch',
//			'title' => __('Show or hide author name and link.', 'monopress'),
//			'subtitle' => __('Show or hide author on post listings.', 'monopress'),
//			'default' => true,
//			'on' => 'Show',
//			'off' => 'Hide',
//		),
//		array(
//			'id' => 'category-template-date',
//			'type' => 'switch',
//			'title' => __('Show or hide date.', 'monopress'),
//			'subtitle' => __('Show or hide date on post listings.', 'monopress'),
//			'default' => true,
//			'on' => 'Show',
//			'off' => 'Hide',
//		),
		array(
			'id' => 'category-article-display',
			'type' => 'image_select',
			'title' => __('Article display view', 'monopress'),
			'subtitle' => __('Select a module type, this is how your article list will be displayed.', 'monopress'),
			'options' => array(
				'layout_2' => array(
					'alt' => '2',
					'img' => get_template_directory_uri() . '/images/admin/post-layout-02.png'
				),
				'layout_4' => array(
					'alt' => '4',
					'img' => get_template_directory_uri() . '/images/admin/post-layout-04.png'
				),
				'layout_5' => array(
					'alt' => '5',
					'img' => get_template_directory_uri() . '/images/admin/post-layout-05.png'
				),
				'layout_7' => array(
					'alt' => '7',
					'img' => get_template_directory_uri() . '/images/admin/post-layout-07.png'
				),
				'layout_14' => array(
					'alt' => '14',
					'img' => get_template_directory_uri() . '/images/admin/post-layout-14.png'
				),
				'layout_21' => array(
					'alt' => '21',
					'img' => get_template_directory_uri() . '/images/admin/post-layout-21.png'
				),
			),
			'default' => '2',
		),
		array(
			'id' => 'category-pagination',
			'type' => 'select',
			'title' => __('Pagination style', 'monopress'),
			'subtitle' => __('Set a pagination style for all categories.', 'monopress'),
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
			'title' => __('Sidebar position', 'monopress'),
			'subtitle' => __('Sidebar position and custom sidebars.', 'monopress'),
			'options' => array(
				'sidebar_1' => array(
					'alt' => 'No sidebar',
					'img' => get_template_directory_uri() . '/images/admin/layout-no-sidebar.png'

				),
				'sidebar_2' => array(
					'alt' => 'Left sidebar',
					'img' => get_template_directory_uri() . '/images/admin/layout-left-sidebar.png'
				),
				'sidebar_3' => array(
					'alt' => 'Right sidebar',
					'img' => get_template_directory_uri() . '/images/admin/layout-right-sidebar.png'
				),
			),
			'default' => '2'
		),
		array(
			'id' => 'block-settings-meta-title',
			'type' => 'section',
			'title' => __('Meta info on Modules/Blocks', 'monopress'),
			'subtitle' => __('You can overwrite the template on each block and widget.', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'block-settings-meta-author',
			'type' => 'switch',
			'title' => __('Show author name', 'monopress'),
			'subtitle' => __('Enable or disable the author name (on blocks and modules)', 'monopress'),
			'default' => false,
		),
		array(
			'id' => 'block-settings-meta-date',
			'type' => 'switch',
			'title' => __('Show date', 'monopress'),
			'subtitle' => __('Enable or disable the post date (on blocks and modules)', 'monopress'),
			'default' => false,
		),
		array(
			'id' => 'block-settings-meta-comments',
			'type' => 'switch',
			'title' => __('Show comment count', 'monopress'),
			'subtitle' => __('Enable or disable comment number (on blocks and modules)', 'monopress'),
			'default' => false,
		),
	)
));

Redux::setSection($opt_name, array(
	'title' => __('Post template', 'monopress'),
	'id' => 'post-settings',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'post-and-custom-post',
			'type' => 'section',
			'title' => __('Post and Custom Post Types', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'post-show-categories',
			'type' => 'switch',
			'title' => __('Show categories tags', 'monopress'),
			'subtitle' => __('Enable or disable the categories tags (on single posts and custom post types)', 'monopress'),
			'default' => true,
		),
//        array(
//            'id' => 'post-categories-tags-order',
//            'type' => 'switch',
//            'title' => __('Category tags display order', 'monopress'),
//            'subtitle' => __('Set the post category tags display order.'),
//            'default' => false,
//    // TODO: for newest version
//        ),
		array(
			'id' => 'post-show-author-name',
			'type' => 'switch',
			'title' => __('Show author name', 'monopress'),
			'subtitle' => __('Enable or disable the author name (on single post page)', 'monopress'),
			'default' => true,
		),
		array(
			'id' => 'post-show-date',
			'type' => 'switch',
			'title' => __('Show date', 'monopress'),
			'subtitle' => __('Enable or disable the post date (on single post page)', 'monopress'),
			'default' => true,
		),
//		array(
//			'id' => 'post-show-views',
//			'type' => 'switch',
//			'title' => __('Show post views', 'monopress'),
//			'subtitle' => __('Enable or disable the post views (on single post page)', 'monopress'),
//			'default' => false,
//		),
//		// TODO: for newest version
		array(
			'id' => 'post-show-comments-numbers',
			'type' => 'switch',
			'title' => __('Show comment count', 'monopress'),
			'subtitle' => __('Enable or disable comment number (on single post page)', 'monopress'),
			'default' => false,
		),
		array(
			'id' => 'block-show-tags',
			'type' => 'switch',
			'title' => __('Show tags', 'monopress'),
			'subtitle' => __('Enable or disable the post tags (bottom of single post pages and CPT)', 'monopress'),
			'default' => true,
		),
		array(
			'id' => 'block-show-next-previous',
			'type' => 'switch',
			'title' => __('Show next and previous posts', 'monopress'),
			'subtitle' => __('Show or hide `next` and `previous` posts (bottom of single post pages)', 'monopress'),
			'default' => true,
		),
		array(
			'id' => 'block-show-author-box',
			'type' => 'switch',
			'title' => __('Show author box', 'monopress'),
			'subtitle' => __('Enable or disable the author box (bottom of single post pages)', 'monopress'),
			'default' => true,
		),
		array(
			'id' => 'block-show-comments',
			'type' => 'switch',
			'title' => __('Enable comments on posts', 'monopress'),
			'subtitle' => __('Enable or disable the posts\' comments, for the entire site.', 'monopress'),
			'default' => true,
		),
//		array(
//			'id' => 'block-show-general-modal',
//			'type' => 'switch',
//			'title' => __('General modal image', 'monopress'),
//			'subtitle' => __('<p>Enable or disable general modal image viewer over all post images, so you won\'t have to go on each post to set them individually.</p><p>Consider that disabling this feature, the individual settings of an image post are applied.</p>', 'monopress'),
//			'default' => false,
//			// TODO: for newest version
//		),
		array(
			'id' => 'post-template-title',
			'type' => 'section',
			'title' => __('Default post template (site wide)', 'monopress'),
			'subtitle' => __('This template will be applied to the whole site. The theme will also try to adjust the default widgets to look in the same style with the block template selected here.', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'post-template-default',
			'type' => 'image_select',
			'title' => __('Default site post template', 'monopress'),
			'subtitle' => __('Setting this option will make all post pages, that don\'t have a post template set, to be displayed using this template. You can overwrite this setting on a per post basis.', 'monopress'),
//            'desc' => __('This uses some of the built in images, you can use them for layout options.', 'monopress'),
			//Must provide key => value(array:title|img) pairs for radio options
			'options' => array(
				'layout_1' => array(
					'alt' => '1 Column',
					'img' => get_template_directory_uri() . '/images/admin/layout-single-post-1.png'
				),
				'layout_2' => array(
					'alt' => '2 Column Left',
					'img' => get_template_directory_uri() . '/images/admin/layout-single-post-2.png'
				),
				'layout_3' => array(
					'alt' => '2 Column Right',
					'img' => get_template_directory_uri() . '/images/admin/layout-single-post-3.png'
				),
				'default' => '3',
// Todo: set the layouts for default site post template
			),
			'default' => '1',
		),
		array(
			'id' => 'post-featured-images-title',
			'type' => 'section',
			'title' => __('Featured images', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'post-featured-images-show',
			'type' => 'switch',
			'title' => __('Show featured image', 'monopress'),
			'subtitle' => __('Show or hide featured image. Also when a post doesn\'t have a featured image set, the theme will load a placeholder image.', 'monopress'),
			'default' => false,
		),
//		array(
//			'id' => 'post-featured-images-placeholder',
//			'type' => 'switch',
//			'title' => __('Featured image placeholder', 'monopress'),
//			'subtitle' => __('When a post doesn\'t have a featured image set, the theme will load a placeholder image.', 'monopress'),
//			'default' => false,
//			// TODO: for newest version
//		),
//		array(
//			'id' => 'post-featured-images-lightbox',
//			'type' => 'switch',
//			'title' => __('Featured image lightbox', 'monopress'),
//			'subtitle' => __('What to do when the featured image is clicked inside a post. (on single post page).', 'monopress'),
//			'default' => false,
//			// TODO: for newest version
//		),
		array(
			'id' => 'post-related-title',
			'type' => 'section',
			'title' => __('Related article', 'monopress'),
			'subtitle' => __('On each single post, the theme shows three or five similar posts in the related articles section.', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'post-related-show',
			'type' => 'switch',
			'title' => __('Show related article', 'monopress'),
			'subtitle' => __('Enable or disable the related article section.', 'monopress'),
			'default' => true,
		),
		array(
			'id' => 'post-sharing-title',
			'type' => 'section',
			'title' => __('Sharing', 'monopress'),
			'subtitle' => __('All the articles of Monopress have sharing buttons at the start of the article (usually under the title) and at the end of the article (after tags). You can sort the social networks with drag and drop.', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'post-sharing-top',
			'type' => 'switch',
			'title' => __('Top article sharing', 'monopress'),
			'subtitle' => __('Show or hide the top article sharing on single post.', 'monopress'),
			'default' => true,
		),
//		array(
//			'id' => 'post-sharing-top-like',
//			'type' => 'switch',
//			'title' => __('Top article like', 'monopress'),
//			'subtitle' => __('Show or hide the top article like on single post.', 'monopress'),
//			'default' => true,
//			// TODO: for newest version
//		),
//		array(
//			'id' => 'post-sharing-top-text',
//			'type' => 'switch',
//			'title' => __('Top article share text', 'monopress'),
//			'subtitle' => __('Show or hide the top article share text on single post.', 'monopress'),
//			'default' => true,
//			// TODO: for newest version
//		),
//        array(
//            'id' => 'post-sharing-top-style',
//            'type' => 'switch',
//            'title' => __('Top share buttons style', 'monopress'),
//            'subtitle' => __('Change the appearance of the top sharing buttons.', 'monopress'),
//            'default' => false,
//            // TODO: for newest version
//        ),
		array(
			'id' => 'post-sharing-bottom',
			'type' => 'switch',
			'title' => __('Bottom article sharing', 'monopress'),
			'subtitle' => __('Show or hide the bottom article sharing on post.', 'monopress'),
			'default' => true,
		),
		array(
			'id' => 'post-sidebar-title',
			'type' => 'section',
			'title' => __('Sidebar', 'monopress'),
			'subtitle' => __('Select the single post sidebar position.', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'post-sidebar',
			'type' => 'image_select',
			'title' => __('Sidebar position', 'monopress'),
			'subtitle' => __('Sidebar position and custom sidebars.', 'monopress'),
			'options' => array(
				'sidebar_1' => array(
					'alt' => 'No sidebar',
					'img' => get_template_directory_uri() . '/images/admin/layout-no-sidebar.png'

				),
				'sidebar_2' => array(
					'alt' => 'Left sidebar',
					'img' => get_template_directory_uri() . '/images/admin/layout-left-sidebar.png'
				),
				'sidebar_3' => array(
					'alt' => 'Right sidebar',
					'img' => get_template_directory_uri() . '/images/admin/layout-right-sidebar.png'
				),
			),
			'default' => '2'
		),
//		array(
//			'id' => 'post-sharing-bottom-like',
//			'type' => 'switch',
//			'title' => __('Bottom article like', 'monopress'),
//			'subtitle' => __('Show or hide the bottom article like on post.', 'monopress'),
//			'default' => true,
//			// TODO: for newest version
//		),
//		array(
//			'id' => 'post-sharing-bottom-text',
//			'type' => 'switch',
//			'title' => __('Bottom article share text', 'monopress'),
//			'subtitle' => __('Change the appearance of the bottom sharing buttons.', 'monopress'),
//			'default' => true,
//			// TODO: for newest version
//		),
//        array(
//            'id' => 'post-sharing-bottom-style',
//            'type' => 'switch',
//            'title' => __('Bottom share buttons style', 'monopress'),
//            'subtitle' => __('Change the appearance of the bottom sharing buttons.', 'monopress'),
//            'default' => false,
//            // TODO: for newest version
//        ),
//        array(
//            'id' => 'post-sharing-twitter-username',
//            'type' => 'switch',
//            'title' => __('Twitter username', 'monopress'),
//            'subtitle' => __('<p>This will be used in the tweet for the via parameter. The site name will be used if no twitter username is provided. </p><p>Do not include the @</p>', 'monopress'),
//            'default' => false,
//            // TODO: for newest version
//        ),
//        array(
//            'id' => 'post-sharing-socials',
//            'type' => 'switch',
//            'title' => __('Social networks', 'monopress'),
//            'subtitle' => __('Select active social share links and sort them with drag and drop:', 'monopress'),
//            'default' => false,
//            // TODO: for newest version
//        ),
	)
));

Redux::setSection($opt_name, array(
	'title' => __('Portfolio template', 'monopress'),
	'id' => 'portfoilo',
//    'desc' => __('Default portfolio template ', 'monopress'),
	'subtitle' => __('.', 'monopress'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'portfolio-template-default',
			'type' => 'image_select',
			'title' => __('Default portfolio template', 'monopress'),
			'subtitle' => __('This template will be applied to the portfolio whole site.', 'monopress'),
			'options' => array(
				'layout_1' => array(
					'alt' => 'Masonry',
					'img' => get_template_directory_uri() . '/images/admin/layout-portfolio-masonry.png'
				),
				'layout_2' => array(
					'alt' => 'Grid',
					'img' => get_template_directory_uri() . '/images/admin/layout-portfolio-grid.png'
				),
// Todo: set the layouts for default site post template
			),
			'default' => '1',
		),
		array(
			'id' => 'portfolio-sharing-top',
			'type' => 'switch',
			'title' => __('Top portfolio sharing', 'monopress'),
			'subtitle' => __('Show or hide the top content sharing on portfolio page.', 'monopress'),
			'default' => true,
		),
		array(
			'id' => 'portfolio-sharing-bottom',
			'type' => 'switch',
			'title' => __('Bottom portfolio sharing', 'monopress'),
			'subtitle' => __('Show or hide the bottom content sharing on portfolio page.', 'monopress'),
			'default' => true,
		),
		array(
			'id' => 'portfolio-show-content',
			'type' => 'switch',
			'title' => __('Show page title and text content', 'monopress'),
			'subtitle' => __('Enable or disable title and text content on portfolio page.', 'monopress'),
			'default' => true,
		),
		array(
			'id' => 'portfolio-show-filter',
			'type' => 'switch',
			'title' => __('Show filter', 'monopress'),
			'subtitle' => __('Enable or disable filter in portfolio page.', 'monopress'),
			'default' => true,
		),
		array(
			'id' => 'portfolio-show-title',
			'type' => 'switch',
			'title' => __('Show item title', 'monopress'),
			'subtitle' => __('Show or hide portfolio item title.', 'monopress'),
			'default' => false,
		),
		array(
			'id' => 'portfolio-show-plus',
			'type' => 'switch',
			'title' => __('Show plus icon on hover', 'monopress'),
			'subtitle' => __('Show or hide plus icon on hover.', 'monopress'),
			'default' => true,
		),
		array(
			'id' => 'portfolio-show-modal',
			'type' => 'switch',
			'title' => __('Enable modal image', 'monopress'),
			'subtitle' => __('Open portfolio item link in modal window.', 'monopress'),
			'default' => true,
		),
		array(
			'id' => 'portfolio-sidebar',
			'type' => 'image_select',
			'title' => __('Sidebar position', 'monopress'),
			'subtitle' => __('Sidebar position and custom sidebars.', 'monopress'),
			'options' => array(
				'sidebar_1' => array(
					'alt' => 'No sidebar',
					'img' => get_template_directory_uri() . '/images/admin/layout-no-sidebar.png'

				),
				'sidebar_2' => array(
					'alt' => 'Left sidebar',
					'img' => get_template_directory_uri() . '/images/admin/layout-left-sidebar.png'
				),
				'sidebar_3' => array(
					'alt' => 'Right sidebar',
					'img' => get_template_directory_uri() . '/images/admin/layout-right-sidebar.png'
				),
			),
			'default' => '2'
		),
	)
));

// -> START Miscellaneous
Redux::setSection($opt_name, array(
	'title' => __('Miscellaneous', 'monopress'),
	'id' => 'miscellaneous',
	'desc' => __('', 'monopress'),
	'icon' => 'el el-cog'
));

Redux::setSection($opt_name, array(
	'title' => __('Background', 'monopress'),
	'id' => 'background',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'background-theme',
			'type' => 'background',
//            'output' => array('body'),
			'title' => __('Theme background', 'monopress'),
			'background-color' => 'false',
			'output' => '.up-container',
		),
		array(
			'id' => 'background-search',
			'type' => 'background',
//            'output' => array('body'),
			'title' => __('Search panel background', 'monopress'),
			'background-color' => 'false',
			'output' => '.usernav__search-search--open',
		),
		array(
			'id' => 'background-flip',
			'type' => 'background',
			'title' => __('Flip panel background', 'monopress'),
			'background-color' => 'false',
			'output' => '.flip-block--open',
		),

		array(
			'id' => 'background-portfolio',
			'type' => 'background',
			'title' => __('Portfolio background', 'monopress'),
			'background-color' => 'false',
			'output' => '.container--portfolio, .container--portfolio-03, .container--portfolio-02'
		),

		array(
			'id' => 'background-404',
			'type' => 'background',
			'title' => __('404 page background', 'monopress'),
			'background-color' => 'false',
			'output' => '.error-404 .post-block-06__item'
		),

	),
));


Redux::setSection($opt_name, array(
	'title' => __('Theme colors', 'monopress'),
	'id' => 'theme-color',
//    'desc' => __('For full documentation on this field, visit: ', 'monopress') . '<a href="//docs.reduxframework.com/core/fields/slides/" target="_blank">docs.reduxframework.com/core/fields/slides/</a>',
	'subsection' => true,
	'fields' => array(

//      General colors

		array(
			'id' => 'colors-general-title',
			'type' => 'section',
			'title' => __('General theme colors', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'colors-general-accent',
			'type' => 'color',
			'title' => __('Theme accent color', 'monopress'),
			'subtitle' => __('Select theme accent color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => 'body b,body strong, .content, .entry-content b, .entry-content strong, .entry-title span, .entry-title b, .entry-title strong',
				'--active-word' => ':root',
			),
		),


		array(
			'id' => 'colors-general-bg',
			'type' => 'color',
			'title' => __('Background color', 'monopress'),
			'subtitle' => __('Select theme background color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => 'body',
				'--main-background' => ':root',
			),


		),

		array(
			'id' => 'colors-general-headers',
			'type' => 'color',
			'title' => __('Headers text color', 'monopress'),
			'subtitle' => __('Select a global header text color', 'monopress'),
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
			'title' => __('Preloader', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'colors-preloader-bg',
			'type' => 'color_rgba',
			'title' => __('Preloader background color', 'monopress'),
			'subtitle' => __('Select preloader background color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.loading-spinner'
			),
		),
		array(
			'id' => 'colors-preloader',
			'type' => 'color_rgba',
			'title' => __('Preloader color', 'monopress'),
			'subtitle' => __('Select preloader color', 'monopress'),
			'default' => false,
			'output' => array(
				'background-color' => '.loading-spinner__item .loading-spinner__item-cube:before'
			),
		),

//      Header

		array(
			'id' => 'colors-header-title',
			'type' => 'section',
			'title' => __('Header', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.

		),
		array(
			'id' => 'colors-header-bg',
			'type' => 'color',
			'title' => __('Header background color', 'monopress'),
			'subtitle' => __('Select header background color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.page-header, .vertical-main-sidebar__left',
				'--header-background' => ':root'
			),
		),

		array(
			'id' => 'colors-header-text',
			'type' => 'color',
			'title' => __('Header text color', 'monopress'),
			'subtitle' => __('Select header text color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.page-header',
				'--header-text-color' => ':root',
				'--sidebar-text-color' => ':root',
			),
		),
		array(
			'id' => 'colors-header-b',
			'type' => 'color',
			'title' => __('Header accent text color', 'monopress'),
			'subtitle' => __('Select header accent text color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.page-header b, .vertical-main-sidebar b'
			),
		),
		array(
			'id' => 'colors-header-logo',
			'type' => 'color',
			'title' => __('Text logo color', 'monopress'),
			'subtitle' => __('Select text logo color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.main-nav__logo, .main-nav__logo:hover, .vertical-main-sidebar__logo, .vertical-main-sidebar__logo:hover'
			),
		),
		array(
			'id' => 'colors-menu-bg',
			'type' => 'color',
			'title' => __('Menu background color', 'monopress'),
			'subtitle' => __('Select menu background color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.header-menu, .main-nav-vertical'
			),
		),
		array(
			'id' => 'colors-menu-hover',
			'type' => 'color',
			'title' => __('Menu active & hover color', 'monopress'),
			'subtitle' => __('Select the active and hover color for menu and submenu', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => '.header-menu .menu-item a:hover, .header-menu .menu-item a:focus, .header-menu .menu-item a:active, .main-nav-vertical .menu-item a:hover, .main-nav-vertical .menu-item a:focus, .main-nav-vertical .menu-item a:active',
		),
		array(
			'id' => 'colors-menu-txt',
			'type' => 'color',
			'title' => __('Menu links color', 'monopress'),
			'subtitle' => __('Select menu text color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.header-menu .menu-item a, .main-nav-vertical .menu-item a',
				'background-color' => '.header-menu .menu-item a::before, .main-nav-vertical .menu-item a::before',
			),
		),
		array(
			'id' => 'colors-menu-accent-txt',
			'type' => 'color',
			'title' => __('Menu accent text color', 'monopress'),
			'subtitle' => __('Select menu accent text color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => '.header-menu .menu-item > a >strong, .main-nav-vertical .menu-item > a >strong',
		),

//      Header -> Submenu

		array(
			'id' => 'colors-submenu-bg',
			'type' => 'color_rgba',
			'title' => __('Sub-menu background color', 'monopress'),
			'subtitle' => __('Select sub-menu background color', 'monopress'),

			// These options display a fully functional color palette.  Omit this argument
			// for the minimal color picker, and change as desired.
			'options'       => array(
				'show_input'                => true,
				'show_initial'              => true,
				'show_alpha'                => true,
				'show_palette'              => true,
				'show_palette_only'         => false,
				'show_selection_palette'    => true,
				'max_palette_size'          => 10,
				'allow_empty'               => true,
				'clickout_fires_change'     => false,
				'choose_text'               => 'Choose',
				'cancel_text'               => 'Cancel',
				'show_buttons'              => true,
				'use_extended_classes'      => true,
				'palette'                   => null,  // show default
				'input_text'                => 'Select Color'
			),
			'output' => array(
				'background-color' => '.header-menu .sub-menu, .header-menu .sub-menu,  .main-nav-vertical .sub-menu, .menu-item-has-children:hover .sub-menu',
			),
		),
		array(
			'id' => 'colors-submenu-color',
			'type' => 'color',
			'title' => __('Sub-menu text color', 'monopress'),
			'subtitle' => __('Select sub-menu text color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.header-menu .sub-menu a, .main-nav-vertical .sub-menu a',
				'background-color' => '.header-menu .sub-menu a::before, .main-nav-vertical .sub-menu a::before',
			),
		),
		array(
			'id' => 'colors-submenu-hover-bg',
			'type' => 'color',
			'title' => __('Sub-menu active & hover background', 'monopress'),
			'subtitle' => __('Active and hover background color for sub-menus', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.header-menu .sub-menu a:hover, .header-menu .sub-menu a:focus,.header-menu .sub-menu a:active, .main-nav-vertical .sub-menu a:hover, .main-nav-vertical .sub-menu a:focus,.main-nav-vertical .sub-menu a:active',
			),
		),
		array(
			'id' => 'colors-submenu-hover-color',
			'type' => 'color',
			'title' => __('Sub-menu active & hover text color', 'monopress'),
			'subtitle' => __('Active and hover text color for sub-menus', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.header-menu .sub-menu a:hover, .header-menu .sub-menu a:focus, .header-menu .sub-menu a:active, .main-nav-vertical .sub-menu a:hover, .main-nav-vertical .sub-menu a:focus, .main-nav-vertical .sub-menu a:active',
				'background-color' => '.header-menu .sub-menu a:hover::before, .main-nav-vertical .sub-menu a:hover::before',
			),
		),

//      Header -> icons

		array(
			'id' => 'colors-menu-icons',
			'type' => 'color',
			'title' => __('Menu icons color', 'monopress'),
			'subtitle' => __('Select menu icons color', 'monopress'),
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
			'title' => __('Menu icons hover color', 'monopress'),
			'subtitle' => __('Select menu icons hover color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.usernav button:hover',
//				'background-color' => '.sub-menu a:hover::before',
				'--header-icon-color-hover' => ':root'
			),
		),

//      Sidebar

		array(
			'id' => 'colors-sidebar-title',
			'type' => 'section',
			'title' => __('Sidebar', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'colors-sidebar-titles-bg',
			'type' => 'color',
			'title' => __('Sidebar titles border color', 'monopress'),
			'subtitle' => __('Select sidebar titles background color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.sidebar .widget-title::before, .sidebar .widget-title::after',
				'border-bottom-color' => '.sidebar .widget-title',
			),
		),

		array(
			'id' => 'colors-sidebar-titles',
			'type' => 'color',
			'title' => __('Sidebar titles color', 'monopress'),
			'subtitle' => __('Select sidebar titles color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.sidebar .widget-title',
			),
		),
		array(
			'id' => 'colors-sidebar-bg',
			'type' => 'color',
			'title' => __('Sidebar background color', 'monopress'),
			'subtitle' => __('Select sidebar background color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.post-widget, .post-widget .sidebar__inner',
			),
		),
		array(
			'id' => 'colors-sidebar-color',
			'type' => 'color',
			'title' => __('Sidebar text color', 'monopress'),
			'subtitle' => __('Select sidebar text color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => '.post-widget, .post-widget .sidebar__inner',
		),
		array(
			'id' => 'colors-sidebar-links-color',
			'type' => 'color',
			'title' => __('Sidebar links color', 'monopress'),
			'subtitle' => __('Select sidebar links color', 'monopress'),
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
			'title' => __('Flip panel', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.

		),
		array(
			'id' => 'colors-flip-bg',
			'type' => 'color',
			'title' => __('Flip panel background color', 'monopress'),
			'subtitle' => __('Select flip panel background color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.flip-block ',
				'--flip-background' => ':root',
			),

		),
		array(
			'id' => 'colors-flip-color',
			'type' => 'color',
			'title' => __('Flip panel text and icons color', 'monopress'),
			'subtitle' => __('Select text and icons color for flip panel', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => '.flip-block__wrapper',
		),
		array(
			'id' => 'colors-flip-links-color',
			'type' => 'color',
			'title' => __('Flip panel button`s color', 'monopress'),
			'subtitle' => __('Select button`s color for flip panel', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => '.flip-block__wrapper a',
		),

//      Search panel

		array(
			'id' => 'colors-search-title',
			'type' => 'section',
			'title' => __('Search panel', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'colors-search-bg',
			'type' => 'color',
			'title' => __('Search panel background color', 'monopress'),
			'subtitle' => __('Select search panel background color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.usernav__search-search',
			),
		),
		array(
			'id' => 'colors-search-color',
			'type' => 'color',
			'title' => __('Search panel text and icons color', 'monopress'),
			'subtitle' => __('Select search panel text and icons color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => '.usernav__search-search.usernav__search-search--open  button, .usernav__search-input,.usernav__search-wrapper .usernav__search-input:focus, .usernav__search-input::-webkit-input-placeholder',
		),
		array(
			'id' => 'colors-search-border',
			'type' => 'color',
			'title' => __('Search panel bottom border color', 'monopress'),
			'subtitle' => __('Select search panel bottom border color', 'monopress'),
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
			'title' => __('Posts', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'colors-posts-titles',
			'type' => 'color',
			'title' => __('Post title color', 'monopress'),
			'subtitle' => __('Select post title color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => '.post h1',
		),
		array(
			'id' => 'colors-posts-author',
			'type' => 'color',
			'title' => __('Post & block author name color', 'monopress'),
			'subtitle' => __('Select author name color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => '.post .author a',
		),
		array(
			'id' => 'colors-posts-text',
			'type' => 'color',
			'title' => __('Post text color', 'monopress'),
			'subtitle' => __('Select post content color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => '.post .entry-content',
		),
		array(
			'id' => 'colors-posts-h',
			'type' => 'color',
			'title' => __('Post h1, h2, h3, h4, h5, h6 color', 'monopress'),
			'subtitle' => __('Select in post h color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => '.post h1,.post h2,.post h3,.post h4,.post h5,.post h6',
		),
		array(
			'id' => 'colors-posts-blockquote',
			'type' => 'color',
			'title' => __('Post blockquote color', 'monopress'),
			'subtitle' => __('Select in post blockquote color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => '.post blockquote',
		),

//      Pages

		array(
			'id' => 'colors-pages-title',
			'type' => 'section',
			'title' => __('Pages', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'colors-pages-titles',
			'type' => 'color',
			'title' => __('Page title color', 'monopress'),
			'subtitle' => __('Select page title color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => '.page h1',
		),
		array(
			'id' => 'colors-pages-text',
			'type' => 'color',
			'title' => __('Page text color', 'monopress'),
			'subtitle' => __('Select page text color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => '.page ',
		),
		array(
			'id' => 'colors-pages-h',
			'type' => 'color',
			'title' => __('Page h1, h2, h3, h4, h5, h6 color', 'monopress'),
			'subtitle' => __('Select page h color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => '.page h1,.page h2,.page h3,.page h4,.page h5,.page h6',
		),

//      Footer

		array(
			'id' => 'colors-footer-title',
			'type' => 'section',
			'title' => __('Footer', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'colors-footer-bg',
			'type' => 'color',
			'title' => __('Background color', 'monopress'),
			'subtitle' => __('Select footer background color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => 'footer.footer, .footer.footer-first, .footer.footer-second, .footer.footer-third',
			),
		),
		array(
			'id' => 'colors-footer-text',
			'type' => 'color',
			'title' => __('Text color', 'monopress'),
			'subtitle' => __('Select footer text color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => 'footer.footer, .footer.footer-first, .footer.footer-second, .footer.footer-third',
			),
		),
		array(
			'id' => 'colors-footer-links',
			'type' => 'color',
			'title' => __('Links color', 'monopress'),
			'subtitle' => __('Select footer links color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => 'footer.footer a, .footer.footer-first a, .footer.footer-second a, .footer.footer-third a',
				'background-color' => '.footer.footer-third .footer-widget-menu li::before, .footer.footer-third .footer-widget-menu li:hover::before',
			),
		),
		array(
			'id' => 'colors-footer-header',
			'type' => 'color',
			'title' => __('Widgets header text color', 'monopress'),
			'subtitle' => __('Select widgets header text color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => 'footer.footer h2, .footer.footer-first h2, .footer.footer-second h2, .footer.footer-third h2, footer.footer h3, .footer.footer-first h3, .footer.footer-second h3, .footer.footer-third h3',
			),
		),
		array(
			'id' => 'colors-footer-social-bg',
			'type' => 'color',
			'title' => __('Footer social icons background', 'monopress'),
			'subtitle' => __('Select social icons background', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.footer .social-listing li',
			),
		),
		array(
			'id' => 'colors-footer-social',
			'type' => 'color',
			'title' => __('Footer social icons color', 'monopress'),
			'subtitle' => __('Select social icons color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.footer .social-listing a',
			),
		),
		array(
			'id' => 'colors-footer-social-hover',
			'type' => 'color',
			'title' => __('Footer social icons hover color', 'monopress'),
			'subtitle' => __('Select social icons hover color', 'monopress'),
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
			'title' => __('Sub footer', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'colors-subfooter-bg',
			'type' => 'color',
			'title' => __('Background color', 'monopress'),
			'subtitle' => __('Select sub footer background color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.sub-footer',
			),
		),
		array(
			'id' => 'colors-subfooter-text',
			'type' => 'color',
			'title' => __('Text color', 'monopress'),
			'subtitle' => __('Select sub footer text color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.sub-footer',
			),
		),
		array(
			'id' => 'colors-subfooter-links',
			'type' => 'color',
			'title' => __('Links color', 'monopress'),
			'subtitle' => __('Select sub footer links color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.sub-footer a, footer.footer .subfooter a, .footer.footer-first .subfooter a, .footer.footer-second .subfooter a, .footer.footer-third .subfooter a',
				'background-color' => '.subfooter a::before, .sub-footer a::before',
			),
		),

//      Portfolio
		array(
			'id' => 'colors-portfolio-title',
			'type' => 'section',
			'title' => __('Portfolio', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'colors-portfolio-bg',
			'type' => 'color',
			'title' => __('Background color', 'monopress'),
			'subtitle' => __('Select portfolio background color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => 'body.portfolio, section.portfolio, .portfolio.portfolio--inverse, .portfolio__content',
			),
		),
		array(
			'id' => 'colors-portfolio-color',
			'type' => 'color',
			'title' => __('Text color', 'monopress'),
			'subtitle' => __('Select portfolio text color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'color' => '.portfolio__link, .portfolio__link .uk-h5, .portfolio--grid .portfolio__link, .portfolio--grid .portfolio__link:hover, .portfolio--masonry .portfolio__link, .portfolio--masonry .portfolio__link:hover',
			),
		),
		array(
			'id' => 'colors-portfolio-hover',
			'type' => 'color',
			'title' => __('On hover fade color', 'monopress'),
			'subtitle' => __('Select portfolio item on hover fade color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.portfolio--grid .portfolio__link:hover',
			),
		),
		array(
			'id' => 'colors-portfolio-hover-txt-bg',
			'type' => 'color',
			'title' => __('On hover title background color', 'monopress'),
			'subtitle' => __('Select portfolio item on hover title background color', 'monopress'),
			'default' => false,
			'validate' => 'color',
			'output' => array(
				'background-color' => '.portfolio .uk-overlay-default',
			),
		),


//      404
		array(
			'id' => 'colors-404-title',
			'type' => 'section',
			'title' => __('404', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => '404-background',
			'type' => 'color',
			'compiler' => true,
			'title' => esc_html__('404 background Color', 'monopress'),
			'subtitle' => __('Select 404 page background color', 'monopress'),
			'default' => '',
			'output' => array(
				'background-color' => '.error-404 .post-block-06__item',
			)
		),

	)
));


Redux::setSection($opt_name, array(
	'title' => __('Theme fonts', 'monopress'),
	'id' => 'theme-fonts',
//    'desc' => __('Font Settings ', 'monopress'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'fonts-body-title',
			'type' => 'section',
			'title' => __('Global fonts setting', 'monopress'),
			'subtitle' => __('Main theme fonts.', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'fonts-primary',
			'type' => 'typography',
			'title' => __('Primary font', 'monopress'),
			'google' => true,
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => false,
			'font-weight' => false,
			'font-size' => false,
			'line-height' => false,
			'font-style' => false,
			'subsets' => true,
			'all_styles' => true,
			'output' => array(
				'font-family' => '.promary-font, .entry-content, .comments-block__separator, .comments-block__date, .comments-block__date a,
.comments-block__text, .post-block-02__date, .post-block-04__date, .post-block-05__date, .post-block-06__text, .post-block-07__date,
.post-block-08__widget-footer, .post-block-10__text, .post-block-14__date, .post-block-15__footer, .post-block-15__text, .post-block-16__date,
.post-block-17__text, .post-block-20__date, .post-block-21__footer, .post-text-block-08__text, .post-text-block-20, .post-text-block-20__text,
.post-widget__footer, .weather-vertical__location, .footer, .footer.footer-third .footer-widget-menu li, .sub-footer, .page blockquote, .widget, .author-box-wrap .up-author-description,
.up-author-url a, .breadcrumbs, .button, .tags-single-post a, .post-navigation .nav-links  a, .flip-block .sub-menu>li>a',
				'--fonts-primary' => ':root',
			),


		),
		array(
			'id' => 'fonts-secondary',
			'type' => 'typography',
			'title' => __('Secondary font', 'monopress'),
			'google' => true,
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => false,
			'font-weight' => false,
			'font-size' => false,
			'line-height' => false,
			'font-style' => false,
			'all_styles' => true,
			'output' => array(
				'font-family' => 'h1,h2,h3,h4,h5,h6, body, .secondary-font, #cancel-comment-reply-link, .comments-block__header, .comment-reply-title, .comments-block__author a,
.comments-block__author .fn, .comments-block__author-link, .comments-block__reply a, .comments-block__reply-link, .control-09__scroll-link, .control-center__link,
.control-right__link, .control-scroll__scroll-button, .control-scroll-only__scroll-button, .post-block-02__header-link, .post-block-04__header-link,
.post-block-05__header-link, .post-block-06__header, .post-block-06__slider-info, .post-block-07__header-link, .post-block-08__widget-title,
.post-block-10__header, .post-block-10__slider-info, .post-block-12__header, .post-block-14__header-link, .post-block-15__header,
.post-block-15__header-link, .post-block-16__header-link, .post-block-17__header, .post-block-17__slider-info, .post-block-20__header,
.post-block-20__header-link, .post-block-21__header-link, .post-text-block-08__header-link, .post-text-block-08__social-link-facebook, .post-text-block-08__social-link-twitter,
.post-text-block-20__header-link, .post-text-block-20__social-link-facebook, .post-text-block-20__social-link-twitter, .post-widget__title-link,
.author-box-wrap h2, .author-box-wrap .up-author-name a, .related-articles-wrap .related-title, .vertical-main-sidebar__logo, .sidebar h2, .weather__num, 
.weather-vertical__num, .entry-content h1, .entry-content h2, .entry-content h3, .entry-content h4, .entry-content h5, .entry-content h6, .flip-block h1, 
.flip-block h2, .flip-block h3, .flip-block h4, .flip-block h5, .flip-block h6, .widget .about_widget_wrapper h3, .footer.footer-third h3, .footer.footer-third .column-4 em',
				'--fonts-secondary' => ':root',
			),

		),
		array(
			'id' => 'fonts-header-title',
			'type' => 'section',
			'title' => __('Header', 'monopress'),
			'indent' => true,
		),
		array(
			'id' => 'fonts-header-logo',
			'type' => 'typography',
			'title' => __('Text logo', 'monopress'),
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
			'title' => __('Header', 'monopress'),
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
			'title' => __('Top menu', 'monopress'),
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
			'title' => __('Top sub menu', 'monopress'),
			'google' => true,
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
			'output' => array('.header-menu .sub-menu'),
		),

		array(
			'id' => 'headers-post-title',
			'type' => 'section',
			'title' => __('Listing blocks', 'monopress'),
			'indent' => true,
		),
		array(
			'id' => 'headers-post-titles',
			'type' => 'typography',
			'title' => __('Headers', 'monopress'),
			'google' => true,
			'output' => array('.post-block-02__header a:hover, .post-block-03__widget-title a:hover, .post-block-04__header a:hover, .post-block-05__header a:hover, .post-block-07__header a:hover, .post-block-09__header a:hover, .post-block-11__header a:hover, .post-block-14__header a:hover, .post-block-18__header a:hover, .post-block-19__widget-title a:hover, .post-block-21__header a:hover, .post-block-02__header a, .post-block-03__widget-title a, .post-block-04__header a, .post-block-05__header a, .post-block-07__header a, .post-block-09__header a, .post-block-11__header a, .post-block-14__header a, .post-block-18__header a, .post-block-19__widget-title a, .post-block-21__header a, .post-block-02__item:hover .post-block-02__header-link, .post-block-03__item:hover .post-block-03__header-link, .post-block-04__item:hover .post-block-04__header-link, .post-block-05__item:hover .post-block-05__header-link, .post-block-07__item:hover .post-block-07__header-link, .post-block-09__item:hover .post-block-09__header-link, .post-block-11__item:hover .post-block-11__header-link, .post-block-14__item:hover .post-block-14__header-link, .post-block-18__item:hover .post-block-18__header-link, .post-block-19__item:hover .post-block-19__header-link, .post-block-21__item:hover .post-block-21__header-link, .post-widget__title-link'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),

		array(
			'id' => 'fonts-post-title',
			'type' => 'section',
			'title' => __('Post content', 'monopress'),
			'indent' => true,
		),
		array(
			'id' => 'fonts-post-titles',
			'type' => 'typography',
			'title' => __('Post title', 'monopress'),
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
			'title' => __('Post content', 'monopress'),
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
			'title' => __('Blockquote', 'monopress'),
			'google' => true,
			'output' => array('.post blockquote'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),

		array(
			'id' => 'fonts-post-lists',
			'type' => 'typography',
			'title' => __('Lists', 'monopress'),
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
			'title' => __('H1', 'monopress'),
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
			'title' => __('H2', 'monopress'),
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
			'title' => __('H3', 'monopress'),
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
			'title' => __('H4', 'monopress'),
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
			'title' => __('H5', 'monopress'),
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
			'title' => __('H6', 'monopress'),
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
			'title' => __('Post  elements', 'monopress'),
			'indent' => true,
		),

		array(
			'id' => 'fonts-post-elements-author',
			'type' => 'typography',
			'title' => __('Author', 'monopress'),
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
			'title' => __('Date', 'monopress'),
			'google' => true,
			'output' => array('.posted-on'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),

		array(
			'id' => 'fonts-post-elements-vst',
			'type' => 'typography',
			'title' => __('Via/source/tags', 'monopress'),
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
			'title' => __('Next/prev text', 'monopress'),
			'google' => true,
			'output' => array('.post-navigation .nav-previous, .post-navigation .nav-next'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),

		array(
			'id' => 'fonts-post-elements-box-author-name',
			'type' => 'typography',
			'title' => __('Box author name', 'monopress'),
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
			'title' => __('Box author url', 'monopress'),
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
			'title' => __('Box author description', 'monopress'),
			'google' => true,
			'output' => array('.up-author-description'),
			'text-align' => false,
			'color' => false,
			'default' => false,
			'text-transform' => true,
		),

		array(
			'id' => 'fonts-post-elements-share-text',
			'type' => 'typography',
			'title' => __('Share text', 'monopress'),
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
			'title' => __('Image caption', 'monopress'),
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
			'title' => __('Pages', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'fonts-pages-titles',
			'type' => 'typography',
			'title' => __('Page title', 'monopress'),
			'google' => true,
			'output' => array('.page h1'),
			'text-align' => false,
			'default' => false,
			'text-transform' => true,
		),

		array(
			'id' => 'fonts-pages-content',
			'type' => 'typography',
			'title' => __('Page content', 'monopress'),
			'google' => true,
			'output' => array('.page'),
			'text-align' => false,
			'default' => false,
			'text-transform' => true,
		),

		array(
			'id' => 'fonts-pages-h1',
			'type' => 'typography',
			'title' => __('H1', 'monopress'),
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
			'title' => __('H2', 'monopress'),
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
			'title' => __('H3', 'monopress'),
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
			'title' => __('H4', 'monopress'),
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
			'title' => __('H5', 'monopress'),
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
			'title' => __('H6', 'monopress'),
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
			'title' => __('Footer fonts settings', 'monopress'),
			'indent' => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id' => 'fonts-footer-text',
			'type' => 'typography',
			'title' => __('Footer text', 'monopress'),
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
			'title' => __('Footer menu', 'monopress'),
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
	'title' => __('Custom code', 'monopress'),
	'id' => 'custom-code',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'custom-code-css',
			'type' => 'ace_editor',
			'full_width' => true,
			'title' => __('CSS Code', 'monopress'),
			'subtitle' => __('Paste your CSS code here.', 'monopress'),
			'mode' => 'css',
			'theme' => 'monokai',
			'desc' => 'The css from this box will load on all the pages of the site.',
			'default' => ""
		),
		array(
			'id' => 'custom-code-js',
			'type' => 'ace_editor',
			'full_width' => true,
			'title' => __('JS Code', 'monopress'),
			'subtitle' => __('Paste your JS code here.', 'monopress'),
			'mode' => 'javascript',
			'theme' => 'chrome',
			'desc' => 'Add custom javascript easly, using this editor. Please do not include the &lt;script&gt &lt;/script&gt',
			'default' => ""
		),
	)

));

Redux::setSection($opt_name, array(
	'title' => esc_html__('Page 404', 'monopress'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => '404-heading',
			'type' => 'text',
			'title' => esc_html__('Heading text', 'monopress'),
			'default' => esc_html__('Oops! That page can&rsquo;t be found.', 'monopress'),

		),
		array(
			'id' => '404-text',
			'type' => 'editor',
			'title' => esc_html__('Content body Text', 'monopress'),
			'subtitle' => esc_html__('Custom html allow', 'monopress'),
			'args' => array(
				'teeny' => true,
			),
			'default' => esc_html__('It looks like nothing was found at this location. Maybe try the link below or a search?', 'monopress'),

		),
		array(
			'id' => '404-button-text',
			'type' => 'text',
			'title' => esc_html__('Button text', 'monopress'),
			'default' => 'Go Home',

		),
		array(
			'id' => '404-button-link',
			'type' => 'text',
			'title' => esc_html__('Button Contact link slug', 'monopress'),
			'default' => '/',
		),
	)
));

//   Social networks

Redux::setSection($opt_name, array(
	'title' => __('Social networks', 'monopress'),
	'id' => 'social-networks',
	'desc' => __('Insert a link to your account if you want to display this social network.', 'monopress'),
	'subsection' => true,
	'fields' => array(

//      Most popular socials

		array(
			'id' => 'social-twitter',
			'type' => 'text',
			'title' => __('Twitter', 'monopress'),
			'desc' => __('Link to: twitter', 'monopress'),
		),
		array(
			'id' => 'social-facebook',
			'type' => 'text',
			'title' => __('Facebook', 'monopress'),
			'desc' => __('Link to: facebook', 'monopress'),
		),
		array(
			'id' => 'social-instagram',
			'type' => 'text',
			'title' => __('Instagram', 'monopress'),
			'desc' => __('Link to: instagram', 'monopress'),
		),
		array(
			'id' => 'social-youtube',
			'type' => 'text',
			'title' => __('Youtube', 'monopress'),
			'desc' => __('Link to: youtube', 'monopress'),
		),

//      Regular

		array(
			'id' => 'social-behance',
			'type' => 'text',
			'title' => __('Behance', 'monopress'),
			'desc' => __('Link to: behance', 'monopress'),
		),

		array(
			'id' => 'social-delicious',
			'type' => 'text',
			'title' => __('Delicious', 'monopress'),
			'desc' => __('Link to: delicious', 'monopress'),
		),

		array(
			'id' => 'social-deviantart',
			'type' => 'text',
			'title' => __('Deviantart', 'monopress'),
			'desc' => __('Link to: deviantart', 'monopress'),
		),
		array(
			'id' => 'social-digg',
			'type' => 'text',
			'title' => __('Digg', 'monopress'),
			'desc' => __('Link to: digg', 'monopress'),
		),
		array(
			'id' => 'social-dribbble',
			'type' => 'text',
			'title' => __('Dribbble', 'monopress'),
			'desc' => __('Link to: dribbble', 'monopress'),
		),
		array(
			'id' => 'social-dropbox',
			'type' => 'text',
			'title' => __('Dropbox', 'monopress'),
			'desc' => __('Link to: dropbox', 'monopress'),
		),
		array(
			'id' => 'social-flickr',
			'type' => 'text',
			'title' => __('Flickr', 'monopress'),
			'desc' => __('Link to: flickr', 'monopress'),
		),
		array(
			'id' => 'social-googleplus',
			'type' => 'text',
			'title' => __('Google +', 'monopress'),
			'desc' => __('Link to: googleplus', 'monopress'),
		),
		array(
			'id' => 'social-lastfm',
			'type' => 'text',
			'title' => __('Last FM', 'monopress'),
			'desc' => __('Link to: Last FM', 'monopress'),
		),
		array(
			'id' => 'social-linkedin',
			'type' => 'text',
			'title' => __('LinkedIN', 'monopress'),
			'desc' => __('Link to: linkedin', 'monopress'),
		),
		array(
			'id' => 'social-pinterest',
			'type' => 'text',
			'title' => __('Pinterest', 'monopress'),
			'desc' => __('Link to: pinterest', 'monopress'),
		),
		array(
			'id' => 'social-rss',
			'type' => 'text',
			'title' => __('RSS', 'monopress'),
			'desc' => __('Link to: rss', 'monopress'),
		),
		array(
			'id' => 'social-tumblr',
			'type' => 'text',
			'title' => __('Tumblr', 'monopress'),
			'desc' => __('Link to: tumblr', 'monopress'),
		),
		array(
			'id' => 'social-vimeo',
			'type' => 'text',
			'title' => __('Vimeo', 'monopress'),
			'desc' => __('Link to: vimeo', 'monopress'),
		),
		array(
			'id' => 'social-wordpress',
			'type' => 'text',
			'title' => __('WordPress', 'monopress'),
			'desc' => __('Link to: wordpress', 'monopress'),
		),
		array(
			'id' => 'social-500pixels',
			'type' => 'text',
			'title' => __('500 pixels', 'monopress'),
			'desc' => __('Link to: 500 pixels', 'monopress'),
		),

		array(
			'id' => 'social-xing',
			'type' => 'text',
			'title' => __('Xing', 'monopress'),
			'desc' => __('Link to: xing', 'monopress'),
		),
		array(
			'id' => 'social-spotify',
			'type' => 'text',
			'title' => __('Spotify', 'monopress'),
			'desc' => __('Link to: spotify', 'monopress'),
		),
		array(
			'id' => 'social-houzz',
			'type' => 'text',
			'title' => __('Houzz', 'monopress'),
			'desc' => __('Link to: houzz', 'monopress'),
		),
		array(
			'id' => 'social-skype',
			'type' => 'text',
			'title' => __('Skype', 'monopress'),
			'desc' => __('Link to: skype', 'monopress'),
		),
		array(
			'id' => 'social-slideshare',
			'type' => 'text',
			'title' => __('Slideshare', 'monopress'),
			'desc' => __('Link to: slideshare', 'monopress'),
		),
		array(
			'id' => 'social-bandcamp',
			'type' => 'text',
			'title' => __('Bandcamp', 'monopress'),
			'desc' => __('Link to: bandcamp', 'monopress'),
		),
		array(
			'id' => 'social-soundcloud',
			'type' => 'text',
			'title' => __('Soundcloud', 'monopress'),
			'desc' => __('Link to: soundcloud', 'monopress'),
		),
		array(
			'id' => 'social-snapchat',
			'type' => 'text',
			'title' => __('Snapchat', 'monopress'),
			'desc' => __('Link to: snapchat', 'monopress'),
		),
		array(
			'id' => 'social-viadeo',
			'type' => 'text',
			'title' => __('Viadeo', 'monopress'),
			'desc' => __('Link to: viadeo', 'monopress'),
		),
		array(
			'id' => 'social-tripadvisor',
			'type' => 'text',
			'title' => __('TripAdvisor', 'monopress'),
			'desc' => __('Link to: tripadvisor', 'monopress'),
		),
		array(
			'id' => 'social-vk',
			'type' => 'text',
			'title' => __('VKontakte', 'monopress'),
			'desc' => __('Link to: vkontakte', 'monopress'),
		),
		array(
			'id' => 'social-ok',
			'type' => 'text',
			'title' => __('Odnoklassniki', 'monopress'),
			'desc' => __('Link to: odnoklassniki', 'monopress'),
		),
		array(
			'id' => 'social-telegram',
			'type' => 'text',
			'title' => __('Telegram', 'monopress'),
			'desc' => __('Link to: telegram', 'monopress'),
		),
	)
));

Redux::setSection($opt_name, array(
	'title' => __('Import - export', 'monopress'),
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
			'title' => __('Section via hook', 'monopress'),
			'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'monopress'),
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
