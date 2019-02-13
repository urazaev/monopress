<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bcn
 */
global $theme_options;
?>

</div><!-- #content -->

<?php if (class_exists('ReduxFramework')) {
	if ($theme_options['main-menu-flip'] == 1) :
		if (is_active_sidebar('up-sidebar-flip')) : ?>

			<section class="flip-block">
				<div class="flip-block__wrapper uk-article">

					<?php dynamic_sidebar( 'up-sidebar-flip' ); ?>

				</div>
			</section>
		<?php endif;
	endif; ?>

	<?php if ($theme_options['template-settings-preloader-show'] == 1) : ?>
		<div class="loading-spinner js-loading-spinner" role="alert" aria-live="assertive">
			<div class="loading-spinner__item">
				<div class="loading-spinner__item-cube c1"></div>
				<div class="loading-spinner__item-cube c2"></div>
				<div class="loading-spinner__item-cube c4"></div>
				<div class="loading-spinner__item-cube c3"></div>
			</div>
		</div>
	<?php endif; ?>
	<?php if ($theme_options['main-menu-search'] == 1) : ?>
		<div class="usernav__search-search">
			<div class="usernav__search-close usernav__search-close--open">
				<button class="usernav__search-close-button" data-uk-icon="close"></button>
			</div>
			<div class="usernav__search-wrapper">
				<form class="uk-search uk-search-large">
					<button class="uk-search-icon-flip" data-uk-search-icon type="submit"></button>
					<input class="usernav__search-input uk-search-input" type="search" name="search"
						   placeholder="Search...">
				</form>
			</div>
		</div>
	<?php endif;
	if ($theme_options['instagram-on'] == 1) {
		//instagram
		if (function_exists('instagram_render')) {
			instagram_render($theme_options['instagram-id'], $theme_options['instagram-images'], $theme_options['instagram-columns'], $theme_options['instagram-gap']);
		}
	}
}


if (class_exists('ReduxFramework')) {
	if ($theme_options['footer-on'] == 1) {
		if ($theme_options['footer-layout'] == '1') {
			?>
			<footer class="container-fluid footer footer-first">
				<div class="row">
					<div class="col text-center">
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

						if ($theme_options['footer-social'] == '1') {
							?>

							<ul class="social-listing">
								<!--                TODO include all socials into loop -->
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
							<?php
						}
						?>
					</div>
				</div>
			</footer>

			<?php
		}
		if ($theme_options['footer-layout'] == '2') { ?>
			<footer class="container-fluid footer footer-second">
				<div class="row">
					<div class="col">
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
						echo '<div class="col">' . esc_html($theme_options['footer-text']) . '</div>';
					}

					if ($theme_options['footer-social'] == '1') {
						?>
						<div class="col">
							<ul class="social-listing justify-right">
								<!--  TODO include all socials into loop -->
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
						</div>
						<?php
					}
					?>
				</div>
			</footer>
			<?php
		}
		if ($theme_options['footer-layout'] == '3') {
			?>

			<footer class="container-fluid footer footer-third">
				<div class="row">
					<div class="col">
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

						<?php
						if ($theme_options['footer-text'] != '') {
							echo '<p class="footer-txt">' . esc_html($theme_options['footer-text']) . '</p>';
						}

						if ($theme_options['footer-email'] != '') {
							echo '<p class="footer-contacts">Contact us <a href="mailto:' . esc_html($theme_options['footer-email']) . '">' . esc_html($theme_options['footer-email']) . '</a></p>';
						}

						if ($theme_options['footer-social'] == '1') {
							?>

							<ul class="social-listing justify-left">
								<!--                TODO include all socials into loop -->
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
							<?php
						} ?>


					</div>

					<div class="col">
						<h3>Popular posts</h3>
						<ul class="footer-menu">
							<li><a href="#">Dive into an Ocean Photographer's World</a></li>
							<li><a href="#">Save the Oceans, Feed the World!</a></li>
							<li><a href="#">On the Mysterious Ocean</a></li>
							<li><a href="#">The Secrets I Find </a></li>
							<li><a href="#">Dive into an Ocean Photographer's World</a></li>
							<li><a href="#">What's the Difference Between Weather and
									Climate?</a></li>
						</ul>


					</div>
					<div class="col">
						<h3>Categories</h3>
						<ul class="footer-menu">
							<li><a href="#">Dive into an Ocean Photographer's World</a></li>
							<li><a href="#">Save the Oceans, Feed the World!</a></li>
							<li><a href="#">On the Mysterious Ocean</a></li>
							<li><a href="#">The Secrets I Find </a></li>
							<li><a href="#">Dive into an Ocean Photographer's World</a></li>
							<li><a href="#">What's the Difference Between Weather and
									Climate?</a></li>
						</ul>
					</div>
				</div>
			</footer>

			<?php
		}
	}


	if ($theme_options['subfooter-on'] == 1) {
		?>
		<div class="container-fluid sub-footer">
			<div class="row">
				<?php
				if ($theme_options['subfooter-text'] != '') {
					?>
					<div class="col <?php if ($theme_options['subfooter-menu'] == '') {
						echo 'uk-text-center';
					} ?>">
						<?php
						if ($theme_options['subfooter-copy'] == 1) {
							echo '© ';
						}
						echo esc_html($theme_options['subfooter-text']);
						?>
					</div>
					<?php
				}

				if ($theme_options['subfooter-menu'] != '') {
					if ($theme_options['subfooter-text'] == '') {
						$subfooter_menu = "col sub-footer-center";
					} else {
						$subfooter_menu = "col sub-footer-right";
					}
					wp_nav_menu(array(
						'menu' => esc_html($theme_options['subfooter-menu']),
						'menu_id' => esc_html($theme_options['subfooter-menu']),
						'menu_class' => 'menu footer-menu',
						'container' => 'div',
						'container_class' => $subfooter_menu,
						'echo' => true,
					));
				}
				?>
			</div>
		</div>
		<?php
	}
}
?>
</div><!-- #page -->

<?php
wp_footer();
?>
</body>
</html>
