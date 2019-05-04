<?php
/**
 * Template part for displaying single post style 2
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcn
 */

global $theme_options;
?>
<div class="<?php if ($theme_options['post-sidebar'] == 1) {
	echo "col-md-12";
} else {
	echo "col-md-9";
} ?> post-template-1__wrapper">

	<?php
	if (($theme_options['post-show-categories'] == 1) || $theme_options['post-featured-images-show'] == 1 || $theme_options['block-show-tags'] == 1 || $theme_options['block-show-next-previous'] == 1 || $theme_options['block-show-author-box'] == 1 || $theme_options['post-related-show'] == '1') {
		?>

		<aside class="post-block-20 post-template-3-fix">
			<div class="post-block-20_inner">

				<article class="post-block-20__item">
					<?php
					if ($theme_options['post-show-categories'] == 1) { ?>
						<p class="post-block-20__wrapper-link show-on--desktop has-animation animation-rtl animate-in">
							<?php
							$thelist = '';
							$i = 0;
							foreach (get_the_category() as $category) {
								if (0 < $i) $thelist .= ' ';
								$thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="button button--blue' . $category->slug . '">' . $category->name . '</a>';
								$i++;
							}
							echo $thelist; ?>
						</p>
					<?php }

					if ($theme_options['post-featured-images-show'] == 1) { ?>

						<figure class="post-block-20__img show-on--desktop has-animation animation-ltr animate-in">
							<?php if (has_post_thumbnail()) {
								the_post_thumbnail('post_block_04', array('class' => 'post-block-20__img-item'));
							} else {
								?>
								<img class="post-block-20__img-item"
									 src="<?php echo get_template_directory_uri() ?>/images/placeholder-750-400.png"
									 srcset="<?php echo get_template_directory_uri() ?>/images/placeholder-750-400@2x.png 2x"
									 alt="Post picture">
								<?php
							}
							?>
						</figure>
					<?php }

					if (class_exists('ReduxFramework')) {

						if ($theme_options['block-show-tags'] == '1') {
							the_tags('<div class="tags-single-post">', '', '</div>');
						}
						if ($theme_options['block-show-next-previous'] == '1') {
							the_post_navigation();
						}

						if ($theme_options['block-show-author-box'] == '1') {
							get_template_part('template-parts/post-author');
						}
					}

					if ($theme_options['post-related-show'] == 1) {

						$related = get_posts(array('category__in' => wp_get_post_categories($post->ID), 'numberposts' => 6, 'post__not_in'
						=> array($post->ID)));
						if ($related):?>


							<div class="related-articles-container">
								<div class="related-articles-wrap row">

									<div class="col-12">
										<h2 class="related-title"><?php echo __('Related Articles', 'bcn') ?></h2>

										<div class="related-arrows">
											<button class="related-article-prev" type="button"><span
													class="screen-reader-text">Prev</span></button>
											<button class="related-article-next" type="button"><span
													class="screen-reader-text">Next</span></button>
										</div>

										<div class="related-article-slider">

											<?php
											foreach ($related as $post) {
												setup_postdata($post);
												?>

												<article
													class="post-widget__item-related uk-animation-slide-left-small">
													<div class="post-widget__img-wrapper">
														<?php if (has_post_thumbnail()) { ?>
															<a class="post-widget__img-link related-img-link"
															   href="<?php the_permalink(); ?>"
															   title="<?php the_title_attribute(); ?>">
																<?php the_post_thumbnail('post_block_04', array('class' => 'post-widget__img-item')); ?>
															</a>
														<?php } else { ?>
															<a class="post-widget__img-link related-img-link"
															   href="<?php the_permalink() ?>">
																<img class="post-widget__img-item related-img-link "
																	 src="<?php echo get_template_directory_uri() ?>/images/placeholder-750-400.png"
																	 srcset="<?php echo get_template_directory_uri() ?>/images/placeholder-750-400@2x.png 2x"
																	 alt="Post picture">
															</a>
														<?php } ?>
													</div>

													<span class="post-widget-link-wrapper">

							<?php
							$thelist = '';
							$i = 0;
							foreach (get_the_category() as $category) {
								if (0 < $i) $thelist .= ' ';
								$thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="button button--green button--sm ' . $category->slug . '">' . $category->name . '</a>';
								if (++$i == 2) break;
							}
							echo $thelist; ?>

						</span>

													<h2 class="post-widget__title"><a class="post-widget__title-link"
																					  href="<?php the_permalink(); ?>">
															<?php the_title() ?>
														</a></h2>
													<?php if (($theme_options['block-settings-meta-date'] == 1) || $theme_options['block-settings-meta-author'] == 1) { ?>
														<footer class="post-widget__footer">
											<span class="post-widget__date">
												<?php if ($theme_options['block-settings-meta-date'] == 1) {
													; ?>
													<time class="cube-after"
														  datetime="
											<?php echo get_the_date('c') ?>">
														<?php echo get_the_date('M y') ?></time> <?php }
												if ($theme_options['block-settings-meta-author'] == 1) { ?>By <a
													href="
											<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
													<?php echo get_the_author(); ?></a><?php } ?>
											</span>
														</footer>
													<?php } ?>
												</article>

												<?php
											} ?>

										</div>
									</div>
								</div>
							</div>
						<?php endif;
						wp_reset_postdata();
					}
					?>
				</article>
			</div>

		</aside>

		<?php
	}
	?>

	<div
		class="post-block-20__wrapper-text <?php if (($theme_options['post-show-categories'] == 1) || $theme_options['post-featured-images-show'] == 1 || $theme_options['block-show-tags'] == 1 || $theme_options['block-show-next-previous'] == 1 || $theme_options['block-show-author-box'] == 1 || $theme_options['post-related-show'] == '1') {
			echo "post-block-20__wrapper-text--semiwidth";
		} else {
			echo "post-block-20__wrapper-text--fullwidth";
		} ?>">

		<section class="post-text-block-20">

			<article id="post-<?php the_ID(); ?>" <?php post_class('post-text-block-20__item uk-animation-fade'); ?>>

				<?php
				if ($theme_options['template-settings-breadcrumbs-show'] == 1) {
					the_breadcrumb('breadcrumbs breadcrumbs--inner-nottobbrdr');
				}?>

				<?php
				if ($theme_options['post-show-categories'] == 1) { ?>
					<p class="post-block-20__wrapper-link show-on--mobile pt-30 has-animation animation-rtl animate-in">
						<?php
						$thelist = '';
						$i = 0;
						foreach (get_the_category() as $category) {
							if (0 < $i) $thelist .= ' ';
							$thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="button button--blue' . $category->slug . '">' . $category->name . '</a>';
							$i++;
						}
						echo $thelist; ?>
					</p>
				<?php }

				if ($theme_options['post-featured-images-show'] == 1) { ?>

					<figure class="post-block-20__img show-on--mobile has-animation animation-ltr animate-in">
						<?php if (has_post_thumbnail()) {
							the_post_thumbnail('post_block_04', array('class' => 'post-block-20__img-item'));
						} else {
							?>
							<img class="post-block-20__img-item"
								 src="<?php echo get_template_directory_uri() ?>/images/placeholder-750-400.png"
								 srcset="<?php echo get_template_directory_uri() ?>/images/placeholder-750-400@2x.png 2x"
								 alt="Post picture">
							<?php
						}
						?>
					</figure>
				<?php } ?>

				<?php

				$adv_block_4 = isset($theme_options['ads-block4']) ? $theme_options['ads-block4'] : '';
				echo do_shortcode($adv_block_4);

				the_title('<h1 class="post-block-20__header has-animation animation-ltr animate-in">', '</h1>');

				if ($theme_options['post-show-author-name'] == 1 || $theme_options['post-show-date'] == 1 || $theme_options['post-show-comments-numbers'] == '1') { ?>

					<p class="post-block-20__date-item has-animation animation-rtl animate-in">
						<span
							class="post-block-08__widget-comments-count"><?php
							if ($theme_options['post-show-author-name'] == 1) { ?>By <a
								href="
								<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
								<?php echo get_the_author(); ?></a> - <?php }

							if ($theme_options['post-show-date'] == 1) {
								?>
								<time class="animation-ltr"
									  datetime="<?php echo get_the_date('c') ?>">
								<?php echo get_the_date('M j, y') ?></time> <?php }
							if ($theme_options['post-show-comments-numbers'] == '1' && comments_open()) { ?>
								<a href="#comments">Comments:
									<?php echo get_comments_number(); ?></a>
							<?php }
							?>
						</span>
					</p>
					<?php
				}

				if ($theme_options['post-sharing-top'] == '1') {
					addtoany_render();
				}
				?>

				<div class="entry-content post-text-block-20__text">
					<?php
					the_content(sprintf(
						wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
							__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'bcn'),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					));

					wp_link_pages(array(
						'before' => '<div class="page-links">' . esc_html__('Pages:', 'bcn'),
						'after' => '</div>',
					));
					?>
				</div><!-- .entry-content -->

				<?php if (class_exists('ReduxFramework')) {
					if ($theme_options['post-sharing-bottom'] == '1') {
						addtoany_render();
					}
				}
				?>

			</article>
			<!-- #post-<?php the_ID(); ?> -->

		</section>

		<?php

		// If comments are open or we have at least one comment, load up the comment template.
		if (comments_open() || get_comments_number()) :
			comments_template();
		endif;
		?>

	</div>

</div>
