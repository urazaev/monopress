<?php
/**
 * bcn Theme Meta boxes
 *
 * @package bcn
 */

function bcn_get_meta_box($meta_boxes)
{
	$prefix = 'bcn_meta_';

//	 Page meta boxes

	$meta_boxes[] = array(
		'id' => 'page_template',
		'title' => esc_html__('Page Template Settings', 'bcn'),
		'post_types' => array('page'),
		'context' => 'advanced',
		'priority' => 'default',
		'autosave' => 'false',
		'fields' => array(
			array(
				'id' => $prefix . 'sidebar',
				'type' => 'image_select',
				'name' => esc_html__('Sidebar position', 'bcn'),
				'force_delete' => 'false',
				'max_file_uploads' => '4',
				'options' => array(
					'-1' => get_template_directory_uri() . '/images/admin/layout-default.png',
					'1' => get_template_directory_uri() . '/images/admin/layout-no-sidebar.png',
					'2' => get_template_directory_uri() . '/images/admin/layout-left-sidebar.png',
					'3' => get_template_directory_uri() . '/images/admin/layout-right-sidebar.png',
				),
			),
		),
	);

	return $meta_boxes;
}

add_filter('rwmb_meta_boxes', 'bcn_get_meta_box');
//
//function main_page_add_meta_boxes() {
//	global $post;
//	if ( 'main-page.php' == get_post_meta( $post->ID, '_wp_page_template', true ) ) {
//		add_meta_box( $args );
//	}
//}
//
//add_action( 'add_meta_boxes_page', 'main_page_add_meta_boxes' );


add_action('add_meta_boxes', 'add_product_meta');
function add_product_meta()
{
	global $post;

	if(!empty($post))
	{
		$pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);

		if($pageTemplate == 'main-page.php' )
		{
			add_meta_box(
				'product_meta', // $id
				'Product Information', // $title
//				'display_product_information', // $callback
				'page', // $page
				'normal', // $context
				'high'); // $priority
		}
	}
}
