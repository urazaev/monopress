<?php
/**
 * Template part for displaying post category 02
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcn
 */

global $theme_options;

echo "09090909";
?>
<?php if (have_posts()) : ?>

	<section class="post-block-09">
		<div class="single-slider-item">
			<?php while (have_posts()) : the_post();

				$post_id = get_the_ID();
				$category_object = get_the_category($post_id);
				$category_name = $category_object[0]->name;

				?>
				<div class="post-block-09__wrapper item">
					<figure class="post-block-09__img">

						<?php if (has_post_thumbnail()) { ?>
							<a class="post-block-09__img-item" href="<?php the_permalink(); ?>"
							   title="<?php the_title_attribute(); ?>">
								<?php the_post_thumbnail('post_block_09', array('class' => 'post-block-09__img-item')); ?>
							</a>
						<?php } else { ?>
							<a href="<?php the_permalink() ?>">
								<img class="post-block-02__img-item"
									 src="<?php echo get_template_directory_uri() ?>/images/placeholder-1600-900.png"
									 srcset="<?php echo get_template_directory_uri() ?>/images/placeholder-1600-900@2x.png 2x"
									 alt="Post picture">
							</a>
						<?php } ?>

					</figure>
					<article class="post-block-09__item uk-animation-slide-bottom-small">
						<header class="post-block-09__date">
							<p>
								<?php if ($theme_options['category-template-date'] == 1) {
									; ?>
									<time
										datetime="<?php echo get_the_date('c') ?>"><?php echo get_the_date('M j, y') ?></time> <?php }
								if ($theme_options['category-template-author'] == 1) { ?>By <a
									href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a><?php } ?>

							</p>
						</header>
						<p class="post-block-09__wrapper-link">
							<?php
							$thelist = '';
							$i = 0;
							foreach (get_the_category() as $category) {
								if (0 < $i) $thelist .= ' ';
								$thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="button button--blue' . $category->slug . '">' . $category->name . '</a>';
								$i++;
							}
							echo $thelist; ?>
						</p>
						<h2 class="post-block-09__header"><a
								class="post-block-09__header-link"
								href="<?php esc_url(the_permalink()); ?>"><?php the_title() ?></a></h2>
					</article>
				</div>
<!---->
			<?php endwhile;
//
//			if (class_exists('ReduxFramework')) {
//// TODO for newest iteration, how to ???
//				if ($theme_options['category-pagination'] == 1) {
//					the_posts_pagination(array(
//						'mid_size' => 2,
//						'prev_text' => __('«'),
//						'next_text' => __('»'),
//					));
//				}
//			}
//			?>

		</div>
	</section>
<?php endif; ?>
