<?php
/**
 * Template part for displaying post category 02
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcn
 */

global $theme_options;

//echo "post-block-07";

?>

<section class="post-block-07" data-uk-scrollspy="target: > article; cls:uk-animation-slide-left-small; delay: 800">

	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post();

			$post_id = get_the_ID();
			$category_object = get_the_category($post_id);
			$category_name = $category_object[0]->name;

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
					echo $thelist; ?>

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
	<?php endif; ?>

</section>

