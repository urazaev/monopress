<?php
/**
 * Template part for displaying post category 02
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcn
 */

global $theme_options;

echo "post-block-03";

?>
<section class="post-block-03">

	<?php if (have_posts()) :
		while (have_posts()) : the_post(); ?>

			<article class="post-block-03__item">

				<figure class="post-block-03__img">

					<?php if (has_post_thumbnail()) { ?>
						<?php the_post_thumbnail('post_block_03', array('class' => 'post-block-03__img-item')); ?>
					<?php } else { ?>
						<img class="post-block-03__img-item"
							 src="<?php echo get_template_directory_uri() ?>/images/placeholder-800-900.png"
							 srcset="<?php echo get_template_directory_uri() ?>/images/placeholder-800-900@2x.png 2x"
							 alt="Post picture">
					<?php } ?>

					<div class="post-block-03__widget theme-widget-black active-word-red"
						 data-uk-scrollspy="target: > .animate; cls:uk-animation-slide-top-small; delay: 500">
            <span class="post-block-03__widget-link-wrapper animate">
						<?php
						$thelist = '';
						$i = 0;
						foreach (get_the_category() as $category) {
							if (0 < $i) $thelist .= ' ';
							$thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="button button--red' . $category->slug . '">' . $category->name . '</a>';
							$i++;
						}
						echo $thelist; ?>
			</span>
						<h2 class="post-block-03__widget-title animate"><a
								class="post-block-03__widget-title-link"
								href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
						<footer class="post-block-03__widget-footer animate">
							<?php if ($theme_options['block-settings-meta-comments'] == 1) {?>
							<span
								class="post-block-03__widget-comments-count animation-rtl">Comments <?php echo get_comments_number(); ?></span>
							<?php}?>
							<?php if ($theme_options['block-settings-meta-date'] == 1) {
								; ?>
								<time class="post-block-03__widget-date animation-ltr"
									  datetime="<?php echo get_the_date('c') ?>"><?php echo get_the_date('M j, y') ?></time> <?php }
							if ($theme_options['block-settings-meta-author'] == 1) { ?>By <a
								href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a><?php } ?>

						</footer>
					</div>
				</figure>

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
	endif;
	?>

</section>
