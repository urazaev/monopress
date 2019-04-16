<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcn
 */

global $theme_options;

get_header();
?>

		<main class="page-main page-main--home-02 sidebar-parent" id="main">
			<?php if ($theme_options['category-sidebar'] == 2) {
				get_sidebar();
			} ?>

			<div class="control-scroll-only control-scroll-only--vpright">
				<button class="control-scroll-only__scroll-button" id="scroll-button" type="button">Scroll</button>
			</div>

			<?php
			if (class_exists('ReduxFramework')) {
				switch ($theme_options['block-settings-display']) {
					case 2:
						up_get_template('post-block-02');
						break;
					case 3:
						up_get_template('post-block-03');
						break;
					case 4:
						up_get_template('post-block-04');
						break;
					case 5:
						up_get_template('post-block-05');
						break;
					case 6:
						up_get_template('post-block-06');
						break;
					case 7:
						up_get_template('post-block-07');
						break;
					case 9:
						up_get_template('post-block-09');
						break;
					case 11:
						up_get_template('post-block-11');
						break;
					case 12:
						up_get_template('post-block-12');
						break;
					case 14:
						up_get_template('post-block-14');
						break;
					case 16:
						up_get_template('post-block-16');
						break;
					case 18:
						up_get_template('post-block-18');
						break;
					case 19:
						up_get_template('post-block-19');
						break;
					case 21:
						up_get_template('post-block-21');
						break;
				}
			}
			if ($theme_options['category-pagination'] == 2) { ?>
				<a id="inifiniteLoader"><img src="<?php bloginfo('template_directory');?>/images/ajax-loader.gif" alt="loading..."/>
					Loading more...</a>
			<?php }

			if ($theme_options['category-sidebar'] == 3) {
				get_sidebar();
			} ?>

		</main>

<?php
get_footer();



