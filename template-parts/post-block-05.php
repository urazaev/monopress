<?php
/**
 * Template part for displaying post category 02
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcn
 */

global $theme_options;
?>

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
