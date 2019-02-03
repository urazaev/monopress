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

<?php wp_footer(); ?>


</body>
</html>
