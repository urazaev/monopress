<?php
/**
 * The template for displaying the socials listing
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bcn
 */
global $theme_options;
?>

<ul class="social-listing">
	<?php if (isset($theme_options['social-twitter'])) {
		echo '<li><a href="#' . esc_html($theme_options['social-twitter']) . '"><i class="uk-icon" data-uk-icon="twitter"></i></a></li>';
	} ?>
	<?php if (isset($theme_options['social-facebook'])) {
		echo '<li><a href="#' . esc_html($theme_options['social-facebook']) . '"><i class="uk-icon" data-uk-icon="facebook"></i></a></li>';
	} ?>
	<?php if (isset($theme_options['social-instagram'])) {
		echo '<li><a href="#' . esc_html($theme_options['social-instagram']) . '"><i class="uk-icon" data-uk-icon="instagram"></i></a></li>';
	} ?>
	<?php if (isset($theme_options['social-youtube'])) {
		echo '<li><a href="#' . esc_html($theme_options['social-youtube']) . '"><i class="uk-icon" data-uk-icon="youtube"></i></a></li>';
	} ?>
	<?php if (isset($theme_options['social-behance'])) {
		echo '<li><a href="#' . esc_html($theme_options['social-behance']) . '"><i class="uk-icon" data-uk-icon="behance"></i></a></li>';
	} ?>

</ul>
