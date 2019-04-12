<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package bcn
 */

get_header();
global $theme_options;
?>

	<main class="content-area page-main" id="primary">

		<section class="row no-gutters search-page">
			<?php if ($theme_options['category-sidebar'] == 2) { ?>
				<aside class="col col-md-3 post-widget sidebar search-page__sidebar">
					<div class="sidebar__inner search-page-sidebar__inner"
						 data-uk-scrollspy="target: > article; cls:uk-animation-slide-left-small; delay: 500">
						<?php dynamic_sidebar('up-sidebar-default'); ?>
					</div>
				</aside>
			<?php } ?>

			<div class="<?php if ($theme_options['category-sidebar'] == 1) {
				echo "col-md-12";
			} else {
				echo "col-md-9";
			} ?> post-block-06__item search-page__item uk-animation-slide-bottom-medium">


				<div class="post-block-06__text search-page__text">
					<?php get_search_form(); ?>
				</div>

				<?php if (have_posts()) : ?>

					<h1 class="post-block-06__header search-page__header">
						<?php
						/* translators: %s: search query. */
						printf(esc_html__('Search Results for: %s', 'bcn'), '<span>' . get_search_query() . '</span>');
						?>
					</h1>

					<?php
					/* Start the Loop */
					while (have_posts()) :
						the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */

						get_template_part('template-parts/content', 'search');

					endwhile;
					if (class_exists('ReduxFramework')) {

						if ($theme_options['category-pagination'] == 1) {
							the_posts_pagination(array(
								'mid_size' => 2,
								'prev_text' => __('«'),
								'next_text' => __('»'),
							));
						}
					};
				else :
					get_template_part('template-parts/content', 'none');
				endif;
				?>

			</div>
			<!-- .page-content -->

			<?php if ($theme_options['category-sidebar'] == 3) { ?>
				<aside class="col col-md-3 post-widget sidebar search-page__sidebar">
					<div class="sidebar__inner search-page-sidebar__inner"
						 data-uk-scrollspy="target: > article; cls:uk-animation-slide-left-small; delay: 500">
						<?php dynamic_sidebar('up-sidebar-default'); ?>
					</div>
				</aside>
			<?php } ?>

		</section>
	</main>
	<!-- #primary -->

<?php
get_sidebar();
get_footer();
