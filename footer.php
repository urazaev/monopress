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

<footer id="colophon" class="site-footer">
  <div class="site-info">
    <a href="<?php echo esc_url(__('https://wordpress.org/', 'bcn')); ?>">
      <?php
      /* translators: %s: CMS name, i.e. WordPress. */
      printf(esc_html__('Proudly powered by %s', 'bcn'), 'WordPress');
      ?>
    </a>
    <span class="sep"> | </span>
    <?php
    /* translators: 1: Theme name, 2: Theme author. */
    printf(esc_html__('Theme: %1$s by %2$s.', 'bcn'), 'bcn', '<a href="http://underscores.me/">Underscores.me</a>');
    ?>
  </div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php if ($theme_options['main-menu-flip'] == 1) : ?>
  <section class="flip-block">
    <div class="flip-block__wrapper uk-article">

      <img class="" src=""
           srcset="" alt="About image">


      <p class="uk-margin-medium">You can write a little something about yourself here, or you can customize your
        sidebar however you’d like! You
        can add, rearrange, and delete any widgets - the options are endless!</p>


      <a class="button button--big button--green" href="#">About Us</a>
      <a class="button button--big button--blue uk-margin-left" href="#">Contact Us</a>

      <ul class="social__horizontal-list social__horizontal-list--align-right">

        <li class="social__horizontal-item">
          <a class="social__horizontal-link social__horizontal-link--instagram"
             href="https://www.instagram.com/urazaev_production/">
            <i class="" data-uk-icon="instagram"></i>
          </a>
        </li>
        <li class="social__horizontal-item">
          <a class="social__horizontal-link social__horizontal-link--twitter"
             href="https://twitter.com/UrazaevCom">
            <i data-uk-icon="twitter"></i>
          </a>
        </li>
        <li class="social__horizontal-item">
          <a class="social__horizontal-link social__horizontal-link--facebook"
             href="https://www.facebook.com/urazaevcom/">
            <i class="fab fa-facebook-f social__horizontal-img-icon" data-uk-icon="facebook"></i>
          </a>
        </li>

      </ul>

    </div>
  </section>
<?php endif; ?>

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
<?php endif; ?>

<?php wp_footer();
if (class_exists('ReduxFramework')) {
  if ($theme_options['footer-on'] == 1) {

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
                if ($theme_options['logo'] != '' && $theme_options['logo']['url'] != '') {
                  echo '<img class="main-nav__logo-img" src="' . esc_html($theme_options['logo']['url']) . '" ' . (($theme_options['logo-retina']['url'] != '') ? 'srcset="' . esc_html($theme_options['logo-retina']['url']) . ' 2x"' : '') . ' alt="' . (($theme_options['logo-alt'] != '') ? '' . esc_html($theme_options['logo-alt']) . '' : '' . get_bloginfo('description', 'display') . '') . '" title="' . (($theme_options['logo-title'] != '') ? '' . esc_html($theme_options['logo-title']) . '' : '' . get_bloginfo('description', 'display') . '') . '">';
                }
                echo "</picture>";
              }
              ?>
            </a>
          </p>
          <?php
          if ($theme_options['footer-text'] != '') {
            echo '<p class="footer-txt">' .esc_html($theme_options['footer-text']). '</p>';
          }
          ?>

          <?php
          if ($theme_options['footer-email'] != '') {
            echo '<p class="footer-contacts">Contact us <a href="mailto:' .esc_html($theme_options['footer-email']). '">'.esc_html($theme_options['footer-email']).'</a></p>';
          }
          ?>

          <?php
          if ($theme_options['footer-social'] == '1') {
            echo '<p class="footer-socials"><ul class="social-listing"><li><a href="#">item</a><a href="#">item</a></li></ul></a></p>';
          }
          ?>

        </div>
      </div>
    </footer>

    <?php
  }
}
if (class_exists('ReduxFramework')) {
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


</body>
</html>
