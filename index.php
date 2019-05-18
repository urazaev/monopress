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

// Sidebar var
$page_sidebar =  get_post_meta(get_the_ID(),'meta_page-template-sidebar',true);

if (!isset($page_sidebar) || $page_sidebar == '-1' || $page_sidebar == '') {
	$page_sidebar = isset( $theme_options['page-template-sidebar'] ) ? $theme_options['page-template-sidebar'] : '';
}

// Featured cat var
$featured_category =  get_post_meta(get_the_ID(),'meta_main-page-featured-cat',true);

//if (!isset($featured_category) || $featured_category == '-1' || $featured_category == '') {
//	$featured_category = isset( $theme_options['main-page-featured-cat'] ) ? $theme_options['main-page-featured-cat'] : '';
//}

print_r($featured_category);

// Featured num
$featured_num =  get_post_meta(get_the_ID(),'meta_main-page-featured-num',true);

if (!isset($featured_num) || $featured_num == '-1' || $featured_num == '') {
	$featured_num = isset( $theme_options['main-page-featured-num'] ) ? $theme_options['main-page-featured-num'] : '';
}

print_r($featured_num);


// Featured layout
$featured_layout =  get_post_meta(get_the_ID(),'meta_main-page-featured-display',true);

if (!isset($featured_layout) || $featured_layout == '-1' || $featured_layout == '') {
	$featured_layout = isset( $theme_options['main-page-featured-display'] ) ? $theme_options['main-page-featured-display'] : '';
}

print_r($featured_layout);

// Post layout
$regular_layout =  get_post_meta(get_the_ID(),'meta_main-page-display',true);


if (!isset($regular_layout) || $regular_layout == '-1' || $regular_layout == '') {
	$regular_layout = isset( $theme_options['main-page-display'] ) ? $theme_options['main-page-display'] : '';
}

print_r($regular_layout);

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
//					if (is_home() && !is_paged()) {
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
							echo 'data-uk-scrollspy="target: > article; cls:uk-animation-slide-left; delay: 800"';
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
										'order' => 'ASC',
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
//					}

					wp_reset_postdata();

				}

				//	Main page post loop

				if (have_posts()) : ?>
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
					} ?>" id="loop-content"
						<?php if ($regular_layout == 4 || 07 || 14 || 21 || 22) {
							echo 'data-uk-scrollspy="target: > article; cls:uk-animation-slide-left;"';
						} ?>>

						<?php

						if ($regular_layout == 5) { ?>

						<div class="post-block-05__content">
							<div class="single-slider-item">

								<?php

								}

								while (have_posts()) :
									the_post();

									$post_id = get_the_ID();
									$category_object = get_the_category($post_id);
									$category_name = $category_object[0]->name;

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

								endwhile;

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

					$adv_block_3 = isset($theme_options['ads-block3']) ? $theme_options['ads-block3'] : '';
					echo do_shortcode($adv_block_3);

					if ($theme_options['main-page-pagination'] == 1) {
						the_posts_pagination(array(
							'mid_size' => 2,
							'prev_text' => __('«'),
							'next_text' => __('»'),
						));
					}
					?>
					</section>
				<?php

				else :?>
					<article class="archive__notfound-wrapper uk-animation-slide-bottom-medium">

						<h1 class="post-block-06__header archive__header">
							<?php esc_html_e('Nothing Found', 'bcn'); ?>
						</h1>
						<div class="post-block-06__text archive__text">
							<p>
								<?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'bcn'); ?></p>
						</div>
					</article>
				<?php
				endif;



			} ?>

		</div>

		<?php if ($page_sidebar == 3) {
			get_sidebar();
		} ?>

	</main>

<?php
get_footer();



