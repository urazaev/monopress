<?php
/**
 * Merlin WP configuration file.
 *
 * @package   Merlin WP
 * @version   @@pkg.version
 * @link      https://merlinwp.com/
 * @author    Rich Tabor, from ThemeBeans.com & the team at ProteusThemes.com
 * @copyright Copyright (c) 2018, Merlin WP of Inventionn LLC
 * @license   Licensed GPLv3 for Open Source Use
 */

if (!class_exists('Merlin')) {
	return;
}

/**
 * Set directory locations, text strings, and settings.
 */
$wizard = new Merlin(

	$config = array(
		'directory' => 'inc/merlin', // Location / directory where Merlin WP is placed in your theme.
		'merlin_url' => 'merlin', // The wp-admin page slug where Merlin WP loads.
		'parent_slug' => 'themes.php', // The wp-admin parent page slug for the admin menu item.
		'capability' => 'manage_options', // The capability required for this menu to be displayed to the user.
		'child_action_btn_url' => 'https://codex.wordpress.org/child_themes', // URL for the 'child-action-link'.
		'dev_mode' => false, // Enable development mode for testing.
		'license_step' => false, // EDD license activation step.
		'license_required' => false, // Require the license activation step.
		'license_help_url' => '', // URL for the 'license-tooltip'.
		'edd_remote_api_url' => '', // EDD_Theme_Updater_Admin remote_api_url.
		'edd_item_name' => '', // EDD_Theme_Updater_Admin item_name.
		'edd_theme_slug' => '', // EDD_Theme_Updater_Admin item_slug.
		'ready_big_button_url' => '/', // Link for the big button on the ready step.
	),
	$strings = array(
		'admin-menu' => esc_html__('Theme Setup', 'bcn'),

		/* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
		'title%s%s%s%s' => esc_html__('%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'bcn'),
		'return-to-dashboard' => esc_html__('Return to the dashboard', 'bcn'),
		'ignore' => esc_html__('Disable this wizard', 'bcn'),

		'btn-skip' => esc_html__('Skip', 'bcn'),
		'btn-next' => esc_html__('Next', 'bcn'),
		'btn-start' => esc_html__('Start', 'bcn'),
		'btn-no' => esc_html__('Cancel', 'bcn'),
		'btn-plugins-install' => esc_html__('Install', 'bcn'),
		'btn-child-install' => esc_html__('Install', 'bcn'),
		'btn-content-install' => esc_html__('Install', 'bcn'),
		'btn-import' => esc_html__('Import', 'bcn'),
		'btn-license-activate' => esc_html__('Activate', 'bcn'),
		'btn-license-skip' => esc_html__('Later', 'bcn'),

		/* translators: Theme Name */
		'license-header%s' => esc_html__('Activate %s', 'bcn'),
		/* translators: Theme Name */
		'license-header-success%s' => esc_html__('%s is Activated', 'bcn'),
		/* translators: Theme Name */
		'license%s' => esc_html__('Enter your license key to enable remote updates and theme support.', 'bcn'),
		'license-label' => esc_html__('License key', 'bcn'),
		'license-success%s' => esc_html__('The theme is already registered, so you can go to the next step!', 'bcn'),
		'license-json-success%s' => esc_html__('Your theme is activated! Remote updates and theme support are enabled.', 'bcn'),
		'license-tooltip' => esc_html__('Need help?', 'bcn'),

		/* translators: Theme Name */
		'welcome-header%s' => esc_html__('Welcome to %s', 'bcn'),
		'welcome-header-success%s' => esc_html__('Hi. Welcome back', 'bcn'),
		'welcome%s' => esc_html__('This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'bcn'),
		'welcome-success%s' => esc_html__('You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'bcn'),

		'child-header' => esc_html__('Install Child Theme', 'bcn'),
		'child-header-success' => esc_html__('You\'re good to go!', 'bcn'),
		'child' => esc_html__('Let\'s build & activate a child theme so you may easily make theme changes.', 'bcn'),
		'child-success%s' => esc_html__('Your child theme has already been installed and is now activated, if it wasn\'t already.', 'bcn'),
		'child-action-link' => esc_html__('Learn about child themes', 'bcn'),
		'child-json-success%s' => esc_html__('Awesome. Your child theme has already been installed and is now activated.', 'bcn'),
		'child-json-already%s' => esc_html__('Awesome. Your child theme has been created and is now activated.', 'bcn'),

		'plugins-header' => esc_html__('Install Plugins', 'bcn'),
		'plugins-header-success' => esc_html__('You\'re up to speed!', 'bcn'),
		'plugins' => esc_html__('Let\'s install some essential WordPress plugins to get your site up to speed.', 'bcn'),
		'plugins-success%s' => esc_html__('The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'bcn'),
		'plugins-action-link' => esc_html__('Advanced', 'bcn'),

		'import-header' => esc_html__('Import Content', 'bcn'),
		'import' => esc_html__('Let\'s import content to your website, to help you get familiar with the theme.', 'bcn'),
		'import-action-link' => esc_html__('Advanced', 'bcn'),

		'ready-header' => esc_html__('All done. Have fun!', 'bcn'),

		/* translators: Theme Author */
		'ready%s' => esc_html__('Your theme has been all set up. Enjoy your new theme by %s.', 'bcn'),
		'ready-action-link' => esc_html__('Extras', 'bcn'),
		'ready-big-button' => esc_html__('View your website', 'bcn'),
		'ready-link-1' => sprintf('<a href="%1$s" target="_blank">%2$s</a>', 'https://wordpress.org/support/', esc_html__('Explore WordPress', 'bcn')),
		'ready-link-2' => sprintf('<a href="%1$s" target="_blank">%2$s</a>', 'https://urazaev.com/contact/', esc_html__('Get Theme Support', 'bcn')),
		'ready-link-3' => sprintf('<a href="%1$s">%2$s</a>', admin_url('customize.php'), esc_html__('Start Customizing', 'bcn')),
	)
);

/**
 * Define the demo import files (remote files).
 *
 * To define imports, you just have to add the following code structure,
 * with your own values to your theme (using the 'merlin_import_files' filter).
 */
function merlin_import_files()
{
	return array(
		array(
			'import_file_name' => 'Monopress demo',
			'import_file_url' => 'http://monopress.urazaev.com/demos/__1__content.xml',
			'import_widget_file_url' => 'http://monopress.urazaev.com/demos/__1__widgets.json',
			'import_redux' => array(
				array(
					'file_url' => 'http://monopress.urazaev.com/demos/__1__redux.json',
					'option_name' => 'theme_options',
				),
			),
			'preview_url' => 'http://monopress.urazaev.com/',
		),
	);
}

add_filter('merlin_import_files', 'merlin_import_files');


/**
 * Execute custom code after the whole import has finished.
 */
function bcn_merlin_after_import_setup()
{

	// Assign menus to their locations.
	$main_menu = get_term_by( 'name', 'up-demo-top-menu', 'nav_menu' );
	$footer_menu = get_term_by( 'name', 'up-demo-footer-menu', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
			'primary' => $main_menu->term_id,
			'footer' => $footer_menu->term_id,
		)
	);

}

add_action('merlin_after_all_import', 'bcn_merlin_after_import_setup');

function bcn_merlin_unset_default_widgets_args($widget_areas)
{
	$widget_areas = array(
		'up-sidebar-default' => array(),
	);
	return $widget_areas;
}

add_filter('merlin_unset_default_widgets_args', 'bcn_merlin_unset_default_widgets_args');
