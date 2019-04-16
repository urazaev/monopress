<?php
/**
 * Template Name: Portfolio masonry
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bcn
 */

global $theme_options;
get_header();
?>

<section class="portfolio portfolio--masonry">

	<div class="entry-content portfolio__content post-text-block-20__text">
		<?php
		if (class_exists('ReduxFramework')) {
			if ($theme_options['template-settings-breadcrumbs-show'] == 1) {
				the_breadcrumb('breadcrumbs breadcrumbs--inner breadcrumbs--inner-nottobbrdr');
			}
			if ($theme_options['portfolio-show-content'] == '1') {

				the_title('<h1 class="post-block-20__header">', '</h1>');
			}

			if ($theme_options['portfolio-sharing-top'] == '1') {
				addtoany_render();
			}

			if ($theme_options['portfolio-show-content'] == '1') {
				if (have_posts()) : while (have_posts()) : the_post();
					the_content();
				endwhile;
				endif;
			}
		}
		?>
	</div>
	<!-- .entry-content -->

	<div data-uk-filter="target: .js-filter">
		<?php if (class_exists('ReduxFramework')) {
			if ($theme_options['portfolio-show-filter'] == '1') {
				?>

				<div class="uk-grid-small uk-flex-top" data-uk-grid>
					<div class="uk-width-expand">
						<div class="uk-grid-small uk-grid-divider uk-child-width-auto" data-uk-grid>
							<div>
								<ul class="portfolio__sort uk-subnav uk-subnav-pill" data-uk-margin>
									<li class="portfolio__sort-item uk-active" data-uk-filter-control><a
											class="portfolio__sort-link"
											href="#">All</a></li>
								</ul>
							</div>
							<div>
								<ul class="portfolio__sort uk-subnav uk-subnav-pill" data-uk-margin>

									<?php
									$terms = get_terms("portfolio");
									$count = count($terms);

									if ($count > 0) {
										foreach ($terms as $term) { ?>
											<li class="portfolio__sort-item"
												data-uk-filter-control="[data-type*='<?php echo $term->name; ?>']">
												<a class="portfolio__sort-link"
												   href="#"><?php echo $term->name; ?></a>
											</li>
											<?php
										}
									}
									?>

								</ul>
							</div>
						</div>
					</div>

					<div class="uk-width-auto uk-text-nowrap">
									  <span class="uk-active" data-uk-filter-control="sort: data-name">
										  <button class="data-uk-icon-link" data-uk-icon="icon: arrow-down"></button>
									  </span>
						<span data-uk-filter-control="sort: data-name; order: desc">
											<button class="data-uk-icon-link" data-uk-icon="icon: arrow-up"></button>
										</span>
					</div>
				</div>
				<?php
			}
		} ?>

		<ul class="portfolio__list js-filter uk-child-width-1-2 uk-child-width-1-3@m uk-text-center"
			data-uk-grid="masonry: true"
			<?php if ($theme_options['portfolio-show-modal'] == '1'){ ?>data-uk-lightbox="animation: fade"<?php } ?>>

			<?php
			$loop = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => -1));
			$count = 0;
			?>


			<?php if ($loop) :

				while ($loop->have_posts()) : $loop->the_post(); ?>

					<?php
					$terms = get_the_terms($post->ID, 'portfolio');

					if ($terms && !is_wp_error($terms)) :
						$links = array();

						foreach ($terms as $term) {
							$links[] = $term->name;
						}
						$tax = join(" ", $links);
					else :
						$tax = '';
					endif;
					?>

					<?php $infos = get_post_custom_values('_url'); ?>
					<li class="portfolio__item" data-type="<?php echo $tax; ?>"
						data-name="A<?php echo $post->ID ?>">
						<a class="portfolio__link uk-inline-clip uk-transition-toggle uk-dark"
						   href="<?php echo get_the_post_thumbnail_url(); ?>"
						   data-caption="<?php the_title(); ?>">

							<img class="portfolio__img uk-transition-scale-up uk-transition-opaque"
								 src="<?php echo get_the_post_thumbnail_url($post->ID, 'portfolio_masonry_thumb'); ?>"
								 srcset="<?php echo get_the_post_thumbnail_url($post->ID, 'portfolio_masonry_thumb_x2'); ?> 2x"
								 alt="Portfolio item">
							<?php if (class_exists('ReduxFramework')) {
								if ($theme_options['portfolio-show-plus'] == '1') {
									?>
									<div class="uk-position-center">
														<span class="uk-transition-fade"
															  data-uk-icon="icon: plus; ratio: 2"></span>
									</div>
									<?php
								}
								if ($theme_options['portfolio-show-title'] == '1') {
									?>

									<div
										class="uk-transition-slide-bottom uk-position-bottom uk-overlay uk-overlay-default">
										<p class="uk-h5 uk-margin-remove"><?php the_title(); ?></p>
									</div>

									<?php
								}
							}
							?>
						</a>
					</li>

				<?php endwhile; else: ?>

				<li class="error-not-found">Sorry, no portfolio entries found.</li>

			<?php endif; ?>

		</ul>
	</div>

	<?php if (class_exists('ReduxFramework')) {
		if ($theme_options['portfolio-sharing-bottom'] == '1') { ?>
			<div class="portfolio__content">
				<?php
				addtoany_render();
				?>
			</div>
			<?php
		}
	}
	?>
</section>
