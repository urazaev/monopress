<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcn
 */
global $theme_options;
?>

<article <?php post_class('row post-widget__item search-page-widget__item uk-animation-slide-top-small'); ?>
	id="post-<?php the_ID(); ?>">
	<?php if (has_post_thumbnail()) { ?>
		<div class="col-sm-3">
			<a class="post-widget__img-link search-page-widget__img-link related-img-link"
			   href="<?php the_permalink(); ?>"
			   title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail('search_grid_thumb', array('class' => 'post-widget__img-item')); ?>
			</a>
		</div>
	<?php } ?>
	<div class="<?php if (has_post_thumbnail()) { ?>col-sm-9<?php } else { ?>col-sm-12<?php } ?>">
		<?php
		$thelist = '';
		$i = 0;
		foreach (get_the_category() as $category) {
			if (0 < $i) $thelist .= ' ';
			$thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="button button--sm ' . $category->slug . '">' . $category->name . '</a>';
			if (++$i == 8) break;
		}
		if ($thelist) {
			?>
			<span class="post-widget-link-wrapper search-page__link-wrapper">
			<?php echo $thelist; ?>
			</span>
			<?php
		}

		?>

		<h2 class="post-widget__title search-page-widget__title">
			<a class="post-widget__title-link" href="<?php the_permalink(); ?>"><?php the_title() ?></a>
		</h2>


		<div class="entry-content">
			<?php the_excerpt(); ?>
		</div>


		<?php if (class_exists('ReduxFramework')) { if (($theme_options['block-settings-meta-date'] == 1) || $theme_options['block-settings-meta-author'] == 1 || $theme_options['block-settings-meta-comments'] == 1) { ?>
			<footer class="entry-footer post-widget__footer">
				<span class="post-widget__date post-block-08__widget-comments-count">
					<?php if ($theme_options['block-settings-meta-date'] == 1) {
						?>
						<time <?php if($theme_options['block-settings-meta-author'] == 1){echo "class=\"cube-after";}?>"
							  datetime="
					<?php echo get_the_date('c') ?>">
							<?php echo get_the_date('M y') ?></time> <?php }
					if ($theme_options['block-settings-meta-author'] == 1) { ?>By <a
						href="
					<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
						<?php echo get_the_author(); ?></a><?php }

						if($theme_options['block-settings-meta-comments'] == 1){echo " / ";}

						if ($theme_options['block-settings-meta-comments'] == 1) { ?>

							<span class="post-block-02__comments-count">
								<a href="<?php the_permalink(); ?>#comments"> Comments:
								<?php echo get_comments_number(); ?>
								</a>
							</span>

							<?php
						}
					}
					?>

				</span>
			</footer>
		<?php } ?>
	</div>
</article>
