<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

/* FAQ post type */

$labels = array(
	'name'               => __( 'FAQ', 'pe-terraclassic-plugin' ),
	'singular_name'      => __( 'FAQ', 'pe-terraclassic-plugin' ),
	'add_new'            => __( 'Add New', 'pe-terraclassic-plugin' ),
	'add_new_item'       => __( 'Add New FAQ', 'pe-terraclassic-plugin' ),
	'edit_item'          => __( 'Edit FAQ', 'pe-terraclassic-plugin' ),
	'new_item'           => __( 'New FAQ', 'pe-terraclassic-plugin' ),
	'view_item'          => __( 'View FAQ', 'pe-terraclassic-plugin' ),
	'search_items'       => __( 'Search FAQs', 'pe-terraclassic-plugin' ),
	'not_found'          => __( 'No FAQs found', 'pe-terraclassic-plugin' ),
	'not_found_in_trash' => __( 'No FAQs found in Trash', 'pe-terraclassic-plugin' ),
	'parent_item_colon'  => ''
);

$args = array(
	'labels'              => $labels,
	'public'              => true,
	'exclude_from_search' => false,
	'publicly_queryable'  => true,
	'show_ui'             => true,
	'query_var'           => true,
	'capability_type'     => 'post',
	'hierarchical'        => false,
	'has_archive'         => true,
	'menu_position'       => 5,
	'menu_icon'           => get_template_directory_uri() . '/images/admin/faq_icon.png',
	'show_in_nav_menus'   => false,
	'supports'            => array( 'title', 'editor', 'revisions' ),
	'rewrite'             => array( 'slug' => __( 'faqs', 'pe-terraclassic-plugin' ) )
);

register_post_type( 'faqs', $args );

/* Edit Default Columns */
if ( ! function_exists( 'pe_faq_edit_columns' ) ) {
	function pe_faq_edit_columns( $columns ) {

		$columns = array(
			"cb"    => "<input type=\"checkbox\" />",
			"title" => __( 'Question', 'pe-terraclassic-plugin' ),
			"date"  => __( 'Date', 'pe-terraclassic-plugin' )
		);

		return $columns;
	}
}
add_filter( 'manage_edit-faqs_columns', 'pe_faq_edit_columns' );

/* title text */
if ( ! function_exists( 'pe_faq_enter_title' ) ) {
	function pe_faq_enter_title( $input ) {
		global $post_type;

		if ( is_admin() && 'faqs' == $post_type ) {
			return __( 'Enter Question here', 'pe-terraclassic-plugin' );
		}

		return $input;
	}
}
add_filter( 'enter_title_here', 'pe_faq_enter_title' );

?>
