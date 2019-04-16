<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcn
 */

get_header();
global $theme_options;
?>
	<main class="row no-gutters page content-area page-main sidebar-parent" id="primary">
		<?php if ($theme_options['page-template-sidebar'] == 2) {
			get_sidebar();
		} ?>

		<section class="post-block-06__item page__item uk-animation-slide-bottom-medium content-area" id="main">
			<?php
			if ($theme_options['template-settings-breadcrumbs-show'] == 1) {
				the_breadcrumb('breadcrumbs breadcrumbs--inner-nottobbrdr');
			}
			while (have_posts()) :
				the_post();

				get_template_part('template-parts/content', 'page');

				if (class_exists('ReduxFramework')) {

					if ($theme_options['page-template-comments'] != 1) {

						// If comments are open or we have at least one comment, load up the comment template.
						if (comments_open() || get_comments_number()) :
							comments_template();
						endif;
					}
				}

			endwhile; // End of the loop.
			?>

		</section>
		<!-- .page-content -->

		<?php if ($theme_options['page-template-sidebar'] == 3) {
			get_sidebar();
		} ?>

	</main>
	<!-- #primary -->
<?php
get_footer();
