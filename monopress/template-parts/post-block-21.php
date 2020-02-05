<?php
/**
 * Template part for displaying post block 21
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package monopress
 */

global $theme_options;
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
			class="post-block-21__header-link"
			href="<?php esc_url(the_permalink()); ?>"><?php the_title() ?></a></h2>
	<?php
	if (class_exists('ReduxFramework')) {
		if (($theme_options['block-settings-meta-comments'] == 1) || ($theme_options['block-settings-meta-date'] == 1) || ($theme_options['block-settings-meta-author'] == 1)) {
			?>
			<footer class="post-block-21__footer">
				<?php

				if ($theme_options['block-settings-meta-comments'] == 1 && (comments_open() || get_comments_number())) { ?>
					<span
						class="post-block-21__comments-count"><i
							data-uk-icon="commenting"></i> Comments <?php echo get_comments_number(); ?></span>
					<?php
				}

				if (($theme_options['block-settings-meta-date'] == 1) || ($theme_options['block-settings-meta-author'] == 1)) {
					?>


					<span
						class="post-block-21__comments-date"><?php if ($theme_options['block-settings-meta-date'] == 1) {
							; ?>
							<time
								datetime="<?php echo get_the_date('c') ?>"><i
									data-uk-icon="clock"></i><?php echo get_the_date('M j, y') ?></time> <?php }
						if ($theme_options['block-settings-meta-author'] == 1) { ?>By <a
							href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a><?php }

						?></span>

					<?php
				}
				?>
			</footer>
			<?php
		}
	}
	?>
</article>

