<?php
/**
 * Template part for displaying post category 02
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcn
 */

global $theme_options;

echo "post-block-11";

?>

<section class="post-block-11" data-uk-scrollspy="target: > article; cls:uk-animation-slide-top-medium; delay: 500">

	<?php if (have_posts()) :
		while (have_posts()) : the_post();

			$post_id = get_the_ID();
			$category_object = get_the_category($post_id);
			$category_name = $category_object[0]->name;

			?>

			<article class="post-block-11__item">
				<header class="post-block-11__date">
					<p class="post-block-11__date-item has-animation animation-rtl"
					>
						<?php if ($theme_options['block-settings-meta-date'] == 1) {
							; ?>
							<time
								datetime="<?php echo get_the_date('c') ?>"><?php echo get_the_date('M j, y') ?></time> <?php }
						if ($theme_options['block-settings-meta-author'] == 1) { ?>By <a
							href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a><?php } ?>
					</p>
				</header>
				<figure class="post-block-11__img has-animation animation-rtl">
					<?php if (has_post_thumbnail()) { ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail('post_block_11', array('class' => 'post-block-11__img-item')); ?>
						</a>
					<?php } else { ?>
						<a href="<?php the_permalink() ?>">
							<img class="post-block-11__img-item"
								 src="<?php echo get_template_directory_uri() ?>/images/placeholder-590-375.png"
								 srcset="<?php echo get_template_directory_uri() ?>/images/placeholder-590-375@2x.png 2x"
								 alt="Post picture">
						</a>
					<?php } ?>
				</figure>
				<footer class="post-block-11__footer">
					<div class="post-block-11__footer-wrapper has-animation animation-ltr">
						<div class="post-block-11__footer-bg">
              <span class="post-block-11__wrapper-link">
					<?php
					$thelist = '';
					$i = 0;
					foreach (get_the_category() as $category) {
						if (0 < $i) $thelist .= ' ';
						$thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="button button--brown' . $category->slug . '">' . $category->name . '</a>';
						$i++;
					}
					echo $thelist; ?>
              </span>
							<h2 class="post-block-11__header"><a class="post-block-11__header-link"
																 href="<?php the_permalink() ?>"><?php the_title() ?></a>
							</h2>
							<?php
							if (class_exists('ReduxFramework')) {
								if ($theme_options['block-settings-meta-comments'] == 1) { ?>

									<p class="post-block-02__comments-count">Comments:
										<?php echo get_comments_number(); ?></p>
									<?php
								}
							}
							?>

						</div>
					</div>
				</footer>
			</article>

		<?php endwhile;
		if (class_exists('ReduxFramework')) {

			if ($theme_options['category-pagination'] == 1) {
				the_posts_pagination(array(
					'mid_size' => 2,
					'prev_text' => __('«'),
					'next_text' => __('»'),
				));
			}
		}
	endif; ?>

</section>

