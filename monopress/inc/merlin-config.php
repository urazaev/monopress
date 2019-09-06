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
		'admin-menu' => esc_html__('Theme Setup', 'monopress'),

		/* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
		'title%s%s%s%s' => esc_html__('%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'monopress'),
		'return-to-dashboard' => esc_html__('Return to the dashboard', 'monopress'),
		'ignore' => esc_html__('Disable this wizard', 'monopress'),

		'btn-skip' => esc_html__('Skip', 'monopress'),
		'btn-next' => esc_html__('Next', 'monopress'),
		'btn-start' => esc_html__('Start', 'monopress'),
		'btn-no' => esc_html__('Cancel', 'monopress'),
		'btn-plugins-install' => esc_html__('Install', 'monopress'),
		'btn-child-install' => esc_html__('Install', 'monopress'),
		'btn-content-install' => esc_html__('Install', 'monopress'),
		'btn-import' => esc_html__('Import', 'monopress'),
		'btn-license-activate' => esc_html__('Activate', 'monopress'),
		'btn-license-skip' => esc_html__('Later', 'monopress'),

		/* translators: Theme Name */
		'license-header%s' => esc_html__('Activate %s', 'monopress'),
		/* translators: Theme Name */
		'license-header-success%s' => esc_html__('%s is Activated', 'monopress'),
		/* translators: Theme Name */
		'license%s' => esc_html__('Enter your license key to enable remote updates and theme support.', 'monopress'),
		'license-label' => esc_html__('License key', 'monopress'),
		'license-success%s' => esc_html__('The theme is already registered, so you can go to the next step!', 'monopress'),
		'license-json-success%s' => esc_html__('Your theme is activated! Remote updates and theme support are enabled.', 'monopress'),
		'license-tooltip' => esc_html__('Need help?', 'monopress'),

		/* translators: Theme Name */
		'welcome-header%s' => esc_html__('Welcome to %s', 'monopress'),
		'welcome-header-success%s' => esc_html__('Hi. Welcome back', 'monopress'),
		'welcome%s' => esc_html__('This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'monopress'),
		'welcome-success%s' => esc_html__('You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'monopress'),

		'child-header' => esc_html__('Install Child Theme', 'monopress'),
		'child-header-success' => esc_html__('You\'re good to go!', 'monopress'),
		'child' => esc_html__('Let\'s build & activate a child theme so you may easily make theme changes.', 'monopress'),
		'child-success%s' => esc_html__('Your child theme has already been installed and is now activated, if it wasn\'t already.', 'monopress'),
		'child-action-link' => esc_html__('Learn about child themes', 'monopress'),
		'child-json-success%s' => esc_html__('Awesome. Your child theme has already been installed and is now activated.', 'monopress'),
		'child-json-already%s' => esc_html__('Awesome. Your child theme has been created and is now activated.', 'monopress'),

		'plugins-header' => esc_html__('Install Plugins', 'monopress'),
		'plugins-header-success' => esc_html__('You\'re up to speed!', 'monopress'),
		'plugins' => esc_html__('Let\'s install some essential WordPress plugins to get your site up to speed.', 'monopress'),
		'plugins-success%s' => esc_html__('The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'monopress'),
		'plugins-action-link' => esc_html__('Advanced', 'monopress'),

		'import-header' => esc_html__('Import Content', 'monopress'),
		'import' => esc_html__('Let\'s import content to your website, to help you get familiar with the theme.', 'monopress'),
		'import-action-link' => esc_html__('Advanced', 'monopress'),

		'ready-header' => esc_html__('All done. Have fun!', 'monopress'),

		/* translators: Theme Author */
		'ready%s' => esc_html__('Your theme has been all set up. Enjoy your new theme by %s.', 'monopress'),
		'ready-action-link' => esc_html__('Extras', 'monopress'),
		'ready-big-button' => esc_html__('View your website', 'monopress'),
		'ready-link-1' => sprintf('<a href="%1$s" target="_blank">%2$s</a>', 'https://wordpress.org/support/', esc_html__('Explore WordPress', 'monopress')),
		'ready-link-2' => sprintf('<a href="%1$s" target="_blank">%2$s</a>', 'https://urazaev.com/contact/', esc_html__('Get Theme Support', 'monopress')),
		'ready-link-3' => sprintf('<a href="%1$s">%2$s</a>', admin_url('customize.php'), esc_html__('Start Customizing', 'monopress')),
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
			'import_file_url' => 'https://monopress.urazaev.com/demos/__1__content.xml',
			'import_widget_file_url' => 'https://monopress.urazaev.com/demos/__1__widgets.json',
			'import_redux' => array(
				array(
					'file_url' => 'https://monopress.urazaev.com/demos/__1__redux.json',
					'option_name' => 'theme_options',
				),
			),
			'preview_url' => 'https://monopress.urazaev.com/',
		),
	);
}

add_filter('merlin_import_files', 'merlin_import_files');


/**
 * Execute custom code after the whole import has finished.
 */
function monopress_merlin_after_import_setup()
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

add_action('merlin_after_all_import', 'monopress_merlin_after_import_setup');

function monopress_merlin_unset_default_widgets_args($widget_areas)
{
	$widget_areas = array(
		'up-sidebar-default' => array(),
	);
	return $widget_areas;
}

add_filter('merlin_unset_default_widgets_args', 'monopress_merlin_unset_default_widgets_args');
