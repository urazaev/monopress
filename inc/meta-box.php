<?php
/**
 * bcn Theme Meta boxes
 *
 * @package bcn
 */
//
//function bcn_get_meta_box($meta_boxes)
//{
//	$prefix = 'bcn_meta_';
//
////	 Page meta boxes
//
//	$meta_boxes[] = array(
//		'id' => 'page_template',
//		'title' => esc_html__('Page Template Settings', 'bcn'),
//		'post_types' => array('page'),
//		'context' => 'advanced',
//		'priority' => 'default',
//		'autosave' => 'false',
//		'fields' => array(
//			array(
//				'id' => $prefix . 'sidebar',
//				'type' => 'image_select',
//				'name' => esc_html__('Sidebar position', 'bcn'),
//				'force_delete' => 'false',
//				'max_file_uploads' => '4',
//				'options' => array(
//					'-1' => get_template_directory_uri() . '/images/admin/layout-default.png',
//					'1' => get_template_directory_uri() . '/images/admin/layout-no-sidebar.png',
//					'2' => get_template_directory_uri() . '/images/admin/layout-left-sidebar.png',
//					'3' => get_template_directory_uri() . '/images/admin/layout-right-sidebar.png',
//				),
//			),
//		),
//	);
//
//	return $meta_boxes;
//}
//
//add_filter('rwmb_meta_boxes', 'bcn_get_meta_box');


/** START --- Initialize the CMB2 Metabox & Related Classes */
function initialize_showcase_meta_box()
{
	require_once(get_template_directory() . '/inc/cmb2/image_select_metafield.php'); //CMB2 Buttonset Field
}

add_action('init', 'initialize_showcase_meta_box', 9999);

/** LOAD --- Related CSS and JS */
function load_custom_cmb2_script()
{
	wp_enqueue_style('cmb2_imgselect-css', get_template_directory_uri() . '/inc/cmb2/image_select_metafield.css', false, '1.0.0'); //CMB2 Image_select Field Styling
	wp_enqueue_script('cmb2_imgselect-js', get_template_directory_uri() . '/inc/cmb2/image_select_metafield.js', '', '1.0.0', true);  // CMB2 Image_select Event
}

add_action('admin_enqueue_scripts', 'load_custom_cmb2_script', 20);


add_action('cmb2_admin_init', 'cmb2_sample_metaboxes');
/**
 * Define the metabox and field configurations.
 */

function cmb2_sample_metaboxes()
{

	/**
	 * Initiate the metabox
	 */

	$cmb_page = new_cmb2_box(array(
		'id' => 'page-sidebar',
		'title' => esc_html__('Layout options', 'cmb2'),
		'object_types' => array('page',), // Post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
	));

	$cmb_page->add_field(array(
		'name' => esc_html__('Sidebar position', 'cmb2'),
		'id' => 'meta_page-template-sidebar',
		'type' => 'image_select',
		'options' => array(
			'1' => array('title' => 'No Sidebar', 'alt' => 'No Sidebar', 'img' => get_template_directory_uri() . '/images/admin/layout-no-sidebar.png'),
			'2' => array('title' => 'Sidebar left', 'alt' => 'Sidebar left', 'img' => get_template_directory_uri() . '/images/admin/layout-left-sidebar.png'),
			'3' => array('title' => 'Sidebar Right', 'alt' => 'Sidebar Right', 'img' => get_template_directory_uri() . '/images/admin/layout-right-sidebar.png'),
		),
//		'default' => 'default',
	));

	$cmb_main_page = new_cmb2_box(array(
		'id' => 'main-page-title',
		'title' => esc_html__('Main page options', 'cmb2'),
		'object_types' => array('page',), // Post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'show_on' => array('key' => 'page-template', 'value' => 'index.php'),
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	));

	$cmb_main_page->add_field(array(
		'name' => esc_html__('Featured post categories', 'cmb2'),
		'id' => 'meta_main-page-featured-cat',
		'type' => 'taxonomy_select',
		'taxonomy' => 'category', // Taxonomy Slug
	));

	$cmb_main_page->add_field(array(
		'name' => esc_html__('Featured post limit', 'cmb2'),
		'id' => 'meta_main-page-featured-num',
		'type' => 'text',
		'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	));

	$cmb_main_page->add_field(array(
		'name' => esc_html__('Featured posts layout', 'cmb2'),
		'id' => 'meta_main-page-featured-display',
		'type' => 'image_select',
		'options' => array(
			'2' => array('title' => 'Post layout 2', 'alt' => 'Post layout 2', 'img' => get_template_directory_uri() . '/images/admin/post-layout-02.png'),
			'4' => array('title' => 'Post layout 4', 'alt' => 'Post layout 4', 'img' => get_template_directory_uri() . '/images/admin/post-layout-04.png'),
			'7' => array('title' => 'Post layout 7', 'alt' => 'Post layout 7', 'img' => get_template_directory_uri() . '/images/admin/post-layout-07.png'),
			'14' => array('title' => 'Post layout 14', 'alt' => 'Post layout 14', 'img' => get_template_directory_uri() . '/images/admin/post-layout-14.png'),
			'21' => array('title' => 'Post layout 21', 'alt' => 'Post layout 21', 'img' => get_template_directory_uri() . '/images/admin/post-layout-21.png'),
			'22' => array('title' => 'Post layout 22', 'alt' => 'Post layout 22', 'img' => get_template_directory_uri() . '/images/admin/post-layout-22.png'),
		),
//		'default' => 'default',
	));
	$cmb_main_page->add_field(array(
		'name' => esc_html__('Regular posts layout', 'cmb2'),
		'id' => 'meta_main-page-display',
		'type' => 'image_select',
		'options' => array(
//			'default' => array('title' => 'Use global', 'alt' => 'Full Width', 'img' => get_template_directory_uri() .  '/images/admin/layout-default.png'),
			'2' => array('title' => 'Post layout 2', 'alt' => 'Post layout 2', 'img' => get_template_directory_uri() . '/images/admin/post-layout-02.png'),
			'4' => array('title' => 'Post layout 4', 'alt' => 'Post layout 4', 'img' => get_template_directory_uri() . '/images/admin/post-layout-04.png'),
			'7' => array('title' => 'Post layout 7', 'alt' => 'Post layout 7', 'img' => get_template_directory_uri() . '/images/admin/post-layout-07.png'),
			'14' => array('title' => 'Post layout 14', 'alt' => 'Post layout 14', 'img' => get_template_directory_uri() . '/images/admin/post-layout-14.png'),
			'21' => array('title' => 'Post layout 21', 'alt' => 'Post layout 21', 'img' => get_template_directory_uri() . '/images/admin/post-layout-21.png'),
			'22' => array('title' => 'Post layout 22', 'alt' => 'Post layout 22', 'img' => get_template_directory_uri() . '/images/admin/post-layout-22.png'),
		),
//		'default' => 'default',
	));



	$cmb_post = new_cmb2_box(array(
		'id' => 'post_metabox',
		'title' => esc_html__('Post layout options', 'cmb2'),
		'object_types' => array('post',), // Post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	));

	$cmb_post->add_field(array(
		'name' => esc_html__('Sidebar position', 'cmb2'),
		'id' => 'meta_post-sidebar',
		'type' => 'image_select',
		'options' => array(
//			'default' => array('title' => 'Use global', 'alt' => 'Full Width', 'img' => get_template_directory_uri() .  '/images/admin/layout-default.png'),
			'1' => array('title' => 'No Sidebar', 'alt' => 'No Sidebar', 'img' => get_template_directory_uri() . '/images/admin/layout-no-sidebar.png'),
			'2' => array('title' => 'Sidebar left', 'alt' => 'Sidebar left', 'img' => get_template_directory_uri() . '/images/admin/layout-left-sidebar.png'),
			'3' => array('title' => 'Sidebar Right', 'alt' => 'Sidebar Right', 'img' => get_template_directory_uri() . '/images/admin/layout-right-sidebar.png'),
		),
//		'default' => 'default',
	));

	$cmb_post->add_field(array(
		'name' => esc_html__('Post layout', 'cmb2'),
		'id' => 'meta_post-template-default',
		'type' => 'image_select',
		'options' => array(
//			'default' => array('title' => 'Use global', 'alt' => 'Full Width', 'img' => get_template_directory_uri() .  '/images/admin/layout-default.png'),
			'1' => array('title' => 'Post layout 1', 'alt' => 'Full Width', 'img' => get_template_directory_uri() . '/images/admin/layout-single-post-1.png'),
			'2' => array('title' => 'Post layout 2', 'alt' => 'Sidebar Left', 'img' => get_template_directory_uri() . '/images/admin/layout-single-post-2.png'),
			'3' => array('title' => 'Post layout 3', 'alt' => 'Sidebar Right', 'img' => get_template_directory_uri() . '/images/admin/layout-single-post-3.png'),
		),
//		'default' => 'default',
	));
}
