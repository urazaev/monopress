<?php
/**
 * The main template file
 * Template Name: Main page template
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

// Sidebar
$page_sidebar = get_post_meta(get_the_ID(), 'meta_page-template-sidebar', true);

if (!isset($page_sidebar) || $page_sidebar == '-1' || $page_sidebar == '') {
	$page_sidebar = isset($theme_options['main-page-sidebar']) ? $theme_options['main-page-sidebar'] : '';
}

// Featured cat
$featured_category = get_post_meta(get_the_ID(), 'meta_main-page-featured-cat', true);

if (!isset($featured_category) || $featured_category == '-1' || $featured_category == '') {
	$featured_category = isset($theme_options['main-page-featured-cat']) ? $theme_options['main-page-featured-cat'] : '';
}

// Featured num
$featured_num = get_post_meta(get_the_ID(), 'meta_main-page-featured-num', true);

if (!isset($featured_num) || $featured_num == '-1' || $featured_num == '') {
	$featured_num = isset($theme_options['main-page-featured-num']) ? $theme_options['main-page-featured-num'] : '';
}

// Featured layout
$featured_layout = get_post_meta(get_the_ID(), 'meta_main-page-featured-display', true);

if (!isset($featured_layout) || $featured_layout == '-1' || $featured_layout == '') {
	$featured_layout = isset($theme_options['main-page-featured-display']) ? $theme_options['main-page-featured-display'] : '';
}

// Post layout
$regular_layout = get_post_meta(get_the_ID(), 'meta_main-page-display', true);

if (!isset($regular_layout) || $regular_layout == '-1' || $regular_layout == '') {
	$regular_layout = isset($theme_options['main-page-display']) ? $theme_options['main-page-display'] : '';
}

?>

	<main class="page-main page-main--home-02 sidebar-parent" id="main">
		<?php if ($page_sidebar == 2) {
			get_sidebar();
		}
		?>
		<div class="mainpage">

			<?php

			$adv_block_2 = isset($theme_options['ads-block2']) ? $theme_options['ads-block2'] : '';
			echo do_shortcode($adv_block_2);

			// Main page featured posts

			if (class_exists('ReduxFramework')) {
				if ($theme_options['main-page-featured'] == 1) {
					if (!is_paged()) {
					?>
					<section class="post-block-<?php switch ($featured_layout) {
						case 2:
							echo esc_html('02');
							break;
						case 4:
							echo esc_html('04');
							break;
						case 5:
							echo esc_html('05');
							break;
						case 7:
							echo esc_html('07');
							break;
						case 14:
							echo esc_html('14');
							break;
						case 21:
							echo esc_html('21');
							break;

						case 22:
							echo esc_html('22');
							break;
					} ?>"
							 id="loop-content"<?php if ($featured_layout == 4 || 07 || 14 || 21 || 22) {
						echo 'data-uk-scrollspy="target: > article; cls:uk-animation-slide-left-small; delay: 600"';
					} ?>>

						<?php

						if ($featured_layout == 5) { ?>

						<div class="post-block-05__content">
							<div class="single-slider-item">

								<?php
								}

								// WP_Query arguments
								$args = array(
									'ignore_sticky_posts' => true,
									'order' => 'DESC',
									'orderby' => 'date',
									'post_type' => array('post'),
									'cat' => $featured_category,
									'posts_per_page' => $featured_num,
								);

								$featured = new WP_Query($args);

								if ($featured->have_posts()) {
									while ($featured->have_posts()) {
										$featured->the_post();
										switch ($featured_layout) {

											case 2:
												up_get_template('post-block-02');
												break;

											case 4:
												up_get_template('post-block-04');
												break;

											case 5:
												up_get_template('post-block-05');
												// TODO: slider pagination? or infinite?
												break;

											case 7:
												up_get_template('post-block-07');
												break;

											case 14:
												up_get_template('post-block-14');
												break;

											case 21:
												up_get_template('post-block-21');
												break;

											case 22:
												up_get_template('post-block-22');
												break;
										}
									}
								}

								if ($featured_layout == 5) { ?>

							</div>

							<div class="control-05 owl-nav uk-animation-fade theme-light-gray">
								<div class="control-05__control-slider">
									<button class="control-05__prev-link slick-custom-prev" type="button">
				          <span class="control-05__prev-img" data-uk-icon="chevron-up">
				          </span>
									</button>
									<button class="control-05__next-link slick-custom-next" type="button">
				          <span class="control-05__next-img" data-uk-icon="chevron-down">
				          </span>
									</button>
								</div>

							</div>
						</div>

					<?php

					}
					?>

					</section>
					<?php
					}

					wp_reset_postdata();

				}

				// Main page regular posts temp

				?>

				<section class="post-block-<?php switch ($regular_layout) {
					case 2:
						echo esc_html('02');
						break;
					case 4:
						echo esc_html('04');
						break;
					case 5:
						echo esc_html('05');
						break;
					case 7:
						echo esc_html('07');
						break;
					case 14:
						echo esc_html('14');
						break;
					case 21:
						echo esc_html('21');
						break;

					case 22:
						echo esc_html('22');
						break;
				} ?>" id="loop-content"<?php if ($regular_layout == 4 || 07 || 14 || 21 || 22) {
					echo 'data-uk-scrollspy="target: > article; cls:uk-animation-slide-left-small; delay: 800"';
				} ?>>

					<?php

					if ($regular_layout == 5) { ?>

					<div class="post-block-05__content">
						<div class="single-slider-item">

							<?php
							}
							$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

							// WP_Query arguments
							$args = array(
								'order' => 'DESK',
								'orderby' => 'date',
								'post_type' => array('post'),
							);

							$regular = new WP_Query($args);

							if ($regular->have_posts()) {
								while ($regular->have_posts()) {
									$regular->the_post();
									switch ($regular_layout) {

										case 2:
											up_get_template('post-block-02');
											break;

										case 4:
											up_get_template('post-block-04');
											break;

										case 5:
											up_get_template('post-block-05');
											// TODO: slider pagination? or infinite?
											break;

										case 7:
											up_get_template('post-block-07');
											break;

										case 14:
											up_get_template('post-block-14');
											break;

										case 21:
											up_get_template('post-block-21');
											break;

										case 22:
											up_get_template('post-block-22');
											break;
									}
								}
							}

							if ($regular_layout == 5) { ?>

						</div>

						<div class="control-05 owl-nav uk-animation-fade theme-light-gray">
							<div class="control-05__control-slider">
								<button class="control-05__prev-link slick-custom-prev" type="button">
				          <span class="control-05__prev-img" data-uk-icon="chevron-up">
				          </span>
								</button>
								<button class="control-05__next-link slick-custom-next" type="button">
				          <span class="control-05__next-img" data-uk-icon="chevron-down">
				          </span>
								</button>
							</div>

						</div>
					</div>

				<?php

				}
				wp_reset_postdata();

				$adv_block_3 = isset($theme_options['ads-block3']) ? $theme_options['ads-block3'] : '';
				echo do_shortcode($adv_block_3);

				if ($theme_options['main-page-pagination'] == 1) {
					$GLOBALS['wp_query']->max_num_pages = $regular->max_num_pages;

					the_posts_pagination(array(
						'mid_size' => 2,
						'prev_text' => __('«'),
						'next_text' => __('»'),
					));
				}
				?>

				</section>


			<?php } ?>

		</div>

		<?php if ($page_sidebar == 3) {
			get_sidebar();
		} ?>

	</main>

<?php
get_footer();



