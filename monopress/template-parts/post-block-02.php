<?php
/**
 * Template part for displaying post block 02
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package monopress
 */

global $theme_options;
?>
<article class="post-block-02__item">
	<header class="post-block-02__date has-animation animation-rtl">
		<p class="post-block-02__date-item">
			<?php if (class_exists('ReduxFramework')) {
				if ($theme_options['block-settings-meta-date'] == 1) {
					; ?>
					<time
						datetime="<?php echo get_the_date('c') ?>"><?php echo get_the_date('M j, y') ?></time> <?php }
				if ($theme_options['block-settings-meta-author'] == 1) { ?>By <a
					href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a><?php }
			} ?>
		</p>
	</header>

	<figure class="post-block-02__img has-animation animation-rtl">
		<?php if (has_post_thumbnail()) { ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail('post_block_02', array('class' => 'post-block-02__img-item')); ?>
			</a>
		<?php } else { ?>
			<a href="<?php the_permalink() ?>">
				<img class="post-block-02__img-item"
					 src="<?php echo get_template_directory_uri() ?>/images/placeholder-590-375.png"
					 srcset="<?php echo get_template_directory_uri() ?>/images/placeholder-590-375@2x.png 2x"
					 alt="Post picture">
			</a>
		<?php } ?>
	</figure>

	<footer class="post-block-02__footer">
		<div class="post-block-02__footer-wrapper has-animation animation-ltr">
			<div class="post-block-02__footer-bg">
						  <span class="post-block-02__wrapper-link">
							<?php
							$thelist = '';
							$i = 0;
							foreach (get_the_category() as $category) {
								if (0 < $i) $thelist .= ' ';
								$thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="button button--blue' . $category->slug . '">' . $category->name . '</a>';
								$i++;
							}
							echo do_shortcode($thelist); ?>
						  </span>
				<h2 class="post-block-02__header"><a class="post-block-02__header-link"
													 href="<?php esc_url(the_permalink()); ?>"><?php the_title() ?></a>
				</h2>
				<?php
				if (class_exists('ReduxFramework')) {
					if (($theme_options['block-settings-meta-comments'] == 1) && (comments_open() || get_comments_number())) { ?>

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
