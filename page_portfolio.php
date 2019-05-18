<?php
/**
 * Template Name: Portfolio template
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bcn
 */

global $theme_options;
get_header();

$page_sidebar =  get_post_meta(get_the_ID(),'meta_page-template-sidebar',true);

if (!isset($page_sidebar) || $page_sidebar == '-1' || $page_sidebar == '') {
	$page_sidebar = isset( $theme_options['portfolio-sidebar'] ) ? $theme_options['portfolio-sidebar'] : '1';
}
?>
	<main class="page-main sidebar-parent">
		<?php if ($page_sidebar == 2) {
			get_sidebar();
		}

		if (class_exists('ReduxFramework')) {
			if ($theme_options['portfolio-template-default'] == '1') {
				get_template_part('template-parts/page_portfolio_masonry');
			}

			if ($theme_options['portfolio-template-default'] == '2') {
				get_template_part('template-parts/page_portfolio_grid');
			}
		}
		if ($page_sidebar == 3) {
			get_sidebar();
		} ?>
	</main>

<?php
get_footer();

