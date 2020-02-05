<?php
/**
 * Template part for displaying post block 07
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package monopress
 */

global $theme_options;

?>


<article class="post-block-07__item theme-white">
	<?php if (class_exists('ReduxFramework')) {
		if (($theme_options['block-settings-meta-date'] == 1) || ($theme_options['block-settings-meta-author'] == 1) || ($theme_options['block-settings-meta-comments'] == 1)) { ?>
			<header class="post-block-07__date">

			<p class="post-block-07__date-item">
				<?php if ($theme_options['block-settings-meta-date'] == 1) {
					; ?>
					<time
						datetime="<?php echo get_the_date('c') ?>"><?php echo get_the_date('M j, y') ?></time> <?php }
				if ($theme_options['block-settings-meta-author'] == 1) { ?>By <a
					href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a><?php }

				if (($theme_options['block-settings-meta-comments'] == 1) && (comments_open() || get_comments_number())) { ?>

					<span class="post-block-04__comments-count"><i data-uk-icon="commenting"></i>
						<?php echo get_comments_number(); ?></span>
					<?php
				}
				?>
			</p>

			</header><?php }
	} ?>
	<span class="post-block-07__wrapper-link">

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
	<figure class="post-block-07__img">

		<?php if (has_post_thumbnail()) { ?>
			<a class="post-block-07__img-item" href="<?php the_permalink(); ?>"
			   title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail('post_block_07', array('class' => 'post-block-07__img-item')); ?>
			</a>
		<?php } else { ?>
			<a href="<?php the_permalink() ?>">
				<img class="post-block-07__img-item"
					 src="<?php echo get_template_directory_uri() ?>/images/placeholder-962-700.png"
					 srcset="<?php echo get_template_directory_uri() ?>/images/placeholder-962-700@2x.png 2x"
					 alt="Post picture">
			</a>
		<?php } ?>

	</figure>
	<h2 class="post-block-07__header"><a
			class="post-block-07__header-link" href="<?php the_permalink(); ?>"><?php the_title() ?></a>
	</h2>
</article>

