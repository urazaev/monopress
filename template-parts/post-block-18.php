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

<?php if (have_posts()) : ?>

	<section class="post-block-18 theme-white"
			 data-uk-scrollspy="target: > article; cls:uk-animation-slide-left-small; delay: 500">

		<?php while (have_posts()) : the_post();

			$post_id = get_the_ID();
			$category_object = get_the_category($post_id);
			$category_name = $category_object[0]->name;

			?>

			<article class="post-block-18__item">
				<header class="post-block-18__date">
					<?php if ($theme_options['category-template-date'] == 1) {
						; ?>
						<time
							datetime="<?php echo get_the_date('c') ?>"><?php echo get_the_date('M j, y') ?></time> <?php }
					if ($theme_options['category-template-author'] == 1) { ?>By <a
						href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a><?php } ?>
				</header>
				<figure class="post-block-18__img">


					<?php if (has_post_thumbnail()) { ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail('post_block_18', array('class' => 'post-block-18__img-item')) ?>
						</a>
					<?php } else { ?>
						<a href="<?php the_permalink() ?>">
							<img class="post-block-18__img-item"
								 src="<?php echo get_template_directory_uri() ?>/images/placeholder-658-387.png"
								 srcset="<?php echo get_template_directory_uri() ?>/images/placeholder-658-387@2x.png 2x"
								 alt="Post picture">
						</a>
					<?php } ?>

				</figure>
				<footer class="post-block-18__footer">
					<div class="post-block-18__footer-wrapper">
						<div class="post-block-18__footer-bg">
              <span class="post-block-18__wrapper-link">
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
							<h2 class="post-block-18__header"><a class="post-block-18__header-link"
																 href="post-page-v1.html"><?php the_title() ?>
								</a></h2>
						</div>
					</div>
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
