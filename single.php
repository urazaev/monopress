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

//$post_layout_meta = get_post_meta( get_the_ID(), 'meta_post-template-default', true );
//$post_sidebar_meta = get_post_meta( get_the_ID(), 'meta_post-sidebar', true );
//
//$post_layout_theme_options = isset($theme_options['post-template-default']) ? $theme_options['post-template-default'] : '';
//$post_sidebar_theme_options = isset($theme_options['post-sidebar']) ? $theme_options['post-sidebar'] : '';
//
//$post_layout = isset($post_layout_meta)&&($post_layout_meta!='') ? $post_layout_meta : $post_layout_theme_options;
//$post_sidebar = isset($post_sidebar_meta)&&($post_sidebar_meta!='') ? $post_sidebar_meta : $post_sidebar_theme_options;


$post_sidebar =  get_post_meta(get_the_ID(),'meta_post-sidebar',true);

if (!isset($post_sidebar) || $post_sidebar == '-1' || $post_sidebar == '') {
	$post_sidebar = isset( $theme_options['post-sidebar'] ) ? $theme_options['post-sidebar'] : '1';
}

$post_layout =  get_post_meta(get_the_ID(),'meta_post-template-default',true);

if (!isset($post_layout) || $post_layout == '-1' || $post_layout == '') {
	$post_layout = isset( $theme_options['post-template-default'] ) ? $theme_options['post-template-default'] : '1';
}

?>

	<main class="row no-gutters page content-area page-main sidebar-parent post-row" id="primary">
		<?php if ($post_sidebar == 2) {
			?>
			<div class="col-md-3 post-template__side-wrapper">
				<?php
				get_sidebar();
				?>
			</div>
			<?php
		}

		while (have_posts()) :
			if (class_exists('ReduxFramework')) {
				if ($post_layout == 1) {
					the_post();
					get_template_part('template-parts/post-template-1', get_post_type());
				}

				if ($post_layout == 2) {
					the_post();
					get_template_part('template-parts/post-template-2', get_post_type());
				}

				if ($post_layout == 3) {
					the_post();
					get_template_part('template-parts/post-template-3', get_post_type());
				}
			}
		endwhile; // End of the loop.

		if ($post_sidebar == 3) {
			?>
			<div class="col-md-3">
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
