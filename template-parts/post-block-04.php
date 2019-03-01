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
<?php


echo "post-block-04";


?>

<section class="post-block-04" data-uk-scrollspy="target: > article; cls:uk-animation-slide-top-small; delay: 500">

	<?php if (have_posts()) :
		while (have_posts()) : the_post(); ?>

			<article class="post-block-04__item">
				<header class="post-block-04__date">
					<p class="animation-rtl">
						<?php if ($theme_options['category-template-date'] == 1) {
							; ?>
							<time datetime="<?php echo get_the_date('c') ?>"><?php echo get_the_date('M j, y') ?></time> <?php }
						if ($theme_options['category-template-author'] == 1) { ?>By <a
							href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a><?php } ?>
					</p>
				</header>
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

					<?php if (has_post_thumbnail()) { ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail('post_block_04', array('class' => 'post-block-04__img-item')); ?>
						</a>
					<?php } else { ?>
						<a href="<?php the_permalink() ?>">
							<img class="post-block-04__img-item"
								 src="<?php echo get_template_directory_uri() ?>/images/placeholder-750-400.png"
								 srcset="<?php echo get_template_directory_uri() ?>/images/placeholder-750-400@2x.png 2x"
								 alt="Post picture">
						</a>
					<?php } ?>

				</figure>
				<h2 class="post-block-04__header animation-rtl"><a
						class="post-block-04__header-link" href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
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
