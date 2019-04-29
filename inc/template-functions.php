<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package bcn
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */

global $theme_options;

function bcn_body_classes($classes)
{
	// Adds a class of hfeed to non-singular pages.
	if (!is_singular()) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if (!is_active_sidebar('sidebar-1')) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}

add_filter('body_class', 'bcn_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function bcn_pingback_header()
{
	if (is_singular() && pings_open()) {
		echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
	}
}

add_action('wp_head', 'bcn_pingback_header');


/**
 * infinite scroll
 **/
function wp_infinitepaginate()
{
	$loopFile = $_POST['loop_file'];
	$paged = $_POST['page_no'];
	$posts_per_page = get_option('posts_per_page');
	query_posts(array('paged' => $paged));
	get_template_part($loopFile);
	exit;
}

add_action('wp_ajax_infinite_scroll', 'wp_infinitepaginate');           // for logged in user
add_action('wp_ajax_nopriv_infinite_scroll', 'wp_infinitepaginate');    // if user not logged in


/**
 * custom comments listing
 **/
class up_walker_comment extends Walker
{

	/**
	 * What the class handles.
	 *
	 * @since 2.7.0
	 * @var string
	 *
	 * @see Walker::$tree_type
	 */
	public $tree_type = 'comment';

	/**
	 * Database fields to use.
	 *
	 * @since 2.7.0
	 * @var array
	 *
	 * @see Walker::$db_fields
	 * @todo Decouple this
	 */
	public $db_fields = array(
		'parent' => 'comment_parent',
		'id' => 'comment_ID',
	);

	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::start_lvl()
	 * @global int $comment_depth
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param int $depth Optional. Depth of the current comment. Default 0.
	 * @param array $args Optional. Uses 'style' argument for type of HTML list. Default empty array.
	 */
	public function start_lvl(&$output, $depth = 0, $args = array())
	{
		$GLOBALS['comment_depth'] = $depth + 1;

		switch ($args['style']) {
			case 'div':
				break;
			case 'ol':
				$output .= '<!-- up walker --><ol class="children">' . "\n";
				break;
			case 'ul':
			default:
				$output .= '<ul class="children">' . "\n";
				break;
		}
	}

	/**
	 * Ends the list of items after the elements are added.
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::end_lvl()
	 * @global int $comment_depth
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param int $depth Optional. Depth of the current comment. Default 0.
	 * @param array $args Optional. Will only append content if style argument value is 'ol' or 'ul'.
	 *                       Default empty array.
	 */
	public function end_lvl(&$output, $depth = 0, $args = array())
	{
		$GLOBALS['comment_depth'] = $depth + 1;

		switch ($args['style']) {
			case 'div':
				break;
			case 'ol':
				$output .= "</ol><!-- .children -->\n";
				break;
			case 'ul':
			default:
				$output .= "</ul><!-- .children -->\n";
				break;
		}
	}

	/**
	 * Traverses elements to create list from elements.
	 *
	 * This function is designed to enhance Walker::display_element() to
	 * display children of higher nesting levels than selected inline on
	 * the highest depth level displayed. This prevents them being orphaned
	 * at the end of the comment list.
	 *
	 * Example: max_depth = 2, with 5 levels of nested content.
	 *     1
	 *      1.1
	 *        1.1.1
	 *        1.1.1.1
	 *        1.1.1.1.1
	 *        1.1.2
	 *        1.1.2.1
	 *     2
	 *      2.2
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::display_element()
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $element Comment data object.
	 * @param array $children_elements List of elements to continue traversing. Passed by reference.
	 * @param int $max_depth Max depth to traverse.
	 * @param int $depth Depth of the current element.
	 * @param array $args An array of arguments.
	 * @param string $output Used to append additional content. Passed by reference.
	 */
	public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
	{
		if (!$element) {
			return;
		}

		$id_field = $this->db_fields['id'];
		$id = $element->$id_field;

		parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);

		/*
         * If at the max depth, and the current element still has children, loop over those
         * and display them at this level. This is to prevent them being orphaned to the end
         * of the list.
         */
		if ($max_depth <= $depth + 1 && isset($children_elements[$id])) {
			foreach ($children_elements[$id] as $child) {
				$this->display_element($child, $children_elements, $max_depth, $depth, $args, $output);
			}

			unset($children_elements[$id]);
		}

	}

	/**
	 * Starts the element output.
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::start_el()
	 * @see wp_list_comments()
	 * @global int $comment_depth
	 * @global WP_Comment $comment
	 *
	 * @param string $output Used to append additional content. Passed by reference.
	 * @param WP_Comment $comment Comment data object.
	 * @param int $depth Optional. Depth of the current comment in reference to parents. Default 0.
	 * @param array $args Optional. An array of arguments. Default empty array.
	 * @param int $id Optional. ID of the current comment. Default 0 (unused).
	 */
	public function start_el(&$output, $comment, $depth = 0, $args = array(), $id = 0)
	{
		$depth++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment'] = $comment;

		if (!empty($args['callback'])) {
			ob_start();
			call_user_func($args['callback'], $comment, $args, $depth);
			$output .= ob_get_clean();
			return;
		}

		if (('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type) && $args['short_ping']) {
			ob_start();
			$this->ping($comment, $depth, $args);
			$output .= ob_get_clean();
		} elseif ('html5' === $args['format']) {
			ob_start();
			$this->html5_comment($comment, $depth, $args);
			$output .= ob_get_clean();
		} else {
			ob_start();
			$this->comment($comment, $depth, $args);
			$output .= ob_get_clean();
		}
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::end_el()
	 * @see wp_list_comments()
	 *
	 * @param string $output Used to append additional content. Passed by reference.
	 * @param WP_Comment $comment The current comment object. Default current comment.
	 * @param int $depth Optional. Depth of the current comment. Default 0.
	 * @param array $args Optional. An array of arguments. Default empty array.
	 */
	public function end_el(&$output, $comment, $depth = 0, $args = array())
	{
		if (!empty($args['end-callback'])) {
			ob_start();
			call_user_func($args['end-callback'], $comment, $args, $depth);
			$output .= ob_get_clean();
			return;
		}
		if ('div' == $args['style']) {
			$output .= "</div><!-- #comment-## -->\n";
		} else {
			$output .= "</li><!-- #comment-## -->\n";
		}
	}

	/**
	 * Outputs a pingback comment.
	 *
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment The comment object.
	 * @param int $depth Depth of the current comment.
	 * @param array $args An array of arguments.
	 */
	protected function ping($comment, $depth, $args)
	{
		$tag = ('div' == $args['style']) ? 'div' : 'li';
		?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class('', $comment); ?>>
		<div class="comment-body comments-block__item">
			<?php _e('Pingback:'); ?><?php comment_author_link($comment); ?><?php edit_comment_link(__('Edit'), '<span class="edit-link">', '</span>'); ?>
		</div>
		<?php
	}

	/**
	 * Outputs a single comment.
	 *
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int $depth Depth of the current comment.
	 * @param array $args An array of arguments.
	 */
	protected function comment($comment, $depth, $args)
	{
		if ('div' == $args['style']) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}

		$commenter = wp_get_current_commenter();
		if ($commenter['comment_author_email']) {
			$moderation_note = __('Your comment is awaiting moderation.');
		} else {
			$moderation_note = __('Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.');
		}

		?>
		<<?php echo $tag; ?><?php comment_class($this->has_children ? 'parent' : '', $comment); ?> id="comment-<?php comment_ID(); ?>">
		<?php if ('div' != $args['style']) : ?>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body comments-block__item">
	<?php endif; ?>
		<div class="comment-author vcard">
			<?php
			if (0 != $args['avatar_size']) {
				echo get_avatar($comment, $args['avatar_size']);
			}
			?>
			<?php
			/* translators: %s: comment author link */
			printf(
				__('%s <span class="says">says:</span>'),
				sprintf('<cite class="fn">%s</cite>', get_comment_author_link($comment))
			);
			?>
		</div>
		<?php if ('0' == $comment->comment_approved) : ?>
		<em class="comment-awaiting-moderation"><?php echo $moderation_note; ?></em>
		<br/>
	<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url(get_comment_link($comment, $args)); ?>">
				<?php
				/* translators: 1: comment date, 2: comment time */
				printf(__('%1$s at %2$s'), get_comment_date('', $comment), get_comment_time());
				?>
			</a>
			<?php
			edit_comment_link(__('(Edit)'), '&nbsp;&nbsp;', '');
			?>
		</div>

		<?php
		comment_text(
			$comment,
			array_merge(
				$args,
				array(
					'add_below' => $add_below,
					'depth' => $depth,
					'max_depth' => $args['max_depth'],
				)
			)
		);
		?>

		<?php
		comment_reply_link(
			array_merge(
				$args,
				array(
					'add_below' => $add_below,
					'depth' => $depth,
					'max_depth' => $args['max_depth'],
					'before' => '<div class="reply">',
					'after' => '</div>',
				)
			)
		);
		?>

		<?php if ('div' != $args['style']) : ?>
		</div>
	<?php endif; ?>
		<?php
	}

	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int $depth Depth of the current comment.
	 * @param array $args An array of arguments.
	 */
	protected function html5_comment($comment, $depth, $args)
	{
		$tag = ('div' === $args['style']) ? 'div' : 'li';

		$commenter = wp_get_current_commenter();
		if ($commenter['comment_author_email']) {
			$moderation_note = __('Your comment is awaiting moderation.');
		} else {
			$moderation_note = __('Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.');
		}

		?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class($this->has_children ? 'parent' : '', $comment); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body comments-block__item">
			<div class="comments-block__wrapper">

				<figure class="comments-block__img">
					<?php
					if (0 != $args['avatar_size']) {
						echo get_avatar($comment, $args['avatar_size']);
					}
					?>
				</figure>

				<div class="comments-block__text-block">
					<div class="comments-block__top-line-wrapper">
						<div class="comments-block__author-info">
                    <span class="comment-author vcard comments-block__author">
						<?php
						/* translators: %s: comment author link */
						printf(
							__('%s'),
							sprintf('<span class="fn">%s</span>', get_comment_author_link($comment))
						);
						?>
                    </span>
							<span class="comments-block__date">
								<a href="<?php echo esc_url(get_comment_link($comment, $args)); ?>">
						<time datetime="<?php comment_time('c'); ?>">
							<?php
							/* translators: 1: comment date, 2: comment time */
							printf(__('%1$s at %2$s'), get_comment_date('', $comment), get_comment_time());
							?>
						</time>
					</a>
							</span>
						</div>
						<span class="comments-block__reply">

							<?php
							comment_reply_link(
								array_merge(
									$args,
									array(
										'add_below' => 'div-comment',
										'depth' => $depth,
										'max_depth' => $args['max_depth'],
									)
								)
							);
							?>

							<?php edit_comment_link(__('Edit')); ?>

						</span>
					</div>
					<div class="comment-content comments-block__text">
						<?php comment_text(); ?>
					</div>
				</div>

			</div>

		</article><!-- .comment-body -->
		<?php
	}
}


/**
 * Theme Options css
 */

function addPanelCSS()
{
	wp_register_style(
		'redux-custom-css',
		get_template_directory_uri() . '/css/redux-admin.min.css',
		array('redux-admin-css'), // Be sure to include redux-admin-css so it's appended after the core css is applied
		time(),
		'all'
	);
	wp_enqueue_style('redux-custom-css');
}

/**
 * custom thumbs
 **/

if (function_exists('add_image_size')) {
	add_image_size('post_block_02', 590, 375, true);
	add_image_size('post_block_03', 800, 900, true);
	add_image_size('post_block_04', 750, 400, true);
	add_image_size('post_block_05', 1375, 900, true);
	add_image_size('post_block_07', 962, 700, true);
	add_image_size('post_block_09', 1600, 900, true);
	add_image_size('post_block_14', 545, 350, true);
	add_image_size('post_block_19', 800, 900, true);
	add_image_size('post_block_21', 700, 370, true);
	add_image_size('portfolio_masonry_thumb', 500, '', true);
	add_image_size('portfolio_masonry_thumb_x2', 1000, '', true);
	add_image_size('portfolio_grid_thumb', 500, 500, true);
	add_image_size('portfolio_grid_thumb_x2', 1000, 1000, true);
	add_image_size('search_grid_thumb', 400, 400, true);
}

/**
 * Theme Options
 */
if (!isset($theme_options) && file_exists(get_template_directory() . '/inc/theme-options.php')) {
	require_once(get_template_directory() . '/inc/theme-options.php');
}

// This example assumes your opt_name is set to redux_demo, replace with your opt_name value
add_action('redux/page/theme_options/enqueue', 'addPanelCSS');


if (!function_exists('up_get_template')) {

	/**
	 * get template parts
	 **/

	function up_get_template($template, $name = null)
	{
		get_template_part('template-parts/' . $template, $name);
	}
}

if (!function_exists('up_cat_pagination')) {

	/**
	 * get pagination
	 **/

	function up_cat_pagination()
	{
		if (class_exists('ReduxFramework')) {
			global $theme_options;
			if ($theme_options['category-pagination'] == 1) {
				the_posts_pagination(array(
					'mid_size' => 2,
					'prev_text' => __('«'),
					'next_text' => __('»'),
				));
			}
		}
	}
}


if (!function_exists('up_section_echo')) {

	/**
	 * get breadcrumbs
	 * @param string $section_class for class name
	 * @param string $section_id for id name
	 **/

	function up_section_echo($section_class = 'section', $section_id = '')
	{
		echo '<section class="' . $section_class . '" id="' . $section_id . '">';

	}
}


/**
 * custom body class
 **/

function my_own_body_classes($classes)
{
	global $theme_options;
	if (class_exists('ReduxFramework')) {
		if ($theme_options['portfolio-template-default'] == '2' || is_page_template('template-parts/page_portfolio_grid.php')) {
			if ($theme_options['portfolio-show-filter'] == '1') {
				$classes[] = 'body-right-margin';
			}
		}
	}

	return $classes;
}

add_filter('body_class', 'my_own_body_classes');

/**
 * breadcrumbs
 * @param string $outer_class for class name
 **/

function the_breadcrumb($outer_class = 'breadcrumbs')
{
	global $theme_options;

	if (class_exists('ReduxFramework')) {
		if ($theme_options['template-settings-breadcrumbs-sep']) {
			$sep = $theme_options['template-settings-breadcrumbs-sep'];
		} else {
			$sep = ' > ';
		}

		if (!is_front_page()) {
			// Start the breadcrumb with a link to your homepage ?>

		<div class="<?php echo esc_html($outer_class); ?>">

			<?php
			if ($theme_options['template-settings-breadcrumbs-home'] == '1') {
				echo '<a href="';
				echo get_option('home');
				echo '">';
				bloginfo('name');
				echo '</a>';
			}


			if ($theme_options['template-settings-breadcrumbs-parent'] == '1') {

				// Check if the current page is a category, an archive or a single page. If so show the category or archive name.
				if (is_category() || is_single()) {
					echo $sep;
					the_category(', ');
				} elseif (is_archive() || is_single()) {
					echo $sep;
					if (is_day()) {
						printf(__('%s', 'bcn'), get_the_date());
					} elseif (is_month()) {
						printf(__('%s', 'bcn'), get_the_date(_x('F Y', 'monthly archives date format', 'bcn')));
					} elseif (is_year()) {
						printf(__('%s', 'bcn'), get_the_date(_x('Y', 'yearly archives date format', 'bcn')));
					} else {
						_e('Blog Archives', 'bcn');
					}
				}
			}

			if ($theme_options['template-settings-breadcrumbs-title'] == '1') {
				// If the current page is a single post, show its title with the separator
				if (is_single()) {
					echo $sep;
					the_title();
				}

				// If the current page is a static page, show its title.
				if (is_page()) {
					echo $sep;
					echo the_title();
				}

				// if you have a static page assigned to be you posts list page. It will find the title of the static page and display it. i.e Home >> Blog
				if (is_home()) {
					echo $sep;
					global $post;
					$page_for_posts_id = get_option('page_for_posts');
					if ($page_for_posts_id) {
						$post = get_page($page_for_posts_id);
						setup_postdata($post);
						the_title();
						rewind_posts();
					}
				}
			}

			echo '</div>';
		}
	}
}

/**
 * excerpt more symbol > ...
 **/

add_filter('excerpt_more', function ($more) {
	return '...';
});
