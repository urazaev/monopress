<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bcn
 */

global $theme_options;
get_header();

?>

	<main class="row no-gutters page content-area page-main sidebar-parent post-row" id="primary">
		<?php if ($theme_options['post-sidebar'] == 2) {
			?>
			<div class="col-md-4">
				<?php
				get_sidebar();
				?>
			</div>
			<?php
		}

		while (have_posts()) :
			if (class_exists('ReduxFramework')) {
				if ($theme_options['post-template-default'] == '1') {
					the_post();
					get_template_part('template-parts/post-template-1', get_post_type());
				}

				if ($theme_options['post-template-default'] == '2') {
					the_post();
					get_template_part('template-parts/post-template-2', get_post_type());
				}

				if ($theme_options['post-template-default'] == '3') {
					the_post();
					get_template_part('template-parts/post-template-3', get_post_type());
				}
			}
		endwhile; // End of the loop.

		if ($theme_options['post-sidebar'] == 3) {
			?>
			<div class="col-md-4">
				<?php
				get_sidebar();
				?>
			</div>
			<?php
		} ?>

	</main>
	<!-- #primary -->

<?php
get_footer();
