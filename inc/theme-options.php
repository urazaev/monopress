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
    'display_name' => $theme->get('Name'),
    // Name that appears at the top of your panel
    'display_version' => $theme->get('Version'),
    // Version that appears at the top of your panel
    'menu_type' => 'menu',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu' => true,
    // Show the sections below the admin menu item or not
    'menu_title' => __('Theme Options', 'bcn-theme'),
    'page_title' => __('Theme Options', 'bcn-theme'),
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
    'global_variable' => 'bcn_options',
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
    'page_priority' => null,
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
    'page_slug' => '',
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
    'href' => '#',
    'title' => __('Documentation', 'bcn-theme'),
);

$args['admin_bar_links'][] = array(
    //'id'    => 'bcn-support',
    'href' => '#',
    'title' => __('Support', 'bcn-theme'),
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
    $args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'bcn-theme'), $v);
} else {
    $args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'bcn-theme');
}

// Add content after the form.
$args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'bcn-theme');

Redux::setArgs($opt_name, $args);

/*
 * ---> END ARGUMENTS
 */


/*
 * ---> START HELP TABS
 */

$tabs = array(
    array(
        'id' => 'redux-help-tab-1',
        'title' => __('Theme Information 1', 'bcn-theme'),
        'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'bcn-theme')
    ),
    array(
        'id' => 'redux-help-tab-2',
        'title' => __('Theme Information 2', 'bcn-theme'),
        'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'bcn-theme')
    )
);
Redux::setHelpTab($opt_name, $tabs);

// Set the help sidebar
$content = __('<p>This is the sidebar content, HTML is allowed.</p>', 'bcn-theme');
Redux::setHelpSidebar($opt_name, $content);


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
// -> START Portfolio settings
Redux::setSection($opt_name, array(
    'title' => __('Dont miss Portfolio', 'bcn-theme'),
    'id' => 'Portfolio',
    'desc' => __('', 'bcn-theme'),
    'icon' => 'el el-photo'
));

Redux::setSection($opt_name, array(
    'title' => __('Layout', 'bcn-theme'),
    'id' => 'template-settings',
    'subsection' => true,
    'fields' => array(),
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/background/" target="_blank">docs.reduxframework.com/core/fields/background/</a>',
));

Redux::setSection($opt_name, array(
    'title' => __('Portfolio typography', 'bcn-theme'),
    'id' => 'categories-template',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/border/" target="_blank">docs.reduxframework.com/core/fields/border/</a>',
    'subsection' => true,
    'fields' => array()
));


// -> START Header
Redux::setSection($opt_name, array(
    'title' => __('Header', 'bcn-theme'),
    'id' => 'header',
    'desc' => __('Header options', 'bcn-theme'),
    'icon' => 'el el-adjust-alt'
));

Redux::setSection($opt_name, array(
    'title' => __('Header style', 'bcn-theme'),
    'id' => 'header-style',
    'subsection' => true,
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/checkbox/" target="_blank">docs.reduxframework.com/core/fields/checkbox/</a>',
    'fields' => array()
));

Redux::setSection($opt_name, array(
    'title' => __('Search position', 'bcn-theme'),
    'id' => 'search-position',
    'subsection' => true,
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/radio/" target="_blank">docs.reduxframework.com/core/fields/radio/</a>',
    'fields' => array()
));

Redux::setSection($opt_name, array(
    'title' => __('Top bar', 'bcn-theme'),
    'id' => 'top-bar',
    'subsection' => true,
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/sortable/" target="_blank">docs.reduxframework.com/core/fields/sortable/</a>',
    'fields' => array()
));

Redux::setSection($opt_name, array(
    'title' => __('Main menu', 'bcn-theme'),
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/text/" target="_blank">docs.reduxframework.com/core/fields/text/</a>',
    'id' => 'main-menu',
    'subsection' => true,
    'fields' => array()
));

Redux::setSection($opt_name, array(
    'title' => __('Logo + favicon ', 'bcn-theme'),
    'id' => 'logo-favicon',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/multi-text/" target="_blank">docs.reduxframework.com/core/fields/multi-text/</a>',
    'subsection' => true,
    'fields' => array()
));

Redux::setSection($opt_name, array(
    'title' => __('Logo for mobile', 'bcn-theme'),
    'id' => 'logo-for-mobile',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/password/" target="_blank">docs.reduxframework.com/core/fields/password/</a>',
    'subsection' => true,
    'fields' => array()
));

Redux::setSection($opt_name, array(
    'title' => __('Header background', 'bcn-theme'),
    'id' => 'Header-background',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/textarea/" target="_blank">docs.reduxframework.com/core/fields/textarea/</a>',
    'subsection' => true,
    'fields' => array()
));

Redux::setSection($opt_name, array(
    'title' => __('Ios bookmarklet', 'bcn-theme'),
    'id' => 'ios-bookmarklet',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/textarea/" target="_blank">docs.reduxframework.com/core/fields/textarea/</a>',
    'subsection' => true,
    'fields' => array()
));

// -> START Footer
Redux::setSection($opt_name, array(
    'title' => __('Footer', 'bcn-theme'),
    'id' => 'footer',
    'icon' => 'el el-edit',
));

Redux::setSection($opt_name, array(
    'title' => __('Footer settings', 'bcn-theme'),
    'id' => 'footer-settings',
    //'icon'  => 'el el-home'
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/editor/" target="_blank">docs.reduxframework.com/core/fields/editor/</a>',
    'subsection' => true,
    'fields' => array(),
));

Redux::setSection($opt_name, array(
    'title' => __('Instagram', 'bcn-theme'),
    'id' => 'instagram',
    'subsection' => true,
    'desc' => __('For full documentation on the this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/ace-editor/" target="_blank">docs.reduxframework.com/core/fields/ace-editor/</a>',
    'fields' => array()
));

Redux::setSection($opt_name, array(
    'title' => __('Footer content', 'bcn-theme'),
    'id' => 'footer-content',
    'subsection' => true,
    'desc' => __('For full documentation on the this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/ace-editor/" target="_blank">docs.reduxframework.com/core/fields/ace-editor/</a>',
    'fields' => array()
));

Redux::setSection($opt_name, array(
    'title' => __('Footer background', 'bcn-theme'),
    'id' => 'footer-background',
    'subsection' => true,
    'desc' => __('For full documentation on the this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/ace-editor/" target="_blank">docs.reduxframework.com/core/fields/ace-editor/</a>',
    'fields' => array()
));

Redux::setSection($opt_name, array(
    'title' => __('Sub footer settings', 'bcn-theme'),
    'id' => 'sub-footer-settings',
    'subsection' => true,
    'desc' => __('For full documentation on the this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/ace-editor/" target="_blank">docs.reduxframework.com/core/fields/ace-editor/</a>',
    'fields' => array()
));

// -> START Advertisement
Redux::setSection($opt_name, array(
    'title' => __('Advertisement', 'bcn-theme'),
    'id' => 'advertisement',
    'desc' => __('', 'bcn-theme'),
    'icon' => 'el el-usd'
));

Redux::setSection($opt_name, array(
    'title' => __('Background click ad', 'bcn-theme'),
    'id' => 'background-click-ad',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/color/" target="_blank">docs.reduxframework.com/core/fields/color/</a>',
    'subsection' => true,
    'fields' => array(),
));

Redux::setSection($opt_name, array(
    'title' => __('block 1', 'bcn-theme'),
    'id' => 'block1',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/color-gradient/" target="_blank">docs.reduxframework.com/core/fields/color-gradient/</a>',
    'subsection' => true,
    'fields' => array()
));

Redux::setSection($opt_name, array(
    'title' => __('block 2', 'bcn-theme'),
    'id' => 'block2',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/color-gradient/" target="_blank">docs.reduxframework.com/core/fields/color-gradient/</a>',
    'subsection' => true,
    'fields' => array()
));

Redux::setSection($opt_name, array(
    'title' => __('block 3', 'bcn-theme'),
    'id' => 'block3',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/color-gradient/" target="_blank">docs.reduxframework.com/core/fields/color-gradient/</a>',
    'subsection' => true,
    'fields' => array()
));

Redux::setSection($opt_name, array(
    'title' => __('block 4', 'bcn-theme'),
    'id' => 'block4',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/color-gradient/" target="_blank">docs.reduxframework.com/core/fields/color-gradient/</a>',
    'subsection' => true,
    'fields' => array()
));


// -> START Layouts settings
Redux::setSection($opt_name, array(
    'title' => __('Layouts settings', 'bcn-theme'),
    'id' => 'layouts-settings',
    'desc' => __('', 'bcn-theme'),
    'icon' => 'el el-align-justify'
));

Redux::setSection($opt_name, array(
    'title' => __('Template settings', 'bcn-theme'),
    'id' => 'template-settings',
    'subsection' => true,
    'fields' => array(),
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/background/" target="_blank">docs.reduxframework.com/core/fields/background/</a>',
));

Redux::setSection($opt_name, array(
    'title' => __('Categories template', 'bcn-theme'),
    'id' => 'categories-template',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/border/" target="_blank">docs.reduxframework.com/core/fields/border/</a>',
    'subsection' => true,
    'fields' => array()
));

Redux::setSection($opt_name, array(
    'title' => __('Post settings', 'bcn-theme'),
    'id' => 'post-settings',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/dimensions/" target="_blank">docs.reduxframework.com/core/fields/dimensions/</a>',
    'subsection' => true,
    'fields' => array()
));

Redux::setSection($opt_name, array(
    'title' => __('Portfolio', 'bcn-theme'),
    'id' => 'portfoilo',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/spacing/" target="_blank">docs.reduxframework.com/core/fields/spacing/</a>',
    'subsection' => true,
    'fields' => array()
));

// -> START Miscellaneous
Redux::setSection($opt_name, array(
    'title' => __('++ Miscellaneous', 'bcn-theme'),
    'id' => 'miscellaneous',
    'desc' => __('', 'bcn-theme'),
    'icon' => 'el el-cog'
));


Redux::setSection($opt_name, array(
    'title' => __('Block settings', 'bcn-theme'),
    'id' => 'block-settings',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'block-settings-start',
            'type' => 'section',
            'title' => __('Global Block Template', 'bcn-theme'),
            'subtitle' => __('This template will be applied to the whole site. The theme will also try to adjust the default widgets to look in the same style with the block template selected here.'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'block-settings-template',
            'type' => 'image_select',
            'title'    => __('Block template', 'bcn-theme'),
            'subtitle' => __('You can overwrite the template on each block and widget.'),
            'desc' => __('This uses some of the built in images, you can use them for layout options.', 'bcn-theme'),
            //Must provide key => value(array:title|img) pairs for radio options
            'options' => array(
                '1' => array(
                    'alt' => '1 Column',
                    'img'   => get_template_directory_uri().'/images/admin/preview-01.jpg'
                ),
                '2' => array(
                    'alt' => '2 Column Left',
                    'img'   => get_template_directory_uri().'/images/admin/preview-02.jpg'
                ),
                '3' => array(
                    'alt' => '2 Column Right',
                    'img'   => get_template_directory_uri().'/images/admin/preview-03.jpg'
                ),
                '4' => array(
                    'alt' => '3 Column Middle',
                    'img'   => get_template_directory_uri().'/images/admin/preview-04.jpg'
                ),
                '5' => array(
                    'alt' => '3 Column Left',
                    'img'   => get_template_directory_uri().'/images/admin/preview-05.jpg'
                ),
                '6' => array(
                    'alt' => '3 Column Right',
                    'img'   => get_template_directory_uri().'/images/admin/preview-06.jpg'
                ),
                '7' => array(
                    'alt' => '3 Column Right',
                    'img'   => get_template_directory_uri().'/images/admin/preview-07.jpg'
                ),
                '8' => array(
                    'alt' => '3 Column Right',
                    'img'   => get_template_directory_uri().'/images/admin/preview-09.jpg'
                ),
                '9' => array(
                    'alt' => '3 Column Right',
                    'img'   => get_template_directory_uri().'/images/admin/preview-11.jpg'
                ),
            ),
            'default' => '2',
            'tiles' => true,
        ),
        array(
            'id' => 'block-settings-meta-start',
            'type' => 'section',
            'title' => __('Meta info on Modules/Blocks', 'bcn-theme'),
            'subtitle' => __('You can overwrite the template on each block and widget.'),
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'block-settings-meta-author',
            'type' => 'switch',
            'title' => __('Show author name', 'bcn-theme'),
            'subtitle' => __('Enable or disable the author name (on blocks and modules)'),
            'default' => false,
        ),
        array(
            'id' => 'block-settings-meta-date',
            'type' => 'switch',
            'title' => __('Show date', 'bcn-theme'),
            'subtitle' => __('Enable or disable the post date (on blocks and modules)'),
            'default' => false,
        ),
        array(
            'id' => 'block-settings-meta-comments-number',
            'type' => 'switch',
            'title' => __('Show comment count', 'bcn-theme'),
            'subtitle' => __('Enable or disable comment number (on blocks and modules)'),
            'default' => false,
        ),
        array(
            'id' => 'block-settings-meta-reviews',
            'type' => 'switch',
            'title' => __('Show review', 'bcn-theme'),
            'subtitle' => __('Enable or disable reviews (on blocks and modules)'),
            'default' => false,
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => __('Background', 'bcn-theme'),
    'id' => 'background',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'background-theme',
            'type' => 'background',
//            'output' => array('body'),
            'title' => __('Theme background', 'bcn-theme'),
            'background-color' => 'false',
        ),

        array(
            'id' => 'background-search',
            'type' => 'background',
//            'output' => array('body'),
            'title' => __('Search panel background', 'bcn-theme'),
            'background-color' => 'false',
        ),

        array(
            'id' => 'background-flip',
            'type' => 'background',
//            'output' => array('body'),
            'title' => __('Flip panel background', 'bcn-theme'),
            'background-color' => 'false',
        ),

        array(
            'id' => 'background-mobile-menu',
            'type' => 'background',
//            'output' => array('body'),
            'title' => __('Mobile menu background', 'bcn-theme'),
            'background-color' => 'false',
        ),

//        array(
//            'id' => 'background-theme',
//            'type' => 'background',
////            'output' => array('body'),
//            'title' => __('Footer background', 'bcn-theme'),
//            'background-color' => 'false',
//        ),
    ),
));

Redux::setSection($opt_name, array(
    'title' => __('Excerpts', 'bcn-theme'),
    'id' => 'excerpts',
    'desc' => __('Adding a text as excerpt on post edit page (Excerpt box), will overwrite the theme excerpts ', 'bcn-theme'),
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'title-lenght',
            'type' => 'text',
            'title' => __('Title lenght', 'bcn-theme'),
            'subtitle' => __('In words', 'bcn-theme'),
            'desc' => __('Example: 12', 'bcn-theme'),
            'default' => '12',
        ),
        array(
            'id' => 'excerpts-lenght',
            'type' => 'text',
            'title' => __('Excerpts lenght', 'bcn-theme'),
            'subtitle' => __('In words', 'bcn-theme'),
            'desc' => __('Example: 256', 'bcn-theme'),
            'default' => '12',
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => __('Theme colors', 'bcn-theme'),
    'id' => 'theme-color',
//    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/slides/" target="_blank">docs.reduxframework.com/core/fields/slides/</a>',
    'subsection' => true,
    'fields' => array(

//      General colors

        array(
            'id' => 'colors-general-start',
            'type' => 'section',
            'title' => __('General theme colors', 'bcn-theme'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'colors-general-accent',
            'type'     => 'color',
            'title'    => __('Theme accent color', 'bcn-theme'),
            'subtitle' => __('Select theme accent color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-general-bg',
            'type'     => 'color',
            'title'    => __('Background color', 'bcn-theme'),
            'subtitle' => __('Select theme background color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-general-headers-bg',
            'type'     => 'color',
            'title'    => __('Headers background color', 'bcn-theme'),
            'subtitle' => __('Select a global header background color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-general-headers',
            'type'     => 'color',
            'title'    => __('Headers text color', 'bcn-theme'),
            'subtitle' => __('Select a global header text color'),
            'default'  => false,
            'validate' => 'color',
        ),

//      Preloader

        array(
            'id' => 'colors-preloader-start',
            'type' => 'section',
            'title' => __('Preloader', 'bcn-theme'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'colors-preloader-bg',
            'type'     => 'color',
            'title'    => __('Preloader background color', 'bcn-theme'),
            'subtitle' => __('Select preloader background color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-preloader',
            'type'     => 'color',
            'title'    => __('Preloader color', 'bcn-theme'),
            'subtitle' => __('Select preloader color'),
            'default'  => false,
            'validate' => 'color',
        ),

//      Header

        array(
            'id' => 'colors-header-start',
            'type' => 'section',
            'title' => __('Header', 'bcn-theme'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'colors-header-bg',
            'type'     => 'color',
            'title'    => __('Header background color', 'bcn-theme'),
            'subtitle' => __('Select header background color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-header-logo',
            'type'     => 'color',
            'title'    => __('Text logo color', 'bcn-theme'),
            'subtitle' => __('Select text logo color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-menu-bg',
            'type'     => 'color',
            'title'    => __('Menu background color', 'bcn-theme'),
            'subtitle' => __('Select menu background color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-menu-hover',
            'type'     => 'color',
            'title'    => __('Menu active & hover color', 'bcn-theme'),
            'subtitle' => __('Select the active and hover color for menu and submenu'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-menu-txt',
            'type'     => 'color',
            'title'    => __('Menu text color', 'bcn-theme'),
            'subtitle' => __('Select menu text color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-menu-accent-txt',
            'type'     => 'color',
            'title'    => __('Menu accent text color', 'bcn-theme'),
            'subtitle' => __('Select menu accent text color'),
            'default'  => false,
            'validate' => 'color',
        ),

//      Header -> Submenu

        array(
            'id'       => 'colors-submenu-bg',
            'type'     => 'color',
            'title'    => __('Sub-menu background color', 'bcn-theme'),
            'subtitle' => __('Select sub-menu background color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-submenu-color',
            'type'     => 'color',
            'title'    => __('Sub-menu text color', 'bcn-theme'),
            'subtitle' => __('Select sub-menu text color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-submenu-hover-bg',
            'type'     => 'color',
            'title'    => __('Sub-menu active & hover background', 'bcn-theme'),
            'subtitle' => __('Active and hover background color for sub-menus'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-submenu-hover-color',
            'type'     => 'color',
            'title'    => __('Sub-menu active & hover text color', 'bcn-theme'),
            'subtitle' => __('Active and hover text color for sub-menus'),
            'default'  => false,
            'validate' => 'color',
        ),

//      Header -> icons

        array(
            'id'       => 'colors-menu-icons',
            'type'     => 'color',
            'title'    => __('Menu icons color', 'bcn-theme'),
            'subtitle' => __('Select menu icons color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-menu-icons-hover',
            'type'     => 'color',
            'title'    => __('Menu icons hover color', 'bcn-theme'),
            'subtitle' => __('Select menu icons hover color'),
            'default'  => false,
            'validate' => 'color',
        ),

//      Header ->  social

        array(
            'id'       => 'colors-menu-soc-icons',
            'type'     => 'color',
            'title'    => __('Social icons color', 'bcn-theme'),
            'subtitle' => __('Select social icons color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-menu-soc-icons-hover',
            'type'     => 'color',
            'title'    => __('Social icons hover color', 'bcn-theme'),
            'subtitle' => __('Select social icons hover color'),
            'default'  => false,
            'validate' => 'color',
        ),

//      Sidebar

        array(
            'id' => 'colors-sidebar-start',
            'type' => 'section',
            'title' => __('Sidebar', 'bcn-theme'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'colors-sidebar-bg',
            'type'     => 'color',
            'title'    => __('Sidebar background color', 'bcn-theme'),
            'subtitle' => __('Select sidebar background color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-sidebar-color',
            'type'     => 'color',
            'title'    => __('Sidebar text color', 'bcn-theme'),
            'subtitle' => __('Select sidebar text color'),
            'default'  => false,
            'validate' => 'color',
        ),

//      Flip panel

        array(
            'id' => 'colors-flip-start',
            'type' => 'section',
            'title' => __('Flip panel', 'bcn-theme'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'colors-flip-bg',
            'type'     => 'color',
            'title'    => __('Flip panel background color', 'bcn-theme'),
            'subtitle' => __('Select flip panel background color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-flip-color',
            'type'     => 'color',
            'title'    => __('Flip panel text and icons color', 'bcn-theme'),
            'subtitle' => __('Select text and icons color for flip panel'),
            'default'  => false,
            'validate' => 'color',
        ),

//      Search panel

        array(
            'id' => 'colors-search-start',
            'type' => 'section',
            'title' => __('Search panel', 'bcn-theme'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'colors-search-bg',
            'type'     => 'color',
            'title'    => __('Search panel background color', 'bcn-theme'),
            'subtitle' => __('Select search panel background color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-search-color',
            'type'     => 'color',
            'title'    => __('Search panel text and icons color', 'bcn-theme'),
            'subtitle' => __('Select search panel text and icons color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-search-border',
            'type'     => 'color',
            'title'    => __('Search panel bottom border color', 'bcn-theme'),
            'subtitle' => __('Select search panel bottom border color'),
            'default'  => false,
            'validate' => 'color',
        ),

//      Posts

        array(
            'id' => 'colors-posts-start',
            'type' => 'section',
            'title' => __('Posts', 'bcn-theme'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'colors-posts-title',
            'type'     => 'color',
            'title'    => __('Post title color', 'bcn-theme'),
            'subtitle' => __('Select post title color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-posts-author',
            'type'     => 'color',
            'title'    => __('Post & block author name color', 'bcn-theme'),
            'subtitle' => __('Select author name color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-posts-text',
            'type'     => 'color',
            'title'    => __('Post text color', 'bcn-theme'),
            'subtitle' => __('Select post content color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-posts-h',
            'type'     => 'color',
            'title'    => __('Post h1, h2, h3, h4, h5, h6 color', 'bcn-theme'),
            'subtitle' => __('Select in post h color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-posts-blockquote',
            'type'     => 'color',
            'title'    => __('Post blockquote color', 'bcn-theme'),
            'subtitle' => __('Select in post blockquote color'),
            'default'  => false,
            'validate' => 'color',
        ),

//      Pages

        array(
            'id' => 'colors-pages-start',
            'type' => 'section',
            'title' => __('Pages', 'bcn-theme'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'colors-pages-title',
            'type'     => 'color',
            'title'    => __('Page title color', 'bcn-theme'),
            'subtitle' => __('Select page title color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-pages-text',
            'type'     => 'color',
            'title'    => __('Page text color', 'bcn-theme'),
            'subtitle' => __('Select page text color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-pages-h',
            'type'     => 'color',
            'title'    => __('Page h1, h2, h3, h4, h5, h6 color', 'bcn-theme'),
            'subtitle' => __('Select page h color'),
            'default'  => false,
            'validate' => 'color',
        ),

//      Footer

        array(
            'id' => 'colors-footer-start',
            'type' => 'section',
            'title' => __('Footer', 'bcn-theme'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'colors-footer-bg',
            'type'     => 'color',
            'title'    => __('Background color', 'bcn-theme'),
            'subtitle' => __('Select footer background color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-footer-color',
            'type'     => 'color',
            'title'    => __('Text color', 'bcn-theme'),
            'subtitle' => __('Select footer text color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-footer-header',
            'type'     => 'color',
            'title'    => __('Widgets header text color', 'bcn-theme'),
            'subtitle' => __('Select widgets header text color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-footer-social',
            'type'     => 'color',
            'title'    => __('Footer social icons color', 'bcn-theme'),
            'subtitle' => __('Select social icons color'),
            'default'  => false,
            'validate' => 'color',
        ),
        array(
            'id'       => 'colors-footer-social-hover',
            'type'     => 'color',
            'title'    => __('Footer social icons hover color', 'bcn-theme'),
            'subtitle' => __('Select social icons hover color'),
            'default'  => false,
            'validate' => 'color',
        ),

    )
));



Redux::setSection($opt_name, array(
    'title' => __('Theme fonts', 'bcn-theme'),
    'id' => 'theme-fonts',
//    'desc' => __('Font Settings ', 'bcn-theme'),
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'fonts-body-start',
            'type' => 'section',
            'title' => __('Global fonts setting', 'bcn-theme'),
            'subtitle' => __('Main theme fonts.', 'bcn-theme'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'fonts-body',
            'type'     => 'typography',
            'title'    => __( 'Body general font', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-header-start',
            'type' => 'section',
            'title' => __('Header', 'bcn-theme'),
            'indent' => true,
        ),
        array(
            'id' => 'fonts-header-logo',
            'type'     => 'typography',
            'title'    => __( 'Text logo', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-header-widget',
            'type'     => 'typography',
            'title'    => __( 'Header widget', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-header-menu',
            'type'     => 'typography',
            'title'    => __( 'Top menu', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-header-submenu',
            'type'     => 'typography',
            'title'    => __( 'Top sub menu', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),

        array(
            'id' => 'fonts-header-mobile-menu',
            'type'     => 'typography',
            'title'    => __( 'Mobile menu', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),

        array(
            'id' => 'fonts-header-mobile-submenu',
            'type'     => 'typography',
            'title'    => __( 'Mobile sub menu', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
//
//        array(
//            'id' => 'fonts-post-start',
//            'type' => 'section',
//            'title' => __('Post  elements', 'bcn-theme'),
//            'subtitle' => __('Main theme fonts.', 'bcn-theme'),
//            'indent' => true, // Indent all options below until the next 'section' option is set.
//        ),

        array(
            'id' => 'fonts-post-start',
            'type' => 'section',
            'title' => __('Post content', 'bcn-theme'),
            'indent' => true,
        ),
        array(
            'id' => 'fonts-post-title',
            'type'     => 'typography',
            'title'    => __( 'Post title', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-content',
            'type'     => 'typography',
            'title'    => __( 'Post content', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-blockquote',
            'type'     => 'typography',
            'title'    => __( 'Blockquote', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-boxkquote',
            'type'     => 'typography',
            'title'    => __( 'Box quote', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-pullquote',
            'type'     => 'typography',
            'title'    => __( 'Pull quote', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-lists',
            'type'     => 'typography',
            'title'    => __( 'Lists', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-h1',
            'type'     => 'typography',
            'title'    => __( 'H1', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-h2',
            'type'     => 'typography',
            'title'    => __( 'H2', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-h3',
            'type'     => 'typography',
            'title'    => __( 'H3', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-h4',
            'type'     => 'typography',
            'title'    => __( 'H4', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-h5',
            'type'     => 'typography',
            'title'    => __( 'H5', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-h6',
            'type'     => 'typography',
            'title'    => __( 'H6', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),

        array(
            'id' => 'fonts-post-elements-start',
            'type' => 'section',
            'title' => __('Post  elements', 'bcn-theme'),
            'indent' => true,
        ),

        array(
            'id' => 'fonts-post-elements-category',
            'type'     => 'typography',
            'title'    => __( 'Category tag', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-elements-author',
            'type'     => 'typography',
            'title'    => __( 'Author', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),

        array(
            'id' => 'fonts-post-elements-date',
            'type'     => 'typography',
            'title'    => __( 'Date', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),

        array(
            'id' => 'fonts-post-elements-views-comments',
            'type'     => 'typography',
            'title'    => __( 'Views and comments', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-elements-vst',
            'type'     => 'typography',
            'title'    => __( 'Via/source/tags', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-elements-nptxt',
            'type'     => 'typography',
            'title'    => __( 'Next/prev text', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-elements-nppttxt',
            'type'     => 'typography',
            'title'    => __( 'Next/prev post title', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-elements-box-author-name',
            'type'     => 'typography',
            'title'    => __( 'Box author name', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-elements-box-author-url',
            'type'     => 'typography',
            'title'    => __( 'Box author url', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-elements-box-author-description',
            'type'     => 'typography',
            'title'    => __( 'Box author description', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-elements-related-article',
            'type'     => 'typography',
            'title'    => __( 'Related article title', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-elements-share-text',
            'type'     => 'typography',
            'title'    => __( 'Share text', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-post-elements-image-caption',
            'type'     => 'typography',
            'title'    => __( 'Image caption', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),



        array(
            'id' => 'fonts-pages-start',
            'type' => 'section',
            'title' => __('Pages', 'bcn-theme'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'fonts-pages-title',
            'type'     => 'typography',
            'title'    => __( 'Page title', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'default'  => false,
            'text-transform' => true,
        ),

        array(
            'id' => 'fonts-pages-content',
            'type'     => 'typography',
            'title'    => __( 'Page content', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'default'  => false,
            'text-transform' => true,
        ),

        array(
            'id' => 'fonts-pages-h1',
            'type'     => 'typography',
            'title'    => __( 'H1', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-pages-h2',
            'type'     => 'typography',
            'title'    => __( 'H2', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-pages-h3',
            'type'     => 'typography',
            'title'    => __( 'H3', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-pages-h4',
            'type'     => 'typography',
            'title'    => __( 'H4', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-pages-h5',
            'type'     => 'typography',
            'title'    => __( 'H5', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-pages-h6',
            'type'     => 'typography',
            'title'    => __( 'H6', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),

        array(
            'id' => 'fonts-footer-start',
            'type' => 'section',
            'title' => __('Footer fonts settings', 'bcn-theme'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'fonts-footer-text',
            'type'     => 'typography',
            'title'    => __( 'Footer text', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
        array(
            'id' => 'fonts-footer-menu',
            'type'     => 'typography',
            'title'    => __( 'Footer menu', 'bcn-theme' ),
            'google'   => true,
            'output'    => array(''),
            'text-align' => false,
            'color' => false,
            'default'  => false,
            'text-transform' => true,
        ),
    ),
));

Redux::setSection($opt_name, array(
    'title' => __('Custom code', 'bcn-theme'),
    'id' => 'custom-code',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'custom-code-css',
            'type' => 'ace_editor',
            'full_width' => true,
            'title' => __('CSS Code', 'bcn-theme'),
            'subtitle' => __('Paste your CSS code here.', 'bcn-theme'),
            'mode' => 'css',
            'theme' => 'monokai',
            'desc' => 'The css from this box will load on all the pages of the site.',
            'default' => ""
        ),
        array(
            'id' => 'custom-code-js',
            'type' => 'ace_editor',
            'full_width' => true,
            'title' => __('JS Code', 'bcn-theme'),
            'subtitle' => __('Paste your JS code here.', 'bcn-theme'),
            'mode' => 'javascript',
            'theme' => 'chrome',
            'desc' => 'Add custom javascript easly, using this editor. Please do not include the &lt;script&gt &lt;/script&gt',
            'default' => ""
        ),
    )

));

Redux::setSection($opt_name, array(
    'title' => __('Analytics', 'bcn-theme'),
    'id' => 'analytics',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'analytics',
            'type' => 'ace_editor',
            'full_width' => true,
            'title' => __('Google Analytics code', 'bcn-theme'),
            'subtitle' => __('Paste your code here.', 'bcn-theme'),
            'mode' => 'plain_text',
            'theme' => 'chrome',
            'desc' => '',
            'default' => ""
        ),
    )
));

//   Social networks

Redux::setSection($opt_name, array(
    'title' => __('Social networks', 'bcn-theme'),
    'id' => 'social-networks',
    'desc' => __('Insert a link to your account if you want to display this social network.', 'bcn-theme'),
    'subsection' => true,
    'fields' => array(

//      Most popular socials

        array(
            'id' => 'social-twitter',
            'type' => 'text',
            'title' => __('Twitter', 'bcn-theme'),
            'desc' => __('Link to : twitter', 'bcn-theme'),
        ),
        array(
            'id' => 'social-facebook',
            'type' => 'text',
            'title' => __('Facebook', 'bcn-theme'),
            'desc' => __('Link to : facebook', 'bcn-theme'),
        ),
        array(
            'id' => 'social-instagram',
            'type' => 'text',
            'title' => __('Instagram', 'bcn-theme'),
            'desc' => __('Link to : instagram', 'bcn-theme'),
        ),
        array(
            'id' => 'social-youtube',
            'type' => 'text',
            'title' => __('Youtube', 'bcn-theme'),
            'desc' => __('Link to : youtube', 'bcn-theme'),
        ),

//      Regular

        array(
            'id' => 'social-behance',
            'type' => 'text',
            'title' => __('Behance', 'bcn-theme'),
            'desc' => __('Link to : behance', 'bcn-theme'),
        ),
        array(
            'id' => 'social-blogger',
            'type' => 'text',
            'title' => __('Blogger', 'bcn-theme'),
            'desc' => __('Link to : blogger', 'bcn-theme'),
        ),
        array(
            'id' => 'social-dailymotion',
            'type' => 'text',
            'title' => __('Dailymotion', 'bcn-theme'),
            'desc' => __('Link to : dailymotion', 'bcn-theme'),
        ),
        array(
            'id' => 'social-delicious',
            'type' => 'text',
            'title' => __('Delicious', 'bcn-theme'),
            'desc' => __('Link to : delicious', 'bcn-theme'),
        ),

        array(
            'id' => 'social-deviantart',
            'type' => 'text',
            'title' => __('Deviantart', 'bcn-theme'),
            'desc' => __('Link to : deviantart', 'bcn-theme'),
        ),
        array(
            'id' => 'social-digg',
            'type' => 'text',
            'title' => __('Digg', 'bcn-theme'),
            'desc' => __('Link to : digg', 'bcn-theme'),
        ),
        array(
            'id' => 'social-dribbble',
            'type' => 'text',
            'title' => __('Dribbble', 'bcn-theme'),
            'desc' => __('Link to : dribbble', 'bcn-theme'),
        ),
        array(
            'id' => 'social-dropbox',
            'type' => 'text',
            'title' => __('Dropbox', 'bcn-theme'),
            'desc' => __('Link to : dropbox', 'bcn-theme'),
        ),
        array(
            'id' => 'social-evernote',
            'type' => 'text',
            'title' => __('Evernote', 'bcn-theme'),
            'desc' => __('Link to : evernote', 'bcn-theme'),
        ),
        array(
            'id' => 'social-flickr',
            'type' => 'text',
            'title' => __('Flickr', 'bcn-theme'),
            'desc' => __('Link to : flickr', 'bcn-theme'),
        ),
        array(
            'id' => 'social-googleplus',
            'type' => 'text',
            'title' => __('Google +', 'bcn-theme'),
            'desc' => __('Link to : googleplus', 'bcn-theme'),
        ),
        array(
            'id' => 'social-instagram',
            'type' => 'text',
            'title' => __('Last FM', 'bcn-theme'),
            'desc' => __('Link to : instagram', 'bcn-theme'),
        ),
        array(
            'id' => 'social-linkedin',
            'type' => 'text',
            'title' => __('LinkedIN', 'bcn-theme'),
            'desc' => __('Link to : linkedin', 'bcn-theme'),
        ),
        array(
            'id' => 'social-picasa',
            'type' => 'text',
            'title' => __('Picasa', 'bcn-theme'),
            'desc' => __('Link to : picasa', 'bcn-theme'),
        ),
        array(
            'id' => 'social-pinterest',
            'type' => 'text',
            'title' => __('Pinterest', 'bcn-theme'),
            'desc' => __('Link to : pinterest', 'bcn-theme'),
        ),
        array(
            'id' => 'social-rss',
            'type' => 'text',
            'title' => __('RSS', 'bcn-theme'),
            'desc' => __('Link to : rss', 'bcn-theme'),
        ),
        array(
            'id' => 'social-tumblr',
            'type' => 'text',
            'title' => __('Tumblr', 'bcn-theme'),
            'desc' => __('Link to : tumblr', 'bcn-theme'),
        ),
        array(
            'id' => 'social-vimeo',
            'type' => 'text',
            'title' => __('Vimeo', 'bcn-theme'),
            'desc' => __('Link to : vimeo', 'bcn-theme'),
        ),
        array(
            'id' => 'social-wordpress',
            'type' => 'text',
            'title' => __('WordPress', 'bcn-theme'),
            'desc' => __('Link to : wordpress', 'bcn-theme'),
        ),
        array(
            'id' => 'social-500pixels',
            'type' => 'text',
            'title' => __('500 pixels', 'bcn-theme'),
            'desc' => __('Link to : 500 pixels', 'bcn-theme'),
        ),
        array(
            'id' => 'social-viewbug',
            'type' => 'text',
            'title' => __('ViewBug', 'bcn-theme'),
            'desc' => __('Link to : viewbug', 'bcn-theme'),
        ),
        array(
            'id' => 'social-xing',
            'type' => 'text',
            'title' => __('Xing', 'bcn-theme'),
            'desc' => __('Link to : xing', 'bcn-theme'),
        ),
        array(
            'id' => 'social-spotify',
            'type' => 'text',
            'title' => __('Spotify', 'bcn-theme'),
            'desc' => __('Link to : spotify', 'bcn-theme'),
        ),
        array(
            'id' => 'social-houzz',
            'type' => 'text',
            'title' => __('Houzz', 'bcn-theme'),
            'desc' => __('Link to : houzz', 'bcn-theme'),
        ),
        array(
            'id' => 'social-skype',
            'type' => 'text',
            'title' => __('Skype', 'bcn-theme'),
            'desc' => __('Link to : skype', 'bcn-theme'),
        ),
        array(
            'id' => 'social-slideshare',
            'type' => 'text',
            'title' => __('Slideshare', 'bcn-theme'),
            'desc' => __('Link to : slideshare', 'bcn-theme'),
        ),
        array(
            'id' => 'social-bandcamp',
            'type' => 'text',
            'title' => __('Bandcamp', 'bcn-theme'),
            'desc' => __('Link to : bandcamp', 'bcn-theme'),
        ),
        array(
            'id' => 'social-soundcloud',
            'type' => 'text',
            'title' => __('Soundcloud', 'bcn-theme'),
            'desc' => __('Link to : soundcloud', 'bcn-theme'),
        ),
        array(
            'id' => 'social-periscope',
            'type' => 'text',
            'title' => __('Periscope', 'bcn-theme'),
            'desc' => __('Link to : periscope', 'bcn-theme'),
        ),
        array(
            'id' => 'social-snapchat',
            'type' => 'text',
            'title' => __('Snapchat', 'bcn-theme'),
            'desc' => __('Link to : snapchat', 'bcn-theme'),
        ),
        array(
            'id' => 'social-thecity',
            'type' => 'text',
            'title' => __('The City', 'bcn-theme'),
            'desc' => __('Link to : thecity', 'bcn-theme'),
        ),
        array(
            'id' => 'social-microsoft-pinpoint',
            'type' => 'text',
            'title' => __('Microsoft Pinpoint', 'bcn-theme'),
            'desc' => __('Link to : microsoft pinpoint', 'bcn-theme'),
        ),
        array(
            'id' => 'social-viadeo',
            'type' => 'text',
            'title' => __('Viadeo', 'bcn-theme'),
            'desc' => __('Link to : viadeo', 'bcn-theme'),
        ),
        array(
            'id' => 'social-tripadvisor',
            'type' => 'text',
            'title' => __('TripAdvisor', 'bcn-theme'),
            'desc' => __('Link to : tripadvisor', 'bcn-theme'),
        ),
        array(
            'id' => 'social-vk',
            'type' => 'text',
            'title' => __('VKontakte', 'bcn-theme'),
            'desc' => __('Link to : vkontakte', 'bcn-theme'),
        ),
        array(
            'id' => 'social-ok',
            'type' => 'text',
            'title' => __('Odnoklassniki', 'bcn-theme'),
            'desc' => __('Link to : odnoklassniki', 'bcn-theme'),
        ),
        array(
            'id' => 'social-telegram',
            'type' => 'text',
            'title' => __('Telegram', 'bcn-theme'),
            'desc' => __('Link to : telegram', 'bcn-theme'),
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => __('Import - export', 'bcn-theme'),
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
 *
 * ---> START SECTIONS
 *
 */
/*
    As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for
 */
// -> START Basic Fields
Redux::setSection($opt_name, array(
    'title' => __('Basic Fields', 'bcn-theme'),
    'id' => 'basic',
    'desc' => __('These are really basic fields!', 'bcn-theme'),
    'customizer_width' => '400px',
    'icon' => 'el el-home'
));
Redux::setSection($opt_name, array(
    'title' => __('Checkbox', 'bcn-theme'),
    'id' => 'basic-checkbox',
    'subsection' => true,
    'customizer_width' => '450px',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/checkbox/" target="_blank">docs.reduxframework.com/core/fields/checkbox/</a>',
    'fields' => array(
        array(
            'id' => 'opt-checkbox',
            'type' => 'checkbox',
            'title' => __('Checkbox Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'default' => '1'// 1 = on | 0 = off
        ),
        array(
            'id' => 'opt-multi-check',
            'type' => 'checkbox',
            'title' => __('Multi Checkbox Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            //Must provide key => value pairs for multi checkbox options
            'options' => array(
                '1' => 'Opt 1',
                '2' => 'Opt 2',
                '3' => 'Opt 3'
            ),
            //See how std has changed? you also don't need to specify opts that are 0.
            'default' => array(
                '1' => '1',
                '2' => '0',
                '3' => '0'
            )
        ),
        array(
            'id' => 'opt-checkbox-data',
            'type' => 'checkbox',
            'title' => __('Multi Checkbox Option (with menu data)', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'data' => 'menu'
        ),
        array(
            'id' => 'opt-checkbox-sidebar',
            'type' => 'checkbox',
            'title' => __('Multi Checkbox Option (with sidebar data)', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'data' => 'sidebars'
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Radio', 'bcn-theme'),
    'id' => 'basic-Radio',
    'subsection' => true,
    'customizer_width' => '500px',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/radio/" target="_blank">docs.reduxframework.com/core/fields/radio/</a>',
    'fields' => array(
        array(
            'id' => 'opt-radio',
            'type' => 'radio',
            'title' => __('Radio Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            //Must provide key => value pairs for radio options
            'options' => array(
                '1' => 'Opt 1',
                '2' => 'Opt 2',
                '3' => 'Opt 3'
            ),
            'default' => '2'
        ),
        array(
            'id' => 'opt-radio-data',
            'type' => 'radio',
            'title' => __('Radio Option w/ Menu Data', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'data' => 'menu'
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Sortable', 'bcn-theme'),
    'id' => 'basic-Sortable',
    'subsection' => true,
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/sortable/" target="_blank">docs.reduxframework.com/core/fields/sortable/</a>',
    'fields' => array(
        array(
            'id' => 'opt-sortable',
            'type' => 'sortable',
            'title' => __('Sortable Text Option', 'bcn-theme'),
            'subtitle' => __('Define and reorder these however you want.', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'label' => true,
            'options' => array(
                'Text One' => 'Item 1',
                'Text Two' => 'Item 2',
                'Text Three' => 'Item 3',
            )
        ),
        array(
            'id' => 'opt-check-sortable',
            'type' => 'sortable',
            'mode' => 'checkbox', // checkbox or text
            'title' => __('Sortable Text Option', 'bcn-theme'),
            'subtitle' => __('Define and reorder these however you want.', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'options' => array(
                'cb1' => 'Checkbox One',
                'cb2' => 'Checkbox Two',
                'cb3' => 'Checkbox Three',
            ),
            'default' => array(
                'cb1' => false,
                'cb2' => true,
                'cb3' => false,
            )
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Text', 'bcn-theme'),
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/text/" target="_blank">docs.reduxframework.com/core/fields/text/</a>',
    'id' => 'basic-Text',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'text-example',
            'type' => 'text',
            'title' => __('Text Field', 'bcn-theme'),
            'subtitle' => __('Subtitle', 'bcn-theme'),
            'desc' => __('Field Description', 'bcn-theme'),
            'default' => 'Default Text',
        ),
        array(
            'id' => 'text-example-hint',
            'type' => 'text',
            'title' => __('Text Field w/ Hint', 'bcn-theme'),
            'subtitle' => __('Subtitle', 'bcn-theme'),
            'desc' => __('Field Description', 'bcn-theme'),
            'default' => 'Default Text',
            'text_hint' => array(
                'title' => 'Hint Title',
                'content' => 'Hint content about this field!'
            )
        ),
        array(
            'id' => 'text-placeholder',
            'type' => 'text',
            'title' => __('Text Field', 'bcn-theme'),
            'subtitle' => __('Subtitle', 'bcn-theme'),
            'desc' => __('Field Description', 'bcn-theme'),
            'placeholder' => 'Placeholder Text',
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Multi Text', 'bcn-theme'),
    'id' => 'basic-Multi Text',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/multi-text/" target="_blank">docs.reduxframework.com/core/fields/multi-text/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-multitext',
            'type' => 'multi_text',
            'title' => __('Multi Text Option', 'bcn-theme'),
            'subtitle' => __('Field subtitle', 'bcn-theme'),
            'desc' => __('Field Decription', 'bcn-theme'),
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Password', 'bcn-theme'),
    'id' => 'basic-Password',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/password/" target="_blank">docs.reduxframework.com/core/fields/password/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'password',
            'type' => 'password',
            'username' => true,
            'title' => 'Password Field',
            //'placeholder' => array(
            //    'username' => 'Username',
            //    'password' => 'Password',
            //)
        )
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Textarea', 'bcn-theme'),
    'id' => 'basic-Textarea',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/textarea/" target="_blank">docs.reduxframework.com/core/fields/textarea/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-textarea',
            'type' => 'textarea',
            'title' => __('Textarea Option - HTML Validated Custom', 'bcn-theme'),
            'subtitle' => __('Subtitle', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'default' => 'Default Text',
        )
    )
));
// -> START Editors
Redux::setSection($opt_name, array(
    'title' => __('Editors', 'bcn-theme'),
    'id' => 'editor',
    'customizer_width' => '500px',
    'icon' => 'el el-edit',
));
Redux::setSection($opt_name, array(
    'title' => __('WordPress Editor', 'bcn-theme'),
    'id' => 'editor-wordpress',
    //'icon'  => 'el el-home'
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/editor/" target="_blank">docs.reduxframework.com/core/fields/editor/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-editor',
            'type' => 'editor',
            'title' => __('Editor', 'bcn-theme'),
            'subtitle' => __('Use any of the features of WordPress editor inside your panel!', 'bcn-theme'),
            'default' => 'Powered by Redux Framework.',
        ),
        array(
            'id' => 'opt-editor-tiny',
            'type' => 'editor',
            'title' => __('Editor w/o Media Button', 'bcn-theme'),
            'default' => 'Powered by Redux Framework.',
            'args' => array(
                'wpautop' => false,
                'media_buttons' => false,
                'textarea_rows' => 5,
                //'tabindex' => 1,
                //'editor_css' => '',
                'teeny' => false,
                //'tinymce' => array(),
                'quicktags' => false,
            )
        ),
        array(
            'id' => 'opt-editor-full',
            'type' => 'editor',
            'title' => __('Editor - Full Width', 'bcn-theme'),
            'full_width' => true
        ),
    ),
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/editor/" target="_blank">docs.reduxframework.com/core/fields/editor/</a>',
));
Redux::setSection($opt_name, array(
    'title' => __('ACE Editor', 'bcn-theme'),
    'id' => 'editor-ace',
    //'icon'  => 'el el-home'
    'subsection' => true,
    'desc' => __('For full documentation on the this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/ace-editor/" target="_blank">docs.reduxframework.com/core/fields/ace-editor/</a>',
    'fields' => array(
        array(
            'id' => 'opt-ace-editor-css',
            'type' => 'ace_editor',
            'title' => __('CSS Code', 'bcn-theme'),
            'subtitle' => __('Paste your CSS code here.', 'bcn-theme'),
            'mode' => 'css',
            'theme' => 'monokai',
            'desc' => 'Possible modes can be found at <a href="' . 'http://' . 'ace.c9.io" target="_blank">' . 'http://' . 'ace.c9.io/</a>.',
            'default' => "#header{\n   margin: 0 auto;\n}"
        ),
        array(
            'id' => 'opt-ace-editor-js',
            'type' => 'ace_editor',
            'title' => __('JS Code', 'bcn-theme'),
            'subtitle' => __('Paste your JS code here.', 'bcn-theme'),
            'mode' => 'javascript',
            'theme' => 'chrome',
            'desc' => 'Possible modes can be found at <a href="' . 'http://' . 'ace.c9.io" target="_blank">' . 'http://' . 'ace.c9.io/</a>.',
            'default' => "jQuery(document).ready(function(){\n\n});"
        ),
        array(
            'id' => 'opt-ace-editor-php',
            'type' => 'ace_editor',
            'full_width' => true,
            'title' => __('PHP Code', 'bcn-theme'),
            'subtitle' => __('Paste your PHP code here.', 'bcn-theme'),
            'mode' => 'php',
            'theme' => 'chrome',
            'desc' => 'Possible modes can be found at <a href="' . 'http://' . 'ace.c9.io" target="_blank">' . 'http://' . 'ace.c9.io/</a>.',
            'default' => '<?php
    echo "PHP String";'
        ),
    )
));
// -> START Color Selection
Redux::setSection($opt_name, array(
    'title' => __('Color Selection', 'bcn-theme'),
    'id' => 'color',
    'desc' => __('', 'bcn-theme'),
    'icon' => 'el el-brush'
));
Redux::setSection($opt_name, array(
    'title' => __('Color', 'bcn-theme'),
    'id' => 'color-Color',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/color/" target="_blank">docs.reduxframework.com/core/fields/color/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-color-title',
            'type' => 'color',
            'output' => array('.site-title'),
            'title' => __('Site Title Color', 'bcn-theme'),
            'subtitle' => __('Pick a title color for the theme (default: #000).', 'bcn-theme'),
            'default' => '#000000',
        ),
        array(
            'id' => 'opt-color-footer',
            'type' => 'color',
            'title' => __('Footer Background Color', 'bcn-theme'),
            'subtitle' => __('Pick a background color for the footer (default: #dd9933).', 'bcn-theme'),
            'default' => '#dd9933',
            'validate' => 'color',
        ),
    ),
));
Redux::setSection($opt_name, array(
    'title' => __('Color Gradient', 'bcn-theme'),
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/color-gradient/" target="_blank">docs.reduxframework.com/core/fields/color-gradient/</a>',
    'id' => 'color-gradient',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-color-header',
            'type' => 'color_gradient',
            'title' => __('Header Gradient Color Option', 'bcn-theme'),
            'subtitle' => __('Only color validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'default' => array(
                'from' => '#1e73be',
                'to' => '#00897e'
            )
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Color RGBA', 'bcn-theme'),
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/color-rgba/" target="_blank">docs.reduxframework.com/core/fields/color-rgba/</a>',
    'id' => 'color-rgba',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-color-rgba',
            'type' => 'color_rgba',
            'title' => __('Color RGBA', 'bcn-theme'),
            'subtitle' => __('Gives you the RGBA color.', 'bcn-theme'),
            'default' => array(
                'color' => '#7e33dd',
                'alpha' => '.8'
            ),
            //'output'   => array( 'body' ),
            'mode' => 'background',
            //'validate' => 'colorrgba',
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Link Color', 'bcn-theme'),
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/link-color/" target="_blank">docs.reduxframework.com/core/fields/link-color/</a>',
    'id' => 'color-link',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-link-color',
            'type' => 'link_color',
            'title' => __('Links Color Option', 'bcn-theme'),
            'subtitle' => __('Only color validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            //'regular'   => false, // Disable Regular Color
            //'hover'     => false, // Disable Hover Color
            //'active'    => false, // Disable Active Color
            //'visited'   => true,  // Enable Visited Color
            'default' => array(
                'regular' => '#aaa',
                'hover' => '#bbb',
                'active' => '#ccc',
            )
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Palette Colors', 'bcn-theme'),
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/palette-color/" target="_blank">docs.reduxframework.com/core/fields/palette-color/</a>',
    'id' => 'color-palette',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-palette-color',
            'type' => 'palette',
            'title' => __('Palette Color Option', 'bcn-theme'),
            'subtitle' => __('Only color validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'default' => 'red',
            'palettes' => array(
                'red' => array(
                    '#ef9a9a',
                    '#f44336',
                    '#ff1744',
                ),
                'pink' => array(
                    '#fce4ec',
                    '#f06292',
                    '#e91e63',
                    '#ad1457',
                    '#f50057',
                ),
                'cyan' => array(
                    '#e0f7fa',
                    '#80deea',
                    '#26c6da',
                    '#0097a7',
                    '#00e5ff',
                ),
            )
        ),
    )
));
// -> START Design Fields
Redux::setSection($opt_name, array(
    'title' => __('Design Fields', 'bcn-theme'),
    'id' => 'design',
    'desc' => __('', 'bcn-theme'),
    'icon' => 'el el-wrench'
));
Redux::setSection($opt_name, array(
    'title' => __('Background', 'bcn-theme'),
    'id' => 'design-background',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-background',
            'type' => 'background',
            'output' => array('body'),
            'title' => __('Body Background', 'bcn-theme'),
            'subtitle' => __('Body background with image, color, etc.', 'bcn-theme'),
            //'default'   => '#FFFFFF',
        ),
    ),
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/background/" target="_blank">docs.reduxframework.com/core/fields/background/</a>',
));
Redux::setSection($opt_name, array(
    'title' => __('Border', 'bcn-theme'),
    'id' => 'design-border',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/border/" target="_blank">docs.reduxframework.com/core/fields/border/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-header-border',
            'type' => 'border',
            'title' => __('Header Border Option', 'bcn-theme'),
            'subtitle' => __('Only color validation can be done on this field type', 'bcn-theme'),
            'output' => array('.site-header'),
            // An array of CSS selectors to apply this font style to
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'default' => array(
                'border-color' => '#1e73be',
                'border-style' => 'solid',
                'border-top' => '3px',
                'border-right' => '3px',
                'border-bottom' => '3px',
                'border-left' => '3px'
            ),
        ),
        array(
            'id' => 'opt-header-border-expanded',
            'type' => 'border',
            'title' => __('Header Border Option', 'bcn-theme'),
            'subtitle' => __('Only color validation can be done on this field type', 'bcn-theme'),
            'output' => array('.site-header'),
            'all' => false,
            // An array of CSS selectors to apply this font style to
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'default' => array(
                'border-color' => '#1e73be',
                'border-style' => 'solid',
                'border-top' => '3px',
                'border-right' => '3px',
                'border-bottom' => '3px',
                'border-left' => '3px'
            )
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Dimensions', 'bcn-theme'),
    'id' => 'design-dimensions',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/dimensions/" target="_blank">docs.reduxframework.com/core/fields/dimensions/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-dimensions',
            'type' => 'dimensions',
            'units' => array('em', 'px', '%'),    // You can specify a unit value. Possible: px, em, %
            'units_extended' => 'true',  // Allow users to select any type of unit
            'title' => __('Dimensions (Width/Height) Option', 'bcn-theme'),
            'subtitle' => __('Allow your users to choose width, height, and/or unit.', 'bcn-theme'),
            'desc' => __('You can enable or disable any piece of this field. Width, Height, or Units.', 'bcn-theme'),
            'default' => array(
                'width' => 200,
                'height' => 100,
            )
        ),
        array(
            'id' => 'opt-dimensions-width',
            'type' => 'dimensions',
            'units' => array('em', 'px', '%'),    // You can specify a unit value. Possible: px, em, %
            'units_extended' => 'true',  // Allow users to select any type of unit
            'title' => __('Dimensions (Width) Option', 'bcn-theme'),
            'subtitle' => __('Allow your users to choose width, height, and/or unit.', 'bcn-theme'),
            'desc' => __('You can enable or disable any piece of this field. Width, Height, or Units.', 'bcn-theme'),
            'height' => false,
            'default' => array(
                'width' => 200,
                'height' => 100,
            )
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Spacing', 'bcn-theme'),
    'id' => 'design-spacing',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/spacing/" target="_blank">docs.reduxframework.com/core/fields/spacing/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-spacing',
            'type' => 'spacing',
            'output' => array('.site-header'),
            // An array of CSS selectors to apply this font style to
            'mode' => 'margin',
            // absolute, padding, margin, defaults to padding
            'all' => true,
            // Have one field that applies to all
            //'top'           => false,     // Disable the top
            //'right'         => false,     // Disable the right
            //'bottom'        => false,     // Disable the bottom
            //'left'          => false,     // Disable the left
            //'units'         => 'em',      // You can specify a unit value. Possible: px, em, %
            //'units_extended'=> 'true',    // Allow users to select any type of unit
            //'display_units' => 'false',   // Set to false to hide the units if the units are specified
            'title' => __('Padding/Margin Option', 'bcn-theme'),
            'subtitle' => __('Allow your users to choose the spacing or margin they want.', 'bcn-theme'),
            'desc' => __('You can enable or disable any piece of this field. Top, Right, Bottom, Left, or Units.', 'bcn-theme'),
            'default' => array(
                'margin-top' => '1px',
                'margin-right' => '2px',
                'margin-bottom' => '3px',
                'margin-left' => '4px'
            )
        ),
        array(
            'id' => 'opt-spacing-expanded',
            'type' => 'spacing',
            // An array of CSS selectors to apply this font style to
            'mode' => 'margin',
            // absolute, padding, margin, defaults to padding
            'all' => false,
            // Have one field that applies to all
            //'top'           => false,     // Disable the top
            //'right'         => false,     // Disable the right
            //'bottom'        => false,     // Disable the bottom
            //'left'          => false,     // Disable the left
            'units' => array('em', 'px', '%'),      // You can specify a unit value. Possible: px, em, %
            'units_extended' => 'true',    // Allow users to select any type of unit
            //'display_units' => 'false',   // Set to false to hide the units if the units are specified
            'title' => __('Padding/Margin Option', 'bcn-theme'),
            'subtitle' => __('Allow your users to choose the spacing or margin they want.', 'bcn-theme'),
            'desc' => __('You can enable or disable any piece of this field. Top, Right, Bottom, Left, or Units.', 'bcn-theme'),
            'default' => array(
                'margin-top' => '1px',
                'margin-right' => '2px',
                'margin-bottom' => '3px',
                'margin-left' => '4px'
            )
        ),
    )
));
// -> START Media Uploads
Redux::setSection($opt_name, array(
    'title' => __('Media Uploads', 'bcn-theme'),
    'id' => 'media',
    'desc' => __('', 'bcn-theme'),
    'icon' => 'el el-picture'
));
Redux::setSection($opt_name, array(
    'title' => __('Gallery', 'bcn-theme'),
    'id' => 'media-gallery',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/gallery/" target="_blank">docs.reduxframework.com/core/fields/gallery/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-gallery',
            'type' => 'gallery',
            'title' => __('Add/Edit Gallery', 'bcn-theme'),
            'subtitle' => __('Create a new Gallery by selecting existing or uploading new images using the WordPress native uploader', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Media', 'bcn-theme'),
    'id' => 'media-media',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/media/" target="_blank">docs.reduxframework.com/core/fields/media/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-media',
            'type' => 'media',
            'url' => true,
            'title' => __('Media w/ URL', 'bcn-theme'),
            'compiler' => 'true',
            //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
            'desc' => __('Basic media uploader with disabled URL input field.', 'bcn-theme'),
            'subtitle' => __('Upload any media using the WordPress native uploader', 'bcn-theme'),
            'default' => array('url' => 'https://s.wordpress.org/style/images/codeispoetry.png'),
            //'hint'      => array(
            //    'title'     => 'Hint Title',
            //    'content'   => 'This is a <b>hint</b> for the media field with a Title.',
            //)
        ),
        array(
            'id' => 'media-no-url',
            'type' => 'media',
            'title' => __('Media w/o URL', 'bcn-theme'),
            'desc' => __('This represents the minimalistic view. It does not have the preview box or the display URL in an input box. ', 'bcn-theme'),
            'subtitle' => __('Upload any media using the WordPress native uploader', 'bcn-theme'),
        ),
        array(
            'id' => 'media-no-preview',
            'type' => 'media',
            'preview' => false,
            'title' => __('Media No Preview', 'bcn-theme'),
            'desc' => __('This represents the minimalistic view. It does not have the preview box or the display URL in an input box. ', 'bcn-theme'),
            'subtitle' => __('Upload any media using the WordPress native uploader', 'bcn-theme'),
            'hint' => array(
                'title' => 'Test',
                'content' => 'This is a <b>hint</b> tool-tip for the webFonts field.<br/><br/>Add any HTML based text you like here.',
            )
        ),
        array(
            'id' => 'opt-random-upload',
            'type' => 'media',
            'title' => __('Upload Anything - Disabled Mode', 'bcn-theme'),
            'full_width' => true,
            'mode' => false,
            // Can be set to false to allow any media type, or can also be set to any mime type.
            'desc' => __('Basic media uploader with disabled URL input field.', 'bcn-theme'),
            'subtitle' => __('Upload any media using the WordPress native uploader', 'bcn-theme'),
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Slides', 'bcn-theme'),
    'id' => 'additional-slides',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/slides/" target="_blank">docs.reduxframework.com/core/fields/slides/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-slides',
            'type' => 'slides',
            'title' => __('Slides Options', 'bcn-theme'),
            'subtitle' => __('Unlimited slides with drag and drop sortings.', 'bcn-theme'),
            'desc' => __('This field will store all slides values into a multidimensional array to use into a foreach loop.', 'bcn-theme'),
            'placeholder' => array(
                'title' => __('This is a title', 'bcn-theme'),
                'description' => __('Description Here', 'bcn-theme'),
                'url' => __('Give us a link!', 'bcn-theme'),
            ),
        ),
    )
));
// -> START Presentation Fields
Redux::setSection($opt_name, array(
    'title' => __('Presentation Fields', 'bcn-theme'),
    'id' => 'presentation',
    'desc' => __('', 'bcn-theme'),
    'icon' => 'el el-screen'
));
Redux::setSection($opt_name, array(
    'title' => __('Divide', 'bcn-theme'),
    'id' => 'presentation-divide',
    'desc' => __('The spacer to the section menu as seen to the left (after this section block) is the divide "section". Also the divider below is the divide "field".', 'bcn-theme') . '<br />' . __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/divide/" target="_blank">docs.reduxframework.com/core/fields/divide/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-divide',
            'type' => 'divide'
        ),
    ),
));
Redux::setSection($opt_name, array(
    'title' => __('Info', 'bcn-theme'),
    'id' => 'presentation-info',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/info/" target="_blank">docs.reduxframework.com/core/fields/info/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-info-field',
            'type' => 'info',
            'desc' => __('This is the info field, if you want to break sections up.', 'bcn-theme')
        ),
        array(
            'id' => 'opt-notice-info1',
            'type' => 'info',
            'style' => 'info',
            'title' => __('This is a title.', 'bcn-theme'),
            'desc' => __('This is an info field with the <strong>info</strong> style applied. By default the <strong>normal</strong> style is applied.', 'bcn-theme')
        ),
        array(
            'id' => 'opt-info-warning',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('This is a title.', 'bcn-theme'),
            'desc' => __('This is an info field with the <strong>warning</strong> style applied.', 'bcn-theme')
        ),
        array(
            'id' => 'opt-info-success',
            'type' => 'info',
            'style' => 'success',
            'icon' => 'el el-info-circle',
            'title' => __('This is a title.', 'bcn-theme'),
            'desc' => __('This is an info field with the <strong>success</strong> style applied and an icon.', 'bcn-theme')
        ),
        array(
            'id' => 'opt-info-critical',
            'type' => 'info',
            'style' => 'critical',
            'icon' => 'el el-info-circle',
            'title' => __('This is a title.', 'bcn-theme'),
            'desc' => __('This is an info field with the <strong>critical</strong> style applied and an icon.', 'bcn-theme')
        ),
        array(
            'id' => 'opt-info-custom',
            'type' => 'info',
            'style' => 'custom',
            'color' => 'purple',
            'icon' => 'el el-info-circle',
            'title' => __('This is a title.', 'bcn-theme'),
            'desc' => __('This is an info field with the <strong>custom</strong> style applied, color arg passed, and an icon.', 'bcn-theme')
        ),
        array(
            'id' => 'opt-info-normal',
            'type' => 'info',
            'notice' => false,
            'title' => __('This is a title.', 'bcn-theme'),
            'desc' => __('This is an info non-notice field with the <strong>normal</strong> style applied.', 'bcn-theme')
        ),
        array(
            'id' => 'opt-notice-info',
            'type' => 'info',
            'notice' => false,
            'style' => 'info',
            'title' => __('This is a title.', 'bcn-theme'),
            'desc' => __('This is an info non-notice field with the <strong>info</strong> style applied.', 'bcn-theme')
        ),
        array(
            'id' => 'opt-notice-warning',
            'type' => 'info',
            'notice' => false,
            'style' => 'warning',
            'icon' => 'el el-info-circle',
            'title' => __('This is a title.', 'bcn-theme'),
            'desc' => __('This is an info non-notice field with the <strong>warning</strong> style applied and an icon.', 'bcn-theme')
        ),
        array(
            'id' => 'opt-notice-success',
            'type' => 'info',
            'notice' => false,
            'style' => 'success',
            'icon' => 'el el-info-circle',
            'title' => __('This is a title.', 'bcn-theme'),
            'desc' => __('This is an info non-notice field with the <strong>success</strong> style applied and an icon.', 'bcn-theme')
        ),
        array(
            'id' => 'opt-notice-critical',
            'type' => 'info',
            'notice' => false,
            'style' => 'critical',
            'icon' => 'el el-info-circle',
            'title' => __('This is a title.', 'bcn-theme'),
            'desc' => __('This is an non-notice field with the <strong>critical</strong> style applied and an icon.', 'bcn-theme')
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Section', 'bcn-theme'),
    'id' => 'presentation-section',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/section/" target="_blank">docs.reduxframework.com/core/fields/section/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'section-start',
            'type' => 'section',
            'title' => __('Section Example', 'bcn-theme'),
            'subtitle' => __('With the "section" field you can create indented option sections.', 'bcn-theme'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'section-test',
            'type' => 'text',
            'title' => __('Field Title', 'bcn-theme'),
            'subtitle' => __('Field Subtitle', 'bcn-theme'),
        ),
        array(
            'id' => 'section-test-media',
            'type' => 'media',
            'title' => __('Field Title', 'bcn-theme'),
            'subtitle' => __('Field Subtitle', 'bcn-theme'),
        ),
        array(
            'id' => 'section-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'section-info',
            'type' => 'info',
            'desc' => __('And now you can add more fields below and outside of the indent.', 'bcn-theme'),
        ),
    ),
));
Redux::setSection($opt_name, array(
    'id' => 'presentation-divide-sample',
    'type' => 'divide',
));
// -> START Switch & Button Set
Redux::setSection($opt_name, array(
    'title' => __('Switch & Button Set', 'bcn-theme'),
    'id' => 'switch_buttonset',
    'desc' => __('', 'bcn-theme'),
    'icon' => 'el el-cogs'
));
Redux::setSection($opt_name, array(
    'title' => __('Button Set', 'bcn-theme'),
    'id' => 'switch_buttonset-set',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/button-set/" target="_blank">docs.reduxframework.com/core/fields/button-set/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-button-set',
            'type' => 'button_set',
            'title' => __('Button Set Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            //Must provide key => value pairs for radio options
            'options' => array(
                '1' => 'Opt 1',
                '2' => 'Opt 2',
                '3' => 'Opt 3'
            ),
            'default' => '2'
        ),
        array(
            'id' => 'opt-button-set-multi',
            'type' => 'button_set',
            'title' => __('Button Set, Multi Select', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'multi' => true,
            //Must provide key => value pairs for radio options
            'options' => array(
                '1' => 'Opt 1',
                '2' => 'Opt 2',
                '3' => 'Opt 3'
            ),
            'default' => array('2', '3')
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Switch', 'bcn-theme'),
    'id' => 'switch_buttonset-switch',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/switch/" target="_blank">docs.reduxframework.com/core/fields/switch/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'switch-on',
            'type' => 'switch',
            'title' => __('Switch On', 'bcn-theme'),
            'subtitle' => __('Look, it\'s on!', 'bcn-theme'),
            'default' => true,
        ),
        array(
            'id' => 'switch-off',
            'type' => 'switch',
            'title' => __('Switch Off', 'bcn-theme'),
            'subtitle' => __('Look, it\'s on!', 'bcn-theme'),
            //'options' => array('on', 'off'),
            'default' => false,
        ),
        array(
            'id' => 'switch-parent',
            'type' => 'switch',
            'title' => __('Switch - Nested Children, Enable to show', 'bcn-theme'),
            'subtitle' => __('Look, it\'s on! Also hidden child elements!', 'bcn-theme'),
            'default' => 0,
            'on' => 'Enabled',
            'off' => 'Disabled',
        ),
        array(
            'id' => 'switch-child1',
            'type' => 'switch',
            'required' => array('switch-parent', '=', '1'),
            'title' => __('Switch - This and the next switch required for patterns to show', 'bcn-theme'),
            'subtitle' => __('Also called a "fold" parent.', 'bcn-theme'),
            'desc' => __('Items set with a fold to this ID will hide unless this is set to the appropriate value.', 'bcn-theme'),
            'default' => false,
        ),
        array(
            'id' => 'switch-child2',
            'type' => 'switch',
            'required' => array('switch-parent', '=', '1'),
            'title' => __('Switch2 - Enable the above switch and this one for patterns to show', 'bcn-theme'),
            'subtitle' => __('Also called a "fold" parent.', 'bcn-theme'),
            'desc' => __('Items set with a fold to this ID will hide unless this is set to the appropriate value.', 'bcn-theme'),
            'default' => false,
        ),
    )
));
// -> START Select Fields
Redux::setSection($opt_name, array(
    'title' => __('Select Fields', 'bcn-theme'),
    'id' => 'select',
    'icon' => 'el el-list-alt'
));
Redux::setSection($opt_name, array(
    'title' => __('Select', 'bcn-theme'),
    'id' => 'select-select',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/select/" target="_blank">docs.reduxframework.com/core/fields/select/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-select',
            'type' => 'select',
            'title' => __('Select Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            //Must provide key => value pairs for select options
            'options' => array(
                '1' => 'Opt 1',
                '2' => 'Opt 2',
                '3' => 'Opt 3',
            ),
            'default' => '2'
        ),
        array(
            'id' => 'opt-select-stylesheet',
            'type' => 'select',
            'title' => __('Theme Stylesheet', 'bcn-theme'),
            'subtitle' => __('Select your themes alternative color scheme.', 'bcn-theme'),
            'options' => array('default.css' => 'default.css', 'color1.css' => 'color1.css'),
            'default' => 'default.css',
        ),
        array(
            'id' => 'opt-select-optgroup',
            'type' => 'select',
            'title' => __('Select Option with optgroup', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            //Must provide key => value pairs for select options
            'options' => array(
                'Group 1' => array(
                    '1' => 'Opt 1',
                    '2' => 'Opt 2',
                    '3' => 'Opt 3',
                ),
                'Group 2' => array(
                    '4' => 'Opt 4',
                    '5' => 'Opt 5',
                    '6' => 'Opt 6',
                ),
                '7' => 'Opt 7',
                '8' => 'Opt 8',
                '9' => 'Opt 9',
            ),
            'default' => '2'
        ),
        array(
            'id' => 'opt-multi-select',
            'type' => 'select',
            'multi' => true,
            'title' => __('Multi Select Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            //Must provide key => value pairs for radio options
            'options' => array(
                '1' => 'Opt 1',
                '2' => 'Opt 2',
                '3' => 'Opt 3'
            ),
            //'required' => array( 'opt-select', 'equals', array( '1', '3' ) ),
            'default' => array('2', '3')
        ),
        array(
            'id' => 'opt-info',
            'type' => 'info',
            'desc' => __('You can easily add a variety of data from WordPress.', 'bcn-theme'),
        ),
        array(
            'id' => 'opt-select-categories',
            'type' => 'select',
            'data' => 'categories',
            'title' => __('Categories Select Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
        ),
        array(
            'id' => 'opt-select-categories-multi',
            'type' => 'select',
            'data' => 'categories',
            'multi' => true,
            'title' => __('Categories Multi Select Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
        ),
        array(
            'id' => 'opt-select-pages',
            'type' => 'select',
            'data' => 'pages',
            'title' => __('Pages Select Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
        ),
        array(
            'id' => 'opt-multi-select-pages',
            'type' => 'select',
            'data' => 'pages',
            'multi' => true,
            'title' => __('Pages Multi Select Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
        ),
        array(
            'id' => 'opt-select-tags',
            'type' => 'select',
            'data' => 'tags',
            'title' => __('Tags Select Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
        ),
        array(
            'id' => 'opt-multi-select-tags',
            'type' => 'select',
            'data' => 'tags',
            'multi' => true,
            'title' => __('Tags Multi Select Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
        ),
        array(
            'id' => 'opt-select-menus',
            'type' => 'select',
            'data' => 'menus',
            'title' => __('Menus Select Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
        ),
        array(
            'id' => 'opt-multi-select-menus',
            'type' => 'select',
            'data' => 'menu',
            'multi' => true,
            'title' => __('Menus Multi Select Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
        ),
        array(
            'id' => 'opt-select-post-type',
            'type' => 'select',
            'data' => 'post_type',
            'title' => __('Post Type Select Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
        ),
        array(
            'id' => 'opt-multi-select-post-type',
            'type' => 'select',
            'data' => 'post_type',
            'multi' => true,
            'title' => __('Post Type Multi Select Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
        ),
        array(
            'id' => 'opt-multi-select-sortable',
            'type' => 'select',
            'data' => 'post_type',
            'multi' => true,
            'sortable' => true,
            'title' => __('Post Type Multi Select Option + Sortable', 'bcn-theme'),
            'subtitle' => __('This field also has sortable enabled!', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
        ),
        array(
            'id' => 'opt-select-posts',
            'type' => 'select',
            'data' => 'post',
            'title' => __('Posts Select Option2', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
        ),
        array(
            'id' => 'opt-multi-select-posts',
            'type' => 'select',
            'data' => 'post',
            'multi' => true,
            'title' => __('Posts Multi Select Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
        ),
        array(
            'id' => 'opt-select-roles',
            'type' => 'select',
            'data' => 'roles',
            'title' => __('User Role Select Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
        ),
        array(
            'id' => 'opt-select-capabilities',
            'type' => 'select',
            'data' => 'capabilities',
            'multi' => true,
            'title' => __('Capabilities Select Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
        ),
        array(
            'id' => 'opt-select-elusive',
            'type' => 'select',
            'data' => 'elusive-icons',
            'title' => __('Elusive Icons Select Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('Here\'s a list of all the elusive icons by name and icon.', 'bcn-theme'),
        ),
        array(
            'id' => 'opt-select-users',
            'type' => 'select',
            'data' => 'users',
            'title' => __('Users Select Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Image Select', 'bcn-theme'),
    'id' => 'select-image_select',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/image-select/" target="_blank">docs.reduxframework.com/core/fields/image-select/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-image-select-layout',
            'type' => 'image_select',
            'title' => __('Images Option for Layout', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This uses some of the built in images, you can use them for layout options.', 'bcn-theme'),
            //Must provide key => value(array:title|img) pairs for radio options
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
                '4' => array(
                    'alt' => '3 Column Middle',
                    'img' => ReduxFramework::$_url . 'assets/img/3cm.png'
                ),
                '5' => array(
                    'alt' => '3 Column Left',
                    'img' => ReduxFramework::$_url . 'assets/img/3cl.png'
                ),
                '6' => array(
                    'alt' => '3 Column Right',
                    'img' => ReduxFramework::$_url . 'assets/img/3cr.png'
                )
            ),
            'default' => '2'
        ),
        array(
            'id' => 'opt-patterns',
            'type' => 'image_select',
            'tiles' => true,
            'title' => __('Images Option (with tiles => true)', 'bcn-theme'),
            'subtitle' => __('Select a background pattern.', 'bcn-theme'),
            'default' => 0,
            'options' => $sample_patterns
        ,
        ),
        array(
            'id' => 'opt-image-select',
            'type' => 'image_select',
            'title' => __('Images Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            //Must provide key => value(array:title|img) pairs for radio options
            'options' => array(
                '1' => array('title' => 'Opt 1', 'img' => 'images/align-none.png'),
                '2' => array('title' => 'Opt 2', 'img' => 'images/align-left.png'),
                '3' => array('title' => 'Opt 3', 'img' => 'images/align-center.png'),
                '4' => array('title' => 'Opt 4', 'img' => 'images/align-right.png')
            ),
            'default' => '2'
        ),
        array(
            'id' => 'opt-presets',
            'type' => 'image_select',
            'presets' => true,
            'full_width' => true,
            'title' => __('Preset', 'bcn-theme'),
            'subtitle' => __('This allows you to set a json string or array to override multiple preferences in your theme.', 'bcn-theme'),
            'default' => 0,
            'desc' => __('This allows you to set a json string or array to override multiple preferences in your theme.', 'bcn-theme'),
            'options' => array(
                '1' => array(
                    'alt' => 'Preset 1',
                    'img' => ReduxFramework::$_url . '../sample/presets/preset1.png',
                    'presets' => array(
                        'switch-on' => 1,
                        'switch-off' => 1,
                        'switch-parent' => 1
                    )
                ),
                '2' => array(
                    'alt' => 'Preset 2',
                    'img' => ReduxFramework::$_url . '../sample/presets/preset2.png',
                    'presets' => '{"opt-slider-label":"1", "opt-slider-text":"10"}'
                ),
            ),
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => __('Select Image', 'bcn-theme'),
    'id' => 'select-select_image',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/select-image/" target="_blank">docs.reduxframework.com/core/fields/select-image/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-select_image-field',
            'type' => 'select_image',
            'title' => __('Select Image', 'bcn-theme'),
            'subtitle' => __('A preview of the selected image will appear underneath the select box.', 'bcn-theme'),
            'options' => array(
                array(
                    'alt' => 'Preset 1',
                    'img' => ReduxFramework::$_url . '../sample/presets/preset1.png',
                ),
                array(
                    'alt' => 'Preset 2',
                    'img' => ReduxFramework::$_url . '../sample/presets/preset2.png',
                ),
            ),
            'default' => ReduxFramework::$_url . '../sample/presets/preset2.png',
        ),

        array(
            'id' => 'opt-select-image',
            'type' => 'select_image',
            'title' => __('Select Image', 'bcn-theme'),
            'subtitle' => __('A preview of the selected image will appear underneath the select box.', 'bcn-theme'),
            'options' => $sample_patterns,
            'default' => ReduxFramework::$_url . '../sample/patterns/triangular.png',
        ),
    )
));
// -> START Slider / Spinner
Redux::setSection($opt_name, array(
    'title' => __('Slider / Spinner', 'bcn-theme'),
    'id' => 'slider_spinner',
    'desc' => __('', 'bcn-theme'),
    'icon' => 'el el-adjust-alt'
));
Redux::setSection($opt_name, array(
    'title' => __('Slider', 'bcn-theme'),
    'id' => 'slider_spinner-slider',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/slider/" target="_blank">docs.reduxframework.com/core/fields/slider/</a>',
    'fields' => array(
        array(
            'id' => 'opt-slider-label',
            'type' => 'slider',
            'title' => __('Slider Example 1', 'bcn-theme'),
            'subtitle' => __('This slider displays the value as a label.', 'bcn-theme'),
            'desc' => __('Slider description. Min: 1, max: 500, step: 1, default value: 250', 'bcn-theme'),
            'default' => 250,
            'min' => 1,
            'step' => 1,
            'max' => 500,
            'display_value' => 'label'
        ),
        array(
            'id' => 'opt-slider-text',
            'type' => 'slider',
            'title' => __('Slider Example 2 with Steps (5)', 'bcn-theme'),
            'subtitle' => __('This example displays the value in a text box', 'bcn-theme'),
            'desc' => __('Slider description. Min: 0, max: 300, step: 5, default value: 75', 'bcn-theme'),
            'default' => 75,
            'min' => 0,
            'step' => 5,
            'max' => 300,
            'display_value' => 'text'
        ),
        array(
            'id' => 'opt-slider-select',
            'type' => 'slider',
            'title' => __('Slider Example 3 with two sliders', 'bcn-theme'),
            'subtitle' => __('This example displays the values in select boxes', 'bcn-theme'),
            'desc' => __('Slider description. Min: 0, max: 500, step: 5, slider 1 default value: 100, slider 2 default value: 300', 'bcn-theme'),
            'default' => array(
                1 => 100,
                2 => 300,
            ),
            'min' => 0,
            'step' => 5,
            'max' => '500',
            'display_value' => 'select',
            'handles' => 2,
        ),
        array(
            'id' => 'opt-slider-float',
            'type' => 'slider',
            'title' => __('Slider Example 4 with float values', 'bcn-theme'),
            'subtitle' => __('This example displays float values', 'bcn-theme'),
            'desc' => __('Slider description. Min: 0, max: 1, step: .1, default value: .5', 'bcn-theme'),
            'default' => .5,
            'min' => 0,
            'step' => .1,
            'max' => 1,
            'resolution' => 0.1,
            'display_value' => 'text'
        ),
    ),
    'subsection' => true,
));
Redux::setSection($opt_name, array(
    'title' => __('Spinner', 'bcn-theme'),
    'id' => 'slider_spinner-spinner',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/spinner/" target="_blank">docs.reduxframework.com/core/fields/spinner/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-spinner',
            'type' => 'spinner',
            'title' => __('JQuery UI Spinner Example 1', 'bcn-theme'),
            'desc' => __('JQuery UI spinner description. Min:20, max: 100, step:20, default value: 40', 'bcn-theme'),
            'default' => '40',
            'min' => '20',
            'step' => '20',
            'max' => '100',
        ),
    )
));
// -> START Typography
Redux::setSection($opt_name, array(
    'title' => __('Typography', 'bcn-theme'),
    'id' => 'typography',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/typography/" target="_blank">docs.reduxframework.com/core/fields/typography/</a>',
    'icon' => 'el el-font',
    'fields' => array(
        array(
            'id' => 'opt-typography-body',
            'type' => 'typography',
            'title' => __('Body Font', 'bcn-theme'),
            'subtitle' => __('Specify the body font properties.', 'bcn-theme'),
            'google' => true,
            'output' => array('h1, h2, h3, h4'),
            'default' => array(
                'color' => '#dd9933',
                'font-size' => '30px',
                'font-family' => 'Arial,Helvetica,sans-serif',
                'font-weight' => 'Normal',
            ),
        ),
        array(
            'id' => 'opt-typography',
            'type' => 'typography',
            'title' => __('Typography h2.site-description', 'bcn-theme'),
            //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
            //'google'      => false,
            // Disable google fonts. Won't work if you haven't defined your google api key
            'font-backup' => true,
            // Select a backup non-google font in addition to a google font
            //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
            //'subsets'       => false, // Only appears if google is true and subsets not set to false
            //'font-size'     => false,
            //'line-height'   => false,
            //'word-spacing'  => true,  // Defaults to false
            //'letter-spacing'=> true,  // Defaults to false
            //'color'         => false,
            //'preview'       => false, // Disable the previewer
            'all_styles' => true,
            // Enable all Google Font style/weight variations to be added to the page
            'output' => array('.site-description'),
            // An array of CSS selectors to apply this font style to dynamically
            'compiler' => array('site-description-compiler'),
            // An array of CSS selectors to apply this font style to dynamically
            'units' => 'px',
            // Defaults to px
            'subtitle' => __('Typography option with each property can be called individually.', 'bcn-theme'),
            'default' => array(
                'color' => '#333',
                'font-style' => '700',
                'font-family' => 'Abel',
                'google' => true,
                'font-size' => '33px',
                'line-height' => '40px'
            ),
        ),
    )
));
// -> START Additional Types
Redux::setSection($opt_name, array(
    'title' => __('Additional Types', 'bcn-theme'),
    'id' => 'additional',
    'desc' => __('', 'bcn-theme'),
    'icon' => 'el el-magic',
    //'fields' => array(
    //    array(
    //        'id'              => 'opt-customizer-only-in-section',
    //        'type'            => 'select',
    //        'title'           => __( 'Customizer Only Option', 'bcn-theme' ),
    //        'subtitle'        => __( 'The subtitle is NOT visible in customizer', 'bcn-theme' ),
    //        'desc'            => __( 'The field desc is NOT visible in customizer.', 'bcn-theme' ),
    //        'customizer_only' => true,
    //        //Must provide key => value pairs for select options
    //        'options'         => array(
    //            '1' => 'Opt 1',
    //            '2' => 'Opt 2',
    //            '3' => 'Opt 3'
    //        ),
    //        'default'         => '2'
    //    ),
    //)
));
Redux::setSection($opt_name, array(
    'title' => __('Date', 'bcn-theme'),
    'id' => 'additional-date',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/date/" target="_blank">docs.reduxframework.com/core/fields/date/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-datepicker',
            'type' => 'date',
            'title' => __('Date Option', 'bcn-theme'),
            'subtitle' => __('No validation can be done on this field type', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme')
        ),
    ),
));
Redux::setSection($opt_name, array(
    'title' => __('Sorter', 'bcn-theme'),
    'id' => 'additional-sorter',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/sorter/" target="_blank">docs.reduxframework.com/core/fields/sorter/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-homepage-layout',
            'type' => 'sorter',
            'title' => 'Layout Manager Advanced',
            'subtitle' => 'You can add multiple drop areas or columns.',
            'compiler' => 'true',
            'options' => array(
                'enabled' => array(
                    'highlights' => 'Highlights',
                    'slider' => 'Slider',
                    'staticpage' => 'Static Page',
                    'services' => 'Services'
                ),
                'disabled' => array(),
                'backup' => array(),
            ),
            'limits' => array(
                'disabled' => 1,
                'backup' => 2,
            ),
        ),
        array(
            'id' => 'opt-homepage-layout-2',
            'type' => 'sorter',
            'title' => 'Homepage Layout Manager',
            'desc' => 'Organize how you want the layout to appear on the homepage',
            'compiler' => 'true',
            'options' => array(
                'disabled' => array(
                    'highlights' => 'Highlights',
                    'slider' => 'Slider',
                ),
                'enabled' => array(
                    'staticpage' => 'Static Page',
                    'services' => 'Services'
                ),
            ),
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Raw', 'bcn-theme'),
    'id' => 'additional-raw',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/raw/" target="_blank">docs.reduxframework.com/core/fields/raw/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-raw_info_4',
            'type' => 'raw',
            'title' => __('Standard Raw Field', 'bcn-theme'),
            'subtitle' => __('Subtitle', 'bcn-theme'),
            'desc' => __('Description', 'bcn-theme'),
            'content' => $sampleHTML,
        ),
        array(
            'id' => 'opt-raw_info_5',
            'type' => 'raw',
            'full_width' => false,
            'title' => __('Raw Field <code>full_width</code> False', 'bcn-theme'),
            'subtitle' => __('Subtitle', 'bcn-theme'),
            'desc' => __('Description', 'bcn-theme'),
            'content' => $sampleHTML,
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Advanced Features', 'bcn-theme'),
    'icon' => 'el el-thumbs-up',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
));
Redux::setSection($opt_name, array(
    'title' => __('Callback', 'bcn-theme'),
    'id' => 'additional-callback',
    'desc' => __('For full documentation on this field, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/fields/callback/" target="_blank">docs.reduxframework.com/core/fields/callback/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-custom-callback',
            'type' => 'callback',
            'title' => __('Custom Field Callback', 'bcn-theme'),
            'subtitle' => __('This is a completely unique field type', 'bcn-theme'),
            'desc' => __('This is created with a callback function, so anything goes in this field. Make sure to define the function though.', 'bcn-theme'),
            'callback' => 'redux_my_custom_field'
        ),
    )
));
// -> START Validation
Redux::setSection($opt_name, array(
    'title' => __('Field Validation', 'bcn-theme'),
    'id' => 'validation',
    'desc' => __('For full documentation on validation, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/the-basics/validation/" target="_blank">docs.reduxframework.com/core/the-basics/validation/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-text-email',
            'type' => 'text',
            'title' => __('Text Option - Email Validated', 'bcn-theme'),
            'subtitle' => __('This is a little space under the Field Title in the Options table, additional info is good in here.', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'validate' => 'email',
            'msg' => 'custom error message',
            'default' => 'test@test.com',
        ),
        array(
            'id' => 'opt-text-post-type',
            'type' => 'text',
            'title' => __('Text Option with Data Attributes', 'bcn-theme'),
            'subtitle' => __('You can also pass an options array if you want. Set the default to whatever you like.', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'data' => 'post_type',
        ),
        array(
            'id' => 'opt-multi-text',
            'type' => 'multi_text',
            'title' => __('Multi Text Option - Color Validated', 'bcn-theme'),
            'validate' => 'color',
            'subtitle' => __('If you enter an invalid color it will be removed. Try using the text "blue" as a color.  ;)', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme')
        ),
        array(
            'id' => 'opt-text-url',
            'type' => 'text',
            'title' => __('Text Option - URL Validated', 'bcn-theme'),
            'subtitle' => __('This must be a URL.', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'validate' => 'url',
            'default' => 'http://reduxframework.com',
        ),
        array(
            'id' => 'opt-text-numeric',
            'type' => 'text',
            'title' => __('Text Option - Numeric Validated', 'bcn-theme'),
            'subtitle' => __('This must be numeric.', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'validate' => 'numeric',
            'default' => '0',
        ),
        array(
            'id' => 'opt-text-comma-numeric',
            'type' => 'text',
            'title' => __('Text Option - Comma Numeric Validated', 'bcn-theme'),
            'subtitle' => __('This must be a comma separated string of numerical values.', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'validate' => 'comma_numeric',
            'default' => '0',
        ),
        array(
            'id' => 'opt-text-no-special-chars',
            'type' => 'text',
            'title' => __('Text Option - No Special Chars Validated', 'bcn-theme'),
            'subtitle' => __('This must be a alpha numeric only.', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'validate' => 'no_special_chars',
            'default' => '0'
        ),
        array(
            'id' => 'opt-text-str_replace',
            'type' => 'text',
            'title' => __('Text Option - Str Replace Validated', 'bcn-theme'),
            'subtitle' => __('You decide.', 'bcn-theme'),
            'desc' => __('This field\'s default value was changed by a filter hook!', 'bcn-theme'),
            'validate' => 'str_replace',
            'str' => array(
                'search' => ' ',
                'replacement' => 'thisisaspace'
            ),
            'default' => 'This is the default.'
        ),
        array(
            'id' => 'opt-text-preg_replace',
            'type' => 'text',
            'title' => __('Text Option - Preg Replace Validated', 'bcn-theme'),
            'subtitle' => __('You decide.', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'validate' => 'preg_replace',
            'preg' => array(
                'pattern' => '/[^a-zA-Z_ -]/s',
                'replacement' => 'no numbers'
            ),
            'default' => '0'
        ),
        array(
            'id' => 'opt-text-custom_validate',
            'type' => 'text',
            'title' => __('Text Option - Custom Callback Validated', 'bcn-theme'),
            'subtitle' => __('You decide.', 'bcn-theme'),
            'desc' => __('Enter <code>1</code> and click <strong>Save Changes</strong> for an error message, or enter <code>2</code> and click <strong>Save Changes</strong> for a warning message.', 'bcn-theme'),
            'validate_callback' => 'redux_validate_callback_function',
            'default' => '0'
        ),
        //array(
        //    'id'                => 'opt-text-custom_validate-class',
        //    'type'              => 'text',
        //    'title'             => __( 'Text Option - Custom Callback Validated - Class', 'bcn-theme' ),
        //    'subtitle'          => __( 'You decide.', 'bcn-theme' ),
        //    'desc'              => __( 'This is the description field, again good for additional info.', 'bcn-theme' ),
        //    'validate_callback' => array( 'Class_Name', 'validate_callback_function' ),
        //    // You can pass the current class
        //    // Or pass the class name and method
        //    //'validate_callback' => array(
        //    //    'Redux_Framework_sample_config',
        //    //    'validate_callback_function'
        //    //),
        //    'default'           => '0'
        //),
        array(
            'id' => 'opt-textarea-no-html',
            'type' => 'textarea',
            'title' => __('Textarea Option - No HTML Validated', 'bcn-theme'),
            'subtitle' => __('All HTML will be stripped', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'validate' => 'no_html',
            'default' => 'No HTML is allowed in here.'
        ),
        array(
            'id' => 'opt-textarea-html',
            'type' => 'textarea',
            'title' => __('Textarea Option - HTML Validated', 'bcn-theme'),
            'subtitle' => __('HTML Allowed (wp_kses)', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'validate' => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
            'default' => 'HTML is allowed in here.'
        ),
        array(
            'id' => 'opt-textarea-some-html',
            'type' => 'textarea',
            'title' => __('Textarea Option - HTML Validated Custom', 'bcn-theme'),
            'subtitle' => __('Custom HTML Allowed (wp_kses)', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'validate' => 'html_custom',
            'default' => '<p>Some HTML is allowed in here.</p>',
            'allowed_html' => array(
                'a' => array(
                    'href' => array(),
                    'title' => array()
                ),
                'br' => array(),
                'em' => array(),
                'strong' => array()
            ) //see http://codex.wordpress.org/Function_Reference/wp_kses
        ),
        array(
            'id' => 'opt-textarea-js',
            'type' => 'textarea',
            'title' => __('Textarea Option - JS Validated', 'bcn-theme'),
            'subtitle' => __('JS will be escaped', 'bcn-theme'),
            'desc' => __('This is the description field, again good for additional info.', 'bcn-theme'),
            'validate' => 'js'
        ),
    )
));
// -> START Required
Redux::setSection($opt_name, array(
    'title' => __('Field Required / Linking', 'bcn-theme'),
    'id' => 'required',
    'desc' => __('For full documentation on validation, visit: ', 'bcn-theme') . '<a href="//docs.reduxframework.com/core/the-basics/required/" target="_blank">docs.reduxframework.com/core/the-basics/required/</a>',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-required-basic',
            'type' => 'switch',
            'title' => 'Basic Required Example',
            'subtitle' => 'Click <code>On</code> to see the text field appear.',
            'default' => false
        ),
        array(
            'id' => 'opt-required-basic-text',
            'type' => 'text',
            'title' => 'Basic Text Field',
            'subtitle' => 'This text field is only show when the above switch is set to <code>On</code>, using the <code>required</code> argument.',
            'required' => array('opt-required-basic', '=', true)
        ),
        array(
            'id' => 'opt-required-divide-1',
            'type' => 'divide'
        ),
        array(
            'id' => 'opt-required-nested',
            'type' => 'switch',
            'title' => 'Nested Required Example',
            'subtitle' => 'Click <code>On</code> to see another set of options appear.',
            'default' => false
        ),
        array(
            'id' => 'opt-required-nested-buttonset',
            'type' => 'button_set',
            'title' => 'Multiple Nested Required Examples',
            'subtitle' => 'Click any buton to show different fields based on their <code>required</code> statements.',
            'options' => array(
                'button-text' => 'Show Text Field',
                'button-textarea' => 'Show Textarea Field',
                'button-editor' => 'Show WP Editor',
                'button-ace' => 'Show ACE Editor'
            ),
            'required' => array('opt-required-nested', '=', true),
            'default' => 'button-text'
        ),
        array(
            'id' => 'opt-required-nested-text',
            'type' => 'text',
            'title' => 'Nested Text Field',
            'required' => array('opt-required-nested-buttonset', '=', 'button-text')
        ),
        array(
            'id' => 'opt-required-nested-textarea',
            'type' => 'textarea',
            'title' => 'Nested Textarea Field',
            'required' => array('opt-required-nested-buttonset', '=', 'button-textarea')
        ),
        array(
            'id' => 'opt-required-nested-editor',
            'type' => 'editor',
            'title' => 'Nested Editor Field',
            'required' => array('opt-required-nested-buttonset', '=', 'button-editor')
        ),
        array(
            'id' => 'opt-required-nested-ace',
            'type' => 'ace_editor',
            'title' => 'Nested ACE Editor Field',
            'required' => array('opt-required-nested-buttonset', '=', 'button-ace')
        ),
        array(
            'id' => 'opt-required-divide-2',
            'type' => 'divide'
        ),
        array(
            'id' => 'opt-required-select',
            'type' => 'select',
            'title' => 'Select Required Example',
            'subtitle' => 'Select a different option to display its value.  Required may be used to display multiple & reusable fields',
            'options' => array(
                'no-sidebar' => 'No Sidebars',
                'left-sidebar' => 'Left Sidebar',
                'right-sidebar' => 'Right Sidebar',
                'both-sidebars' => 'Both Sidebars'
            ),
            'default' => 'no-sidebar',
            'select2' => array('allowClear' => false)
        ),
        array(
            'id' => 'opt-required-select-left-sidebar',
            'type' => 'select',
            'title' => 'Select Left Sidebar',
            'data' => 'sidebars',
            'default' => '',
            'required' => array('opt-required-select', '=', array('left-sidebar', 'both-sidebars'))
        ),
        array(
            'id' => 'opt-required-select-right-sidebar',
            'type' => 'select',
            'title' => 'Select Right Sidebar',
            'data' => 'sidebars',
            'default' => '',
            'required' => array('opt-required-select', '=', array('right-sidebar', 'both-sidebars'))
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('WPML Integration', 'bcn-theme'),
    'desc' => __('These fields can be fully translated by WPML (WordPress Multi-Language). This serves as an example for you to implement. For extra details look at our <a href="//docs.reduxframework.com/core/advanced/wpml-integration/" target="_blank">WPML Implementation</a> documentation.', 'bcn-theme'),
    'subsection' => true,
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
    'fields' => array(
        array(
            'id' => 'wpml-text',
            'type' => 'textarea',
            'title' => __('WPML Text', 'bcn-theme'),
            'desc' => __('This string can be translated via WPML.', 'bcn-theme'),
        ),
        array(
            'id' => 'wpml-multicheck',
            'type' => 'checkbox',
            'title' => __('WPML Multi Checkbox', 'bcn-theme'),
            'desc' => __('You can literally translate the values via key.', 'bcn-theme'),
            //Must provide key => value pairs for multi checkbox options
            'options' => array(
                '1' => 'Option 1',
                '2' => 'Option 2',
                '3' => 'Option 3'
            ),
        ),
    )
));
Redux::setSection($opt_name, array(
    'icon' => 'el el-list-alt',
    'title' => __('Customizer Only', 'bcn-theme'),
    'desc' => __('<p class="description">This Section should be visible only in Customizer</p>', 'bcn-theme'),
    'customizer_only' => true,
    'fields' => array(
        array(
            'id' => 'opt-customizer-only',
            'type' => 'select',
            'title' => __('Customizer Only Option', 'bcn-theme'),
            'subtitle' => __('The subtitle is NOT visible in customizer', 'bcn-theme'),
            'desc' => __('The field desc is NOT visible in customizer.', 'bcn-theme'),
            'customizer_only' => true,
            //Must provide key => value pairs for select options
            'options' => array(
                '1' => 'Opt 1',
                '2' => 'Opt 2',
                '3' => 'Opt 3'
            ),
            'default' => '2'
        ),
    )
));
if (file_exists(dirname(__FILE__) . '/../README.md')) {
    $section = array(
        'icon' => 'el el-list-alt',
        'title' => __('Documentation', 'bcn-theme'),
        'fields' => array(
            array(
                'id' => '17',
                'type' => 'raw',
                'markdown' => true,
                'content_path' => dirname(__FILE__) . '/../README.md', // FULL PATH, not relative please
                //'content' => 'Raw content here',
            ),
        ),
    );
    Redux::setSection($opt_name, $section);
}
/*
 * <--- END SECTIONS
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
            'title' => __('Section via hook', 'bcn-theme'),
            'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'bcn-theme'),
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

/**
 * Removes the demo link and the notice of integrated demo from the redux-framework plugin
 */
if (!function_exists('remove_demo')) {
    function remove_demo()
    {
        // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
        if (class_exists('ReduxFrameworkPlugin')) {
            remove_filter('plugin_row_meta', array(
                ReduxFrameworkPlugin::instance(),
                'plugin_metalinks'
            ), null, 2);

            // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
            remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
        }
    }
}

