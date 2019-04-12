<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package bcn
 */

global $theme_options;
get_header();
?>

	<main class="content-area page-main page-main--about-06" id="primary">

		<section class="error-404 not-found post-block-06 theme-about-light-gray">

			<section class="post-widget theme-widget-white"
					 data-uk-scrollspy="target: > article; cls:uk-animation-slide-top-small; delay: 500">

				<?php

				$args = array(
					'numberposts' => '4',
					'post_type' => 'post',
					'post_status' => 'publish',
				);

				$recent_posts = wp_get_recent_posts($args);
				foreach ($recent_posts as $recent) {
					echo '<article class="post-widget__item">';
					$thelist = '';
					$i = 0;
					echo '<span class="post-widget-link-wrapper">';
					foreach (get_the_category($recent["ID"]) as $category) {
						if (0 < $i) $thelist .= ' ';
						$thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="button button--accent-color button--sm ' . $category->slug . '">' . $category->name . '</a>';
						if (++$i == 2) break;
					}
					echo $thelist;
					echo '</span>';
					echo '<h2 class="post-widget__title"><a class="post-widget__title-link" href="' . get_permalink($recent["ID"]) . '">' . $recent["post_title"] . '</a> </h2> ';
					echo '<footer class="post-widget__footer"><span class="post-widget__date">' . date_i18n('d F Y', strtotime($recent['post_date'])) . '</span></footer> ';
					echo '</article>';
				}
				wp_reset_query();
				?>


			</section>

			<article class="post-block-06__item uk-animation-slide-bottom-medium">

				<h1 class="post-block-06__header">
					<?php
					if (isset($theme_options['404-heading'])) {
						echo esc_html__($theme_options['404-heading']);

					} else {
						echo __("Oops! That page can&rsquo;t be found.", 'bcn');
					}
					?>
				</h1>


				<p class="post-block-06__text">
					<?php
					if (isset($theme_options['404-text'])) {
						echo esc_html__($theme_options['404-text']);

					} else {
						echo __("It looks like nothing was found at this location. Maybe try the link below or a search?", 'bcn');
					}
					?>
				</p>

				<span class="post-block-06__wrapper-link">
					<a class="button button--big button--accent-color" href="
						<?php
					if (isset($theme_options['404-button-link'])) {
						echo esc_html__($theme_options['404-button-link']);

					} else {
						echo "/";
					}
					?>">

					<?php
					if (isset($theme_options['404-button-text'])) {
						echo esc_html__($theme_options['404-button-text']);

					} else {
						echo "Go Home";
					}
					?>
					</a>
				</span>

				<p class="post-block-06__text"><img class="uk-margin-medium-bottom error-404__image"
													src="<?php echo get_template_directory_uri() ?>/images/404.png"
													alt="404 error"></p>

			</article>
			<!-- .page-content -->

		</section>
		<!-- .error-404 -->
	</main>
	<!-- #primary -->

<?php
get_footer();
