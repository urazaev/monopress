<?php
/**
 * Template part for displaying post category 02
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcn
 */

global $theme_options;

if (have_posts()) : ?>

	<section class="post-block-05">
		<div class="single-slider-item">
			<?php
			while (have_posts()) : the_post(); ?>

				<div class="post-block-05__wrapper item">

					<figure class="post-block-05__img">

						<?php if (has_post_thumbnail()) { ?>
							<?php the_post_thumbnail('post_block_05', array('class' => 'post-block-05__img-item')); ?>
						<?php } else { ?>
							<img class="post-block-05__img-item"
								 src="<?php echo get_template_directory_uri() ?>/images/placeholder-1375-900.png"
								 srcset="<?php echo get_template_directory_uri() ?>/images/placeholder-1375-900@2x.png 2x"
								 alt="Post picture">
						<?php } ?>

					</figure>
					<article class="post-block-05__item theme-widget-white">
						<header class="post-block-05__date">
							<p class="post-block-05__date-wrapper">
								<?php if ($theme_options['block-settings-meta-date'] == 1) {
									; ?>
									<time
										datetime="<?php echo get_the_date('c') ?>"><?php echo get_the_date('M j, y') ?></time> <?php }
								if ($theme_options['block-settings-meta-author'] == 1) { ?>By <a
									href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a><?php } ?>
							</p>
						</header>

						<span class="post-block-05__wrapper-link uk-animation-slide-top-small">
						<?php
						$thelist = '';
						$i = 0;
						foreach (get_the_category() as $category) {
							if (0 < $i) $thelist .= ' ';
							$thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="button button--orange' . $category->slug . '">' . $category->name . '</a>';
							$i++;
						}
						echo $thelist; ?>
          		</span>
						<?php
						if (class_exists('ReduxFramework')) {
							if (($theme_options['block-settings-meta-comments'] == 1) && (comments_open() || get_comments_number())) { ?>

								<p class="post-block-05__comments-count">Comments:
									<?php echo get_comments_number(); ?></p>
								<?php
							}
						}
						?>
						<h2 class="post-block-05__header uk-animation-slide-bottom-small"><a
								class="post-block-05__header-link"
								href="<?php the_permalink() ?>"> <?php the_title() ?></a>
						</h2>
					</article>

				</div>

			<?php endwhile;

			//			if (class_exists('ReduxFramework')) {
			//				if ($theme_options['category-pagination'] == 1) {
			//					the_posts_pagination(array(
			//						'mid_size' => 2,
			//						'prev_text' => __('«'),
			//						'next_text' => __('»'),
			//					));
			//				}
			//			}
			?>
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
			<div class="control-05__wrapper">
        <span class="control-05__scroll">
          <button class="control-05__scroll-link slick-custom-next">or Scroll</button>
        </span>
			</div>
		</div>
	</section>

<?php
endif;

//			TODO: slider pagination? or infinite?
?>

