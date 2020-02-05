<?php
/**
 * monopress Theme Meta boxes
 *
 * @package monopress
 */

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
		'title' => esc_html__('Layout options', 'monopress'),
		'object_types' => array('page',), // Post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
	));

	$cmb_page->add_field(array(
		'name' => esc_html__('Sidebar position', 'monopress'),
		'id' => 'meta_page-template-sidebar',
		'type' => 'image_select',
		'options' => array(
			'sidebar_1' => array(
				'title' => 'No Sidebar',
				'alt' => 'No Sidebar',
				'img' => get_template_directory_uri() . '/images/admin/layout-no-sidebar.png'
			),
			'sidebar_2' => array(
				'title' => 'Sidebar left',
				'alt' => 'Sidebar left',
				'img' => get_template_directory_uri() . '/images/admin/layout-left-sidebar.png'
			),
			'sidebar_3' => array(
				'title' => 'Sidebar Right',
				'alt' => 'Sidebar Right',
				'img' => get_template_directory_uri() . '/images/admin/layout-right-sidebar.png'
			),
		),
	));

	$cmb_main_page = new_cmb2_box(array(
		'id' => 'main-page-title',
		'title' => esc_html__('Main page options', 'monopress'),
		'object_types' => array('page',), // Post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'show_on' => array(
			'key' => 'page-template',
			'value' => 'index.php'
		),
	));

	$cmb_main_page->add_field(array(
		'name' => 'Featured post limit',
		'id' => 'meta_main-page-featured-num',
		'type' => 'text',
	));

	$cmb_main_page->add_field(array(
		'name' => esc_html__('Featured posts layout', 'monopress'),
		'id' => 'meta_main-page-featured-display',
		'type' => 'image_select',
		'options' => array(
			'layout_2' => array(
				'title' => 'Post layout 2',
				'alt' => 'Post layout 2',
				'img' => get_template_directory_uri() . '/images/admin/post-layout-02.png'
			),
			'layout_4' => array(
				'title' => 'Post layout 4',
				'alt' => 'Post layout 4',
				'img' => get_template_directory_uri() . '/images/admin/post-layout-04.png'
			),
			'layout_7' => array(
				'title' => 'Post layout 7',
				'alt' => 'Post layout 7',
				'img' => get_template_directory_uri() . '/images/admin/post-layout-07.png'
			),
			'layout_14' => array(
				'title' => 'Post layout 14',
				'alt' => 'Post layout 14',
				'img' => get_template_directory_uri() . '/images/admin/post-layout-14.png'
			),
			'layout_21' => array(
				'title' => 'Post layout 21',
				'alt' => 'Post layout 21',
				'img' => get_template_directory_uri() . '/images/admin/post-layout-21.png'
			),
			'layout_22' => array(
				'title' => 'Post layout 22',
				'alt' => 'Post layout 22',
				'img' => get_template_directory_uri() . '/images/admin/post-layout-22.png'
			),
		),
	));

	$cmb_main_page->add_field(array(
		'name' => esc_html__('Regular posts layout', 'monopress'),
		'id' => 'meta_main-page-display',
		'type' => 'image_select',
		'options' => array(
			'layout_2' => array(
				'title' => 'Post layout 2',
				'alt' => 'Post layout 2',
				'img' => get_template_directory_uri() . '/images/admin/post-layout-02.png'
			),
			'layout_4' => array(
				'title' => 'Post layout 4',
				'alt' => 'Post layout 4',
				'img' => get_template_directory_uri() . '/images/admin/post-layout-04.png'
			),
			'layout_7' => array(
				'title' => 'Post layout 7',
				'alt' => 'Post layout 7',
				'img' => get_template_directory_uri() . '/images/admin/post-layout-07.png'
			),
			'layout_14' => array(
				'title' => 'Post layout 14',
				'alt' => 'Post layout 14',
				'img' => get_template_directory_uri() . '/images/admin/post-layout-14.png'
			),
			'layout_21' => array(
				'title' => 'Post layout 21',
				'alt' => 'Post layout 21',
				'img' => get_template_directory_uri() . '/images/admin/post-layout-21.png'
			),
			'layout_22' => array(
				'title' => 'Post layout 22',
				'alt' => 'Post layout 22',
				'img' => get_template_directory_uri() . '/images/admin/post-layout-22.png'
			),
		),
	));

	$cmb_post = new_cmb2_box(array(
		'id' => 'post_metabox',
		'title' => esc_html__('Post layout options', 'monopress'),
		'object_types' => array('post',), // Post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
	));

	$cmb_post->add_field(array(
		'name' => esc_html__('Sidebar position', 'monopress'),
		'id' => 'meta_post-sidebar',
		'type' => 'image_select',
		'options' => array(
			'sidebar_1' => array(
				'title' => 'No Sidebar',
				'alt' => 'No Sidebar',
				'img' => get_template_directory_uri() . '/images/admin/layout-no-sidebar.png'
			),
			'sidebar_2' => array(
				'title' => 'Sidebar left',
				'alt' => 'Sidebar left',
				'img' => get_template_directory_uri() . '/images/admin/layout-left-sidebar.png'
			),
			'sidebar_3' => array(
				'title' => 'Sidebar Right',
				'alt' => 'Sidebar Right',
				'img' => get_template_directory_uri() . '/images/admin/layout-right-sidebar.png'
			),
		),
	));

	$cmb_post->add_field(array(
		'name' => esc_html__('Post layout', 'monopress'),
		'id' => 'meta_post-template-default',
		'type' => 'image_select',
		'options' => array(
			'layout_1' => array(
				'title' => 'Post layout 1',
				'alt' => 'Full Width',
				'img' => get_template_directory_uri() . '/images/admin/layout-single-post-1.png'
			),
			'layout_2' => array(
				'title' => 'Post layout 2',
				'alt' => 'Sidebar Left',
				'img' => get_template_directory_uri() . '/images/admin/layout-single-post-2.png'
			),
			'layout_3' => array(
				'title' => 'Post layout 3',
				'alt' => 'Sidebar Right',
				'img' => get_template_directory_uri() . '/images/admin/layout-single-post-3.png'
			),
		),
	));


	$cmb_portfolio = new_cmb2_box(array(
		'id' => 'portfolio-meta',
		'title' => esc_html__('Portfolio layout', 'monopress'),
		'context' => 'normal',
		'object_types' => array( 'page' ), // post type
		'show_on'      => array( 'key' => 'page-template', 'value' => 'page_portfolio.php' ),
//		'taxonomies' => array('portfolio'),
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
	));

	$cmb_portfolio->add_field(array(
		'name' => esc_html__('Post layout', 'monopress'),
		'id' => 'meta_portfolio-template-default',
		'type' => 'image_select',
		'options' => array(
			'layout_1' => array(
				'title' => 'Portfolio layout masonry',
				'alt' => 'Full Width',
				'img' => get_template_directory_uri() . '/images/admin/layout-portfolio-masonry.png'
			),
			'layout_2' => array(
				'title' => 'Portfolio layout grid',
				'alt' => 'Sidebar Left',
				'img' => get_template_directory_uri() . '/images/admin/layout-portfolio-grid.png'),
		),
	));
}
