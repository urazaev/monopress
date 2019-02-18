<?php
/**
 * Template part for displaying category
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcn
 */

?>


<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post();
		the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
	endwhile; ?>
<?php endif; ?>
