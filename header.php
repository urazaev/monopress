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
global $theme_options;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head();

  if (class_exists('ReduxFramework')) {
    // favicon
    if ($theme_options['favicon'] != '' && $theme_options['favicon']['url'] != '') {
      echo '<link rel="icon" type="image/png" href="' . esc_attr($theme_options['favicon']['url']) . '">';
    }

    // apple-bookmarklets
    if ($theme_options['bookmarklet-76'] != '' && $theme_options['bookmarklet-76']['url'] != '') {
      echo '<link rel="apple-touch-icon-precomposed" sizes="76x76" href="' . esc_attr($theme_options['bookmarklet-76']['url']) . '"/>';
    }
    if ($theme_options['bookmarklet-114'] != '' && $theme_options['bookmarklet-114']['url'] != '') {
      echo '<link rel="icon" type="image/png" href="' . esc_attr($theme_options['bookmarklet-114']['url']) . '">';
    }
    if ($theme_options['bookmarklet-120'] != '' && $theme_options['bookmarklet-120']['url'] != '') {
      echo '<link rel="icon" type="image/png" href="' . esc_attr($theme_options['bookmarklet-120']['url']) . '">';
    }
    if ($theme_options['bookmarklet-144'] != '' && $theme_options['bookmarklet-144']['url'] != '') {
      echo '<link rel="icon" type="image/png" href="' . esc_attr($theme_options['bookmarklet-144']['url']) . '">';
    }
    if ($theme_options['bookmarklet-152'] != '' && $theme_options['bookmarklet-152']['url'] != '') {
      echo '<link rel="icon" type="image/png" href="' . esc_attr($theme_options['bookmarklet-152']['url']) . '">';
    }

    if ($theme_options['custom-code-css'] != '') { ?>
      <style type="text/css" media="screen" id="bcn-custom-css">
        <?php
         echo esc_html($theme_options['custom-code-css']);
         ?>
      </style>
    <?php }
  } ?>


</head>

<body <?php body_class("theme-black"); ?> >
<div id="page" class="site">

  <?php
  if (class_exists('ReduxFramework')) {
    if (isset($theme_options['header-layout'])) {
      if ($theme_options['header-layout'] == 1) {
        ?>

        <header class="page-header"
                <?php if ($theme_options['main-menu-sticky'] == 1) { ?>data-uk-sticky<?php } ?>>
          <div class="page-header__wrapper"
               data-uk-scrollspy="target: > .header-animate; cls:uk-animation-slide-top-small; delay: 600">
            <nav class="main-nav main-nav--hor">
              <div class="main-nav__hamburger-wrapper">
                <button class="icon main-nav__hamburger" id="hamburger-one">
                  <span></span>
                  <span></span>
                  <span></span>
                  <span></span>
                </button>
              </div>

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
                  if ($theme_options['logo'] != '' && $theme_options['logo']['url'] != '') {
                    echo '<img class="main-nav__logo-img" src="' . esc_html($theme_options['logo']['url']) . '" ' . (($theme_options['logo-retina']['url'] != '') ? 'srcset="' . esc_html($theme_options['logo-retina']['url']) . ' 2x"' : '') . ' alt="' . (($theme_options['logo-alt'] != '') ? '' . esc_html($theme_options['logo-alt']) . '' : '' . get_bloginfo('description', 'display') . '') . '" title="' . (($theme_options['logo-title'] != '') ? '' . esc_html($theme_options['logo-title']) . '' : '' . get_bloginfo('description', 'display') . '') . '">';
                  }
                  echo "</picture>";
                }
                ?>
              </a>

              <?php
              wp_nav_menu(array(
                'container' => false,
                'menu' => esc_html($theme_options['main-menu-select']),
                'menu_id' => esc_html($theme_options['main-menu-select']),
                'menu_class' => 'menu menu-wrapper menu-wrapper-opened menu-wrapper-nojs',
                'echo' => true,
              ));
              ?>
            </nav>
            <?php if ($theme_options['main-menu-date'] == 1) { ?>
              <div class="date date--hor header-animate"><?php echo date('M d', current_time('timestamp', 1)) ?></div>
            <?php } ?>

            <?php if ($theme_options['main-menu-weather'] == 1) { ?>
              <div class="weather weather--hor header-animate">
                <div class="weather__num">+25°</div>
                <div class="weather__location">San Francisco, CA</div>
              </div>
            <?php } ?>

            <ul class="usernav usernav--hor header-animate__">
              <?php if ($theme_options['main-menu-search'] == 1) { ?>
                <li class="usernav__search">
                  <button class="usernav__search-icon uk-search-icon uk-icon"
                          data-uk-icon="search"></button>
                </li>
              <?php } ?>
              <?php if ($theme_options['main-menu-flip'] == 1) { ?>
                <li class="usernav__hamburger-wrapper">
                  <div class="usernav__hamburger">
                    <span></span>
                  </div>
                </li>
              <?php } ?>
            </ul>
          </div>
        </header>

        <?php
      } elseif ($theme_options['header-layout'] == 2) {
        echo "Left panel";
      }
    } else {
      ?>
      <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'bcn'); ?></a>

      <header id="masthead" class="site-header">
        <div class="site-branding">
          <?php
          the_custom_logo();
          if (is_front_page() && is_home()) :
            ?>
            <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                      rel="home"><?php bloginfo('name'); ?></a></h1>
          <?php
          else :
            ?>
            <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                     rel="home"><?php bloginfo('name'); ?></a></p>
          <?php
          endif;
          $bcn_description = get_bloginfo('description', 'display');
          if ($bcn_description || is_customize_preview()) :
            ?>
            <p class="site-description"><?php echo esc_html($bcn_description); /* WPCS: xss ok. */ ?></p>
          <?php endif; ?>
        </div><!-- .site-branding -->

        <nav id="site-navigation" class="main-navigation">
          <button class="menu-toggle" aria-controls="primary-menu"
                  aria-expanded="false"><?php esc_html_e('Primary Menu', 'bcn'); ?></button>
          <?php
          wp_nav_menu(array(
            'theme_location' => 'menu-1',
            'menu_id' => 'primary-menu',
          ));
          ?>
        </nav><!-- #site-navigation -->
      </header><!-- #masthead -->
      <?php
    }
  }
  ?>

  <div id="content" class="site-content">



