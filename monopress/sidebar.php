<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package monopress
 */

if ( ! is_active_sidebar( 'up-sidebar-default' ) ) {
	return;
}
?>
<aside class="post-widget sidebar">
	<div class="sidebar__inner"
		 data-uk-scrollspy="target: > section; cls:uk-animation-slide-top-small; delay:600;">
		<?php dynamic_sidebar('up-sidebar-default'); ?>
	</div>
</aside>
<!-- #up-sidebar-default -->
