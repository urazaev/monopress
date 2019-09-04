<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcn
 */

global $theme_options;

get_header();
?>

	<main class="page-main page-main--home-02 sidebar-parent archive" id="main">
		<?php if ($theme_options['category-sidebar'] == 'sidebar_2') {
			get_sidebar();
		}

		if (class_exists('ReduxFramework')) {

			if (have_posts()) : ?>
				<section class="post-block-<?php switch ($theme_options['category-article-display']) {
					case  'layout_2':
						echo esc_html('02');
						break;
					case  'layout_4':
						echo esc_html('04');
						break;
					case  'layout_5':
						echo esc_html('05');
						break;
					case  'layout_7':
						echo esc_html('07');
						break;
					case  'layout_14':
						echo esc_html('14');
						break;
					case  'layout_21':
						echo esc_html('21');
						break;
				} ?>" id="loop-content" <?php if ($theme_options['category-article-display'] == 4 || 07 || 14 || 21) {
					echo 'data-uk-scrollspy="target: > article; cls:uk-animation-slide-left-small; delay: 800"';
				} ?>>

					<?php

					$adv_block_2 = isset($theme_options['ads-block2']) ? $theme_options['ads-block2'] : '';
					echo do_shortcode($adv_block_2);

					if ($theme_options['template-settings-breadcrumbs-show'] == 1) {
						the_breadcrumb('breadcrumbs breadcrumbs--inner breadcrumbs--inner-nottobbrdr');
					}
					the_archive_title('<h1 class="post-block-06__header archive__header">', '</h1>');
					the_archive_description('<div class="post-block-06__text archive__text">', '</div>');

					if ($theme_options['category-article-display'] == 5) { ?>

					<div class="post-block-05__content">
						<div class="single-slider-item">

							<?php

							}

							while (have_posts()) :
								the_post();

								$post_id = get_the_ID();
								$category_object = get_the_category($post_id);
								$category_name = $category_object[0]->name;

								switch ($theme_options['category-article-display']) {
									case  'layout_2':
										up_get_template('post-block-02');
										break;
									case  'layout_4':
										up_get_template('post-block-04');
										break;
									case  'layout_5':
										up_get_template('post-block-05');
										// TODO: slider pagination? or infinite?
										break;
									case  'layout_7':
										up_get_template('post-block-07');
										break;
									case  'layout_14':
										up_get_template('post-block-14');
										break;
									case  'layout_21':
										up_get_template('post-block-21');
										break;
								}

							endwhile;
							if ($theme_options['category-article-display'] == 5) { ?>

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

				if ($theme_options['category-pagination'] == 1) {
					the_posts_pagination(array(
						'mid_size' => 2,
						'prev_text' => __('«', 'bcn'),
						'next_text' => __('»', 'bcn'),
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
						<p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'bcn'); ?></p>
					</div>
				</article>
			<?php
			endif;

		}

		if ($theme_options['category-pagination'] == 2) { ?>
			<a id="inifiniteLoader"><img
					src="<?php echo esc_url(get_template_directory_uri()) ?>/images/ajax-loader.gif"
					alt="loading..."/>
				Loading more...</a>
		<?php }

		if ($theme_options['category-sidebar'] == 'sidebar_3') {
			get_sidebar();
		} ?>

	</main>

<?php
get_footer();



