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

$page_sidebar = get_post_meta(get_the_ID(), 'meta_page-template-sidebar', true);

if (!isset($page_sidebar) || $page_sidebar == '-1' || $page_sidebar == '') {
	$page_sidebar = isset($theme_options['portfolio-sidebar']) ? $theme_options['portfolio-sidebar'] : 'sidebar_1';
}

$portfolio_layout = get_post_meta(get_the_ID(), 'meta_portfolio-template-default', true);

if (!isset($portfolio_layout) || $portfolio_layout == '-1' || $portfolio_layout == '') {
	$portfolio_layout = isset($theme_options['portfolio-template-default']) ? $theme_options['portfolio-template-default'] : 'layout_1';
}
?>
	<main class="page-main sidebar-parent">
		<?php if ($page_sidebar == 'sidebar_2') {
			get_sidebar();
		}

		if (class_exists('ReduxFramework')) {
			if ($portfolio_layout == 'layout_1') {
				get_template_part('template-parts/page_portfolio_masonry');
			}

			if ($portfolio_layout == 'layout_2') {
				get_template_part('template-parts/page_portfolio_grid');
			}
		}
		if ($page_sidebar == 'sidebar_3') {
			get_sidebar();
		} ?>
	</main>

<?php
get_footer();

