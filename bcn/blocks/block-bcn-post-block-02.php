<?php if (have_posts()) : ?>
	<section class="mainpage__section post-block-<?php switch ($theme_options['category-article-display']) {
		case 2:
			echo '02';
			break;
		case 4:
			echo '04';
			break;
		case 5:
			echo '05';
			break;
		case 7:
			echo '07';
			break;
		case 14:
			echo '14';
			break;
		case 21:
			echo '21';
			break;
	} ?>" id="loop-content" <?php if ($theme_options['category-article-display'] == 4 || 07 || 14 || 21) {
		echo 'data-uk-scrollspy="target: > article; cls:uk-animation-slide-left-small; delay: 800"';
	} ?>>

		<?php

		if ($theme_options['category-article-display'] == 5) { ?>

		<div class="post-block-05__content">
			<div class="single-slider-item">

				<?php

				}

				while (have_posts()) :
					the_post();

					$post_id = get_the_ID();
					$category_object = get_the_category($post_id);
					$category_name = $category_object[0]->name;

					switch ($theme_options['category-article-display']) {

						case 2:
							up_get_template('post-block-02');
							break;

						case 4:
							up_get_template('post-block-04');
							break;

						case 5:
							up_get_template('post-block-05');
							// TODO: slider pagination? or infinite?
							break;

						case 7:
							up_get_template('post-block-07');
							break;

						case 14:
							up_get_template('post-block-14');
							break;

						case 21:
							up_get_template('post-block-21');
							break;
					}

				endwhile;

				if ($theme_options['category-article-display'] == 5) { ?>


			</div>

			<div class="control-05 owl-nav uk-animation-fade theme-light-gray">
				<div class="control-05__control-slider">
					<button class="control-05__prev-link slick-custom-prev" type="button">
          <span class="control-05__prev-img" data-uk-icon="chevron-up">
          </span>
					</button>
					<button class="control-05__next-link slick-custom-next" type="button">
          <span class="control-05__next-img" data-uk-icon="chevron-down">
          </span>
					</button>
				</div>

			</div>
		</div>

	<?php

	}
	?>
	</section>
<?php

else :?>
	<article class="archive__notfound-wrapper uk-animation-slide-bottom-medium">

		<h1 class="post-block-06__header archive__header">
			<?php esc_html_e('Nothing Found', 'bcn'); ?>
		</h1>
		<div class="post-block-06__text archive__text">
			<p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'bcn'); ?></p>
		</div>
	</article>
<?php
endif;
