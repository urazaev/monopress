<?php
/**
 * The template for displaying the footer
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bcn
 */
global $theme_options;
?>

<footer class="container-fluid footer footer-second">
	<div class="row footer-second-row">
		<div class="col-sm column-1">
			<p class="footer-logo">
				<a class="main-nav__logo main-nav__logo--hor header-animate"
				   href="<?php echo esc_url(home_url('/')); ?>">

					<?php
					if ($theme_options['logo-type'] == '0') {
						echo esc_attr($theme_options['logo-txt']);
					} else {
						echo "<picture>";
						if ($theme_options['logo-mobile'] != '' && $theme_options['logo-mobile']['url'] != '') { ?>

							<source media="(max-width: 767px)"
									srcset="<?php echo esc_html($theme_options['logo-mobile']['url']);
									if (esc_html($theme_options['logo-mobile']['url'] != '')) {
										echo ', ' . esc_html($theme_options['logo-mobile-retina']['url']) . ' 2x';
									} ?>">
							<?php
						}

						if ($theme_options['footer-logo'] != '' && $theme_options['footer-logo']['url'] != '') {
							echo '<img class="footer-logo-img-item" src="' . esc_html($theme_options['footer-logo']['url']) . '" ' . (($theme_options['footer-logo-retina']['url'] != '') ? 'srcset="' . esc_html($theme_options['footer-logo-retina']['url']) . ' 2x"' : '') . ' alt="' . (($theme_options['footer-logo-alt'] != '') ? '' . esc_html($theme_options['footer-logo-alt']) . '' : '' . get_bloginfo('description', 'display') . '') . '" title="' . (($theme_options['footer-logo-title'] != '') ? '' . esc_html($theme_options['footer-logo-title']) . '' : '' . get_bloginfo('description', 'display') . '') . '">';
						} elseif ($theme_options['logo'] != '' && $theme_options['logo']['url'] != '') {
							echo '<img class="footer-logo-img-item" src="' . esc_html($theme_options['logo']['url']) . '" ' . (($theme_options['logo-retina']['url'] != '') ? 'srcset="' . esc_html($theme_options['logo-retina']['url']) . ' 2x"' : '') . ' alt="' . (($theme_options['footer-logo-alt'] != '') ? '' . esc_html($theme_options['footer-logo-alt']) . '' : '' . get_bloginfo('description', 'display') . '') . '" title="' . (($theme_options['footer-logo-title'] != '') ? '' . esc_html($theme_options['footer-logo-title']) . '' : '' . get_bloginfo('description', 'display') . '') . '">';
						}
						echo "</picture>";
					}
					?>
				</a>
			</p>
		</div>

		<?php
		if ($theme_options['footer-text'] != '') {
			echo '<div class="col-sm column-2">' . esc_html($theme_options['footer-text']) . '</div>';
		}

		if ($theme_options['footer-social'] == '1') {
			?>
			<div class="col-sm column-3">
				<?php
				if ($theme_options['footer-social'] == '1') {
					up_get_template('socials-listing');
				} ?>
			</div>
			<?php
		}
		?>
	</div>
</footer>

<?php
if ($theme_options['subfooter-on'] == 1) {
	up_get_template('subfooter');
}
?>
