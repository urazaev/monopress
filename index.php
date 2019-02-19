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

get_header();
?>
	<div class="up-container up-container--fullwidth up-container--home-02 theme-light-gray" id="primary">

		<main class="page-main page-main--home-02" id="main">
			<?php if ($theme_options['category-sidebar'] == 2) { ?>
				<aside class="post-widget theme-widget-white sidebar">
					<div class="sidebar__inner"
						 data-uk-scrollspy="target: > article; cls:uk-animation-slide-left-small; delay: 500">
						<?php dynamic_sidebar('up-sidebar-default'); ?>
					</div>
				</aside>
			<?php } ?>

			<div class="control-scroll-only control-scroll-only--vpright">
				<button class="control-scroll-only__scroll-button" id="scroll-button" type="button">Scroll</button>
			</div>

			<section class="post-block-02 theme-white" id="loop-content">
				<?php
				if (class_exists('ReduxFramework')) {
					switch ($theme_options['category-article-display']) {
						case 1:
							up_get_template('post-block-01');
							break;
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
						case 8:
							up_get_template('post-block-08');
							break;
						case 9:
							up_get_template('post-block-09');
							break;
					}
				}
				?>
				<?php if ($theme_options['category-pagination'] == 2) { ?>
					<a id="inifiniteLoader"><img src="<?php bloginfo('template_directory'); ?>/images/ajax-loader.gif"/>
						Loading more...</a>
				<?php } ?>
			</section>

			<?php if ($theme_options['category-sidebar'] == 3) { ?>
				<aside class="post-widget theme-widget-white sidebar">
					<div class="sidebar__inner"
						 data-uk-scrollspy="target: > article; cls:uk-animation-slide-left-small; delay: 500">
						<?php dynamic_sidebar('up-sidebar-default'); ?>
					</div>
				</aside>
			<?php } ?>

		</main>
	</div>

<?php
get_sidebar();
get_footer();



