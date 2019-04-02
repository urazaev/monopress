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

	<div id="primary" class="content-area">
		<main class="page-main page-main--post-08" id="main">
			<?php
			while (have_posts()) :
				if (class_exists('ReduxFramework')) {
					if ($theme_options['post-template-default'] == '1') {
						the_post();
						get_template_part('template-parts/content', get_post_type());
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
			?>
		</main>
		<!-- #main -->
	</div>
	<!-- #primary -->

<?php
get_sidebar();
get_footer();
