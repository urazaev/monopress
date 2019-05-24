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
<footer class="container-fluid footer footer-third">
	<div class="row section-first no-gutters">
		<div class="col-md-7 column-1">
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

			<?php
			if ($theme_options['footer-text'] != '') {
				echo '<p class="footer-txt">' . esc_html($theme_options['footer-text']) . '</p>';
			}

			if ($theme_options['footer-email'] != '') {
				echo '<p class="footer-contacts">Contact us <a href="mailto:' . esc_html($theme_options['footer-email']) . '">' . esc_html($theme_options['footer-email']) . '</a></p>';
			}

			?>

		</div>
		<div class="col-md-2  col-sm-6 column-2">
			<?php if (is_active_sidebar('up-sidebar-footer1')) {
				dynamic_sidebar('up-sidebar-footer1');
			}
			?>

		</div>
		<div class="col-md-2  col-sm-6 column-3">
			<?php if (is_active_sidebar('up-sidebar-footer2')) {
				dynamic_sidebar('up-sidebar-footer2');
			}
			?>
		</div>
	</div>
	<div class="row section-second no-gutters">
		<div class="col-md-3 column-4">
			<?php if (is_active_sidebar('up-sidebar-footer3')) {
				dynamic_sidebar('up-sidebar-footer3');
			}
			?>
		</div>
		<div class="col column-5">
			<div class="socials">
				<?php
				up_get_social_links();
				?>

			</div>

			<?php
			if ($theme_options['subfooter-on'] == 1) { ?>
				<div class="subfooter">
					<?php up_get_template('subfooter'); ?>
				</div>
				<?php
			} ?>

		</div>
	</div>
</footer>
