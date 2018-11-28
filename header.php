<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bcn
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'bcn' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$bcn_description = get_bloginfo( 'description', 'display' );
			if ( $bcn_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $bcn_description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'bcn' ); ?></button>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
			) );
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
<?php
//        echo $options['custom-code-css'];
//print_r($options);
//foreach ($options as $item) {
//    echo $item;
//}
//
//echo join(', ', $options);
//
//array_walk($options, create_function('$a', 'echo $a;'));
//
//
//
//        global $options;
//
//        foreach ($options['opt-social-profiles'] as $idx => &arr) {
//        echo 'Profile ID: ' . $arr['id'];
//        echo 'Enabled: '    . $arr['enabled'];
//        echo 'Icon: '       . $arr['icon'];
//        echo 'Name: '       . $arr['name'];
//        echo 'URL: '        . $arr['url'];
//        echo 'Color: '      . $arr['color'];
//        echo 'Background: ' . $arr['background'];
//        }
//
//        // Or do the following for full icon rendering
//        foreach ($options['opt-social-profiles'] as $idx => &arr) {
//        if ($arr['enabled']) {
//        $id     = $arr['id'];
//        $url    = $arr['url'];
//
//        $icons .= '';
//        $icons .= '</pre><ul><li class="' . $id . '"><a href="' . $url . '" target="_blank"><i class="' . $arr['icon'] . '"></i></a></li></ul><pre>';
//    }
//
//    $output = '</pre><ul class="icons">';
//            $output .= $icons;
//            $output .= '</ul><pre>';
//}
//
//?>
        lorem lorem
