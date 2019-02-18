<?php
/**
 * Template part for displaying post category 02
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcn
 */

?>

<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
		<article class="post-block-02__item">
			<header class="post-block-02__date"><p class="post-block-02__date-item has-animation animation-rtl"
				><span>Jan 5</span></p></header>
			<figure class="post-block-02__img has-animation animation-rtl">
				<a href="post-page-v3.html">

					<img class="post-block-02__img-item" src="img/content/590x375.jpg"
						 srcset="img/content/590x375@2x.jpg 2x" alt="Post picture">

				</a>
			</figure>
			<footer class="post-block-02__footer">
				<div class="post-block-02__footer-wrapper has-animation animation-ltr">
					<div class="post-block-02__footer-bg">
              <span class="post-block-02__wrapper-link">
              <a class="post-block-02__link-item button button--brown" href="#">Sport</a>
              </span>
						<h2 class="post-block-02__header"><a class="post-block-02__header-link"
															 href="post-page-v3.html">What His
								Favorite Shoes</a></h2>
					</div>
				</div>
			</footer>
		</article>
	<?php endwhile; ?>
<?php endif; ?>
