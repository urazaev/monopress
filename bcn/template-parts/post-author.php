<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 3/12/19
 * Time: 4:09 PM
 */

// Get Author Data
$author = get_the_author();
$author_description = get_the_author_meta('description');
$author_url = esc_url(get_author_posts_url(get_the_author_meta('ID')));
$author_website = get_the_author_meta('url');
$author_avatar = get_avatar(get_the_author_meta('user_email'), apply_filters('wpex_author_bio_avatar_size', 75));

// Get socials
$author_facebook = get_the_author_meta('facebook');
$author_twitter = get_the_author_meta('twitter');
$author_instagram = get_the_author_meta('instagram');
$author_youtube = get_the_author_meta('youtube');
$author_telegram = get_the_author_meta('telegram');
$author_pinterest = get_the_author_meta('pinterest');
$author_google_plus = get_the_author_meta('google-plus');
$author_vimeo = get_the_author_meta('vimeo');
$author_soundcloud = get_the_author_meta('soundcloud');
$author_spotify = get_the_author_meta('spotify');
$author_dribbble = get_the_author_meta('dribbble');
$author_behance = get_the_author_meta('behance');
$author_github = get_the_author_meta('github');
$author_vk = get_the_author_meta('vk');
$author_linkedin = get_the_author_meta('linkedin');
$author_twitch = get_the_author_meta('twitch');
$author_flickr = get_the_author_meta('flickr');
$author_snapchat = get_the_author_meta('snapchat');
$author_medium = get_the_author_meta('medium');
$author_tumblr = get_the_author_meta('tumblr');
$author_bloglovin = get_the_author_meta('bloglovin');
$author_rss = get_the_author_meta('rss');

?>

<div class="author-box-container">
	<div class="author-box-wrap row">

		<?php if ($author_avatar) { ?>
			<div class="col-sm-auto up-author-img">
				<a href="<?php echo esc_url($author_url); ?>" rel="author">
					<?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('wpex_author_bio_avatar_size', 75)); ?>
				</a>
			</div>
		<?php } ?>

		<div class="col-sm desc">
			<div class="row">
				<div class="col-sm-6 up-author-name vcard author">
					<span class="fn">
						<a href="<?php echo esc_url($author_url); ?>"><?php echo esc_html($author) ?></a>
					</span>
				</div>

				<div class="col-sm-6 up-author-social">

					<?php if ($author_facebook) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_facebook) ?>" title="Facebook">
					<i class="fa fa-facebook-official"></i>
				</a>
			</span>
					<?php } ?>
					<?php if ($author_twitter) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_twitter) ?>" title="Twitter">
					<i class="fa fa-twitter-square"></i>
				</a>
			</span>
					<?php } ?>
					<?php if ($author_instagram) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_instagram) ?>" title="Instagram">
					<i class="fa fa-instagram"></i>
				</a>
			</span>
					<?php } ?>
					<?php if ($author_youtube) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_youtube) ?>" title="Youtube">
					<i class="fa fa-facebook-official"></i>
				</a>
			</span>
					<?php } ?>
					<?php if ($author_telegram) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_telegram) ?>" title="Telegram">
					<i class="fa fa-telegram"></i>
				</a>
			</span>
					<?php } ?>




					<?php if ($author_pinterest) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_pinterest) ?>" title="Pinterest">
					<i class="fa fa-pinterest"></i>
				</a>
			</span>
					<?php } ?>

					<?php if ($author_google_plus) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_google_plus) ?>" title="Google plus">
					<i class="fa fa-google-plus-square"></i>
				</a>
			</span>
					<?php } ?>

					<?php if ($author_vimeo) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_vimeo) ?>" title="Vimeo">
					<i class="fa fa-vimeo"></i>
				</a>
			</span>
					<?php } ?>

					<?php if ($author_soundcloud) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_soundcloud) ?>" title="Soundcloud">
					<i class="fa fa-soundcloud"></i>
				</a>
			</span>
					<?php } ?>

					<?php if ($author_spotify) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_spotify) ?>" title="Spotify">
					<i class="fa fa-spotify"></i>
				</a>
			</span>
					<?php } ?>

					<?php if ($author_dribbble) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_dribbble) ?>" title="Dribbble">
					<i class="fa fa-dribbble"></i>
				</a>
			</span>
					<?php } ?>

					<?php if ($author_behance) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_behance) ?>" title="Behance">
					<i class="fa fa-behance"></i>
				</a>
			</span>
					<?php } ?>

					<?php if ($author_github) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_github) ?>" title="Github">
					<i class="fa fa-github"></i>
				</a>
			</span>
					<?php } ?>

					<?php if ($author_vk) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_vk) ?>" title="Vk">
					<i class="fa fa-vk"></i>
				</a>
			</span>
					<?php } ?>

					<?php if ($author_linkedin) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_linkedin) ?>" title="Linkedin">
					<i class="fa fa-linkedin"></i>
				</a>
			</span>
					<?php } ?>

					<?php if ($author_twitch) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_twitch) ?>" title="Twitch">
					<i class="fa fa-twitch"></i>
				</a>
			</span>
					<?php } ?>

					<?php if ($author_flickr) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_flickr) ?>" title="Flickr">
					<i class="fa fa-flickr"></i>
				</a>
			</span>
					<?php } ?>

					<?php if ($author_snapchat) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_snapchat) ?>" title="Snapchat">
					<i class="fa fa-snapchat"></i>
				</a>
			</span>
					<?php } ?>

					<?php if ($author_medium) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_medium) ?>" title="Medium">
					<i class="fa fa-medium"></i>
				</a>
			</span>
					<?php } ?>

					<?php if ($author_tumblr) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_tumblr) ?>" title="Tumblr">
					<i class="fa fa-tumblr"></i>
				</a>
			</span>
					<?php } ?>

					<?php if ($author_bloglovin) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_bloglovin) ?>" title="Bloglovin">
					Bloglovin
				</a>
			</span>
					<?php } ?>

					<?php if ($author_rss) { ?>
						<span class="up-social-icon-wrap">
				<a target="_blank" href="<?php echo esc_url($author_rss) ?>" title="Rss">
					<i class="fa fa-rss-square"></i>
				</a>
			</span>
					<?php } ?>
				</div>

				<?php if ($author_website) { ?>
					<div class="col-12 up-author-url">
						<a href="<?php echo esc_url($author_website); ?>"
						   title="<?php esc_html_e('View author home page', 'bcn'); ?>"><?php echo esc_url($author_website); ?></a>
					</div>
					<?php
				}
				if ($author_description) {
					?>
					<div class="col-12 up-author-description">
						<?php echo wp_kses_post($author_description); ?>
					</div>
				<?php } ?>
			</div>


		</div>
	</div>
</div>
