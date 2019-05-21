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

	<main class="content-area page-main page-main--about-06 sidebar-parent" id="primary">

		<section class="error-404 not-found post-block-06 theme-about-light-gray">

			<?php if ($theme_options['page-template-sidebar'] == 2) {
				get_sidebar();
			} ?>


			<article class="post-block-06__item uk-animation-slide-bottom-medium">

				<h1 class="post-block-06__header">
					<?php
					if (isset($theme_options['404-heading'])) {
						echo esc_html($theme_options['404-heading']);

					} else {
						echo __("Oops! That page can&rsquo;t be found.", 'bcn');
					}
					?>
				</h1>


				<p class="post-block-06__text">
					<?php
					if (isset($theme_options['404-text'])) {
						echo esc_html($theme_options['404-text']);

					} else {
						echo __("It looks like nothing was found at this location. Maybe try the link below or a search?", 'bcn');
					}
					?>
				</p>

				<span class="post-block-06__wrapper-link">
					<a class="button button--big" href="
						<?php
					if (isset($theme_options['404-button-link'])) {
						echo esc_html($theme_options['404-button-link']);

					} else {
						echo "/";
					}
					?>">

					<?php
					if (isset($theme_options['404-button-text'])) {
						echo esc_html($theme_options['404-button-text']);

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

			<?php if ($theme_options['page-template-sidebar'] == 3) {
				get_sidebar();
			} ?>

		</section>
		<!-- .error-404 -->
	</main>
	<!-- #primary -->

<?php
get_footer();
