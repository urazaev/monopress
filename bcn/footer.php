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
<?php

if ($theme_options['header-layout'] == 2) {
	?>

	</div>
	<!-- .row -->
	<?php

}

if (class_exists('ReduxFramework')) {
	if (($theme_options['main-menu-flip'] == 1) && ($theme_options['header-layout'] == 1)) :
		if (is_active_sidebar('up-sidebar-flip')) : ?>

			<section class="flip-block">
				<div class="flip-block__wrapper uk-article">

					<?php dynamic_sidebar('up-sidebar-flip'); ?>

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
				<form class="uk-search uk-search-large" action="<?php echo esc_url(home_url('/')); ?>">
					<button class="uk-search-icon-flip" data-uk-search-icon type="submit"></button>
					<input class="usernav__search-input uk-search-input" type="search" name="s" id="s"
						   placeholder="<?php esc_attr_e('Search...', 'bcn'); ?>">
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

	if ($theme_options['footer-on'] == 1) {

		if ($theme_options['footer-layout'] == '1') {
			up_get_template('footer-1');
		}

		if ($theme_options['footer-layout'] == '2') {
			up_get_template('footer-2');
		}

		if ($theme_options['footer-layout'] == '3') {
			up_get_template('footer-3');
		}
	}

}
?>
</div><!-- #page -->


<?php
wp_footer();

if (class_exists('ReduxFramework')) {

	if ($theme_options['category-pagination'] == 2) {

		if (!is_single() || !is_page()):
			?>

			<script type="text/javascript">
				jQuery(document).ready(function ($) {
					var count = 2;
					var total = <?php echo $wp_query->max_num_pages; ?>;
					$(window).scroll(function () {
						if ($(window).scrollTop() == $(document).height() - $(window).height()) {
							if (count > total) {
								return false;
							} else {
								loadArticle(count);
							}
							count++;
						}
					});

					function loadArticle(pageNumber) {
						$('a#inifiniteLoader').show('fast');
						$.ajax({
							url: "<?php echo esc_url(site_url())?>/wp-admin/admin-ajax.php",
							type: 'POST',
							data: "action=infinite_scroll&page_no=" + pageNumber + '&loop_file=template-parts/post-block-02',
							success: function (html) {
								$('a#inifiniteLoader').hide('1000');
								$("#loop-content").append(html);    // This will be the div where our content will be loaded
							}
						});
						return false;
					}
				});
			</script>

		<?php
		endif;
	}
}

$custom_code_js = isset($theme_options['custom-code-js']) ? $theme_options['custom-code-js'] : '';

if (isset($custom_code_js) && $custom_code_js != '') {
	echo '<script id="bcn-custom-js">' . do_shortcode($custom_code_js) . '</script>';
};
?>

</body>
</html>
