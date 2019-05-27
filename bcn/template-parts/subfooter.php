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

<div class="container-fluid sub-footer">
	<div class="row">
		<?php


		if ($theme_options['subfooter-text'] != '') {
			?>
			<div class="col-sm <?php if ($theme_options['subfooter-menu'] == '') {
				echo 'uk-text-center';
			} ?>">
				<?php
				if ($theme_options['subfooter-copy'] == 1) {
					echo '© ';
				}

				$subfooter_text = isset($theme_options['subfooter-text']) ? $theme_options['subfooter-text'] : '';

				if (isset($subfooter_text) && $subfooter_text != '') {
					echo do_shortcode($subfooter_text);
				};
				?>
			</div>

			<?php
		}

		if ($theme_options['subfooter-menu'] != '') {
			if ($theme_options['subfooter-text'] == '') {
				$subfooter_menu = "col-sm sub-footer-center";
			} else {
				$subfooter_menu = "col-sm sub-footer-right";
			}
			wp_nav_menu(array(
				'menu_id' => esc_html($theme_options['subfooter-menu']),
				'menu_class' => 'footer-menu',
				'theme_location' => esc_html($theme_options['subfooter-menu']),
				'container' => 'div',
				'container_class' => $subfooter_menu,
				'echo' => true,
			));
		}
		?>
	</div>
</div>
