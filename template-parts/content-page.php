<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcn
 */
global $theme_options;
?>

<article <?php post_class('page__content-wrapper uk-animation-slide-top-small'); ?> id="post-<?php the_ID(); ?>">

	<?php the_title('<h1 class="post-block-06__header page__heading">', '</h1>'); ?>

	<?php bcn_post_thumbnail(); ?>

	<div class="entry-content post-block-06__text page__content">
		<?php
		the_content();
		?>
	</div><!-- .entry-content -->

	<?php
	wp_link_pages(array(
		'before' => '<div class="page-links page__links">' . esc_html__('Pages:', 'bcn'),
		'after' => '</div>',
	));
	?>

	<?php if (get_edit_post_link()) : ?>
		<footer class="entry-footer page__footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
						__('Edit <span class="screen-reader-text">%s</span>', 'bcn'),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>',
				'',
				'post-edit-link button'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>

</article>
<!-- #post-<?php the_ID(); ?> -->
