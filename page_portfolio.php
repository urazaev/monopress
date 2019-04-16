<?php
/**
 * Template Name: Default portfolio template
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bcn
 */

global $theme_options;
get_header();

?>

	<main class="page-main sidebar-parent">
		<?php if ($theme_options['portfolio-sidebar'] == 2) {
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
		if ($theme_options['portfolio-sidebar'] == 3) {
			get_sidebar();
		} ?>
	</main>

<?php
get_footer();

