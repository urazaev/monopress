<?php
/**
 * Template part for displaying post category 21
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcn
 */

global $theme_options;

?>

<?php if (have_posts()) : ?>

	<section class="post-block-21" data-uk-scrollspy="target: > article; cls:uk-animation-slide-left-small; delay: 500">

		<?php while (have_posts()) :
			the_post();

			$post_id = get_the_ID();
			$category_object = get_the_category($post_id);
			$category_name = $category_object[0]->name;

			?>

			<article class="post-block-21__item">
				<figure class="post-block-21__img">


					<?php if (has_post_thumbnail()) { ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail('post_block_21', array('class' => 'post-block-21__img-item')); ?>
						</a>
					<?php } else { ?>
						<a href="<?php the_permalink() ?>">
							<img class="post-block-21__img-item"
								 src="<?php echo get_template_directory_uri() ?>/images/placeholder-700-370.png"
								 srcset="<?php echo get_template_directory_uri() ?>/images/placeholder-700-370@2x.png 2x"
								 alt="Post picture">
						</a>
					<?php } ?>

				</figure>
				<h2 class="post-block-21__header animation-rtl"><a
						class="post-block-21__header-link" href="<?php esc_url(the_permalink()); ?>"><?php the_title() ?></a></h2>
				<footer class="post-block-21__footer">
<!--					<span class="post-block-21__comments-count">Comments 2</span> TODO : for new iteration?-->
					<span class="post-block-21__comments-date"><?php if ($theme_options['category-template-date'] == 1) {
							; ?>
							<time
								datetime="<?php echo get_the_date('c') ?>"><?php echo get_the_date('M j, y') ?></time> <?php }
						if ($theme_options['category-template-author'] == 1) { ?>By <a
							href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a><?php } ?></span>
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
		?>

	</section>

<?php endif; ?>
