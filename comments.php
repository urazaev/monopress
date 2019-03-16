<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bcn
 */


global $theme_options;

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
	return;
}
if (class_exists('ReduxFramework')) {
	if ($theme_options['block-show-comments'] == '1') {
		?>

		<section class="comments-block comments-area"
				 data-uk-scrollspy="target: > article; cls:uk-animation-slide-top-small; delay: 500" id="comments">

			<?php
			// You can start editing here -- including this comment!
			if (have_comments()) :
				?>
				<h2 class="comments-title comments-block__header">
					<?php
					$bcn_comment_count = get_comments_number();
					if ('1' === $bcn_comment_count) {
						printf(
						/* translators: 1: title. */
							esc_html__('One thought on &ldquo;%1$s&rdquo;', 'bcn'),
							'<span>' . get_the_title() . '</span>'
						);
					} else {
						printf( // WPCS: XSS OK.
						/* translators: 1: comment count number, 2: title. */
							esc_html(_nx('%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $bcn_comment_count, 'comments title', 'bcn')),
							number_format_i18n($bcn_comment_count),
							'<span>' . get_the_title() . '</span>'
						);
					}
					?>
				</h2><!-- .comments-title -->


				<?php the_comments_navigation(); ?>

				<ol class="comment-list">
					<?php
					wp_list_comments(array(
						'style' => 'ol',
						'max_depth' => '',
						'type' => 'all',
						'avatar_size' => 70,
						'walker' => new up_walker_comment,

					));
					?>
				</ol><!-- .comment-list -->

				<?php
				the_comments_navigation();

				// If comments are closed and there are comments, let's leave a little note, shall we?
				if (!comments_open()) :
					?>
					<p class="no-comments"><?php esc_html_e('Comments are closed.', 'bcn'); ?></p>
				<?php
				endif;

			endif; // Check for have_comments().

			$commenter = wp_get_current_commenter();
			$req = get_option('require_name_email');
			$aria_req = ($req ? " aria-required='true'" : '');

			// TODO: set design for comment form

			$args = array(
				'fields' => apply_filters(
					'comment_form_default_fields', array(

						'author' => ' <div class="row"><div class="comment-form-author col-lg-4">' . '<input id="author" placeholder="' .
							__('Name', 'bcn') .
							($req ? '*' : '') .
							'" name="author" type="text" value="' .
							esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' />' .
//							'<label for="author">' . __('Your Name') . '</label> ' .

							'</div>',

						'email' => '<div class="comment-form-email col-lg-4">' . '<input id="email" placeholder="' .
							__('Email', 'bcn') .
							($req ? '*' : '') .
							'" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) .
							'" size="30"' . $aria_req . ' />' .
//							'<label for="email">' . __('Your Email') . '</label> ' .
							'</div>',

						'url' => '<div class="comment-form-url col-lg-4">' .
							'<input id="url" name="url" placeholder="' .
							__('Website', 'bcn') .
							($req ? '*' : '') .
							'" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30"  /> ' .
//							'<label for="url">' . __('Website', 'domainreference') . '</label>' .
							'</div></div>'

					)
				),

				'comment_field' => '<p class="comment-form-comment">' .
//					'<label for="comment">' . __('Let us know what you have to say:') . '</label>' .
					'<textarea id="comment" name="comment" placeholder="' .
					_x('Comment', 'bcn') .
					'" cols="45" rows="8" aria-required="true"></textarea>' .
					'</p>',
				'class_submit' => 'button button--blue',
//				'title_reply' => '<div class="crunchify-text"> <h5>Please Post Your Comments & Reviews</h5></div>',
//				'comment_notes_after' => '<button type="submit" id="submit-new" class="button"><span>' . __('Post Comment', 'bcn') . '</span></button>',

			);
			comment_form($args);


			?>

		</section>
		<!-- #comments -->
	<?php }
} ?>
