<?php
/**
 * Template part for displaying post block 04
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcn
 */

global $theme_options;

?>

<article class="post-block-04__item">
	<p class="post-block-04__wrapper-link">
				  <span class="animation-rtl">

						<?php
						$thelist = '';
						$i = 0;
						foreach (get_the_category() as $category) {
							if (0 < $i) $thelist .= ' ';
							$thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="button button--green' . $category->slug . '">' . $category->name . '</a>';
							$i++;
						}
						echo $thelist; ?>

				  </span>
	</p>
	<figure class="post-block-04__img animation-ltr">

		<?php
		if (class_exists('ReduxFramework')) {
			if (($theme_options['block-settings-meta-date'] == 1) || ($theme_options['block-settings-meta-author'] == 1) || ($theme_options['block-settings-meta-comments'] == 1)) {
				?>
				<div class="post-block-04__date">
					<p class="animation-rtl">
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
				</div>
				<?php
			}
		}
		?>

		<?php if (has_post_thumbnail()) { ?>
			<a class="post-block-04__img-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail('post_block_04', array('class' => 'post-block-04__img-item')); ?>
			</a>
		<?php } else { ?>
			<a class="post-block-04__img-link" href="<?php the_permalink() ?>">
				<img class="post-block-04__img-item"
					 src="<?php echo get_template_directory_uri() ?>/images/placeholder-750-400.png"
					 srcset="<?php echo get_template_directory_uri() ?>/images/placeholder-750-400@2x.png 2x"
					 alt="Post picture">
			</a>
		<?php } ?>

	</figure>


	<h2 class="post-block-04__header animation-rtl"><a
			class="post-block-04__header-link" href="<?php the_permalink() ?>"><?php the_title() ?></a>
	</h2>

</article>
