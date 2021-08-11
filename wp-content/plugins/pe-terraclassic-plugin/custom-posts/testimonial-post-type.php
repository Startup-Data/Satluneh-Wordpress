<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

/* Testimonial post type */

$labels = array(
	'name'               => __( 'Testimonials', 'pe-terraclassic-plugin' ),
	'singular_name'      => __( 'Testimonial', 'pe-terraclassic-plugin' ),
	'add_new'            => __( 'Add New', 'pe-terraclassic-plugin' ),
	'add_new_item'       => __( 'Add New Testimonial', 'pe-terraclassic-plugin' ),
	'edit_item'          => __( 'Edit Testimonial', 'pe-terraclassic-plugin' ),
	'new_item'           => __( 'New Testimonial', 'pe-terraclassic-plugin' ),
	'view_item'          => __( 'View Testimonial', 'pe-terraclassic-plugin' ),
	'search_items'       => __( 'Search Testimonial', 'pe-terraclassic-plugin' ),
	'not_found'          => __( 'No Testimonial found', 'pe-terraclassic-plugin' ),
	'not_found_in_trash' => __( 'No Testimonial found in Trash', 'pe-terraclassic-plugin' ),
	'parent_item_colon'  => ''
);

$args = array(
	'labels'              => $labels,
	'public'              => true,
	'exclude_from_search' => true,
	'publicly_queryable'  => true,
	'show_ui'             => true,
	'query_var'           => true,
	'capability_type'     => 'post',
	'hierarchical'        => false,
	'menu_position'       => 5,
	'menu_icon'           => get_template_directory_uri() . '/images/admin/testimonials.png',
	'show_in_nav_menus'   => true,
	'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions' ),
	'rewrite'             => array( 'slug' => __( 'testimonial', 'pe-terraclassic-plugin' ) )
);

register_post_type( 'testimonial', $args );

/* image box */
if ( ! function_exists( 'pe_testimonial_image_box' ) ) {
	function pe_testimonial_image_box() {
		remove_meta_box( 'postimagediv', 'testimonial', 'side' );
		add_meta_box( 'postimagediv', __( 'Avatar image', 'pe-terraclassic-plugin' ), 'post_thumbnail_meta_box', 'testimonial', 'side', 'low' );
	}
}
add_action( 'do_meta_boxes', 'pe_testimonial_image_box' );

/* title text */
if ( ! function_exists( 'pe_testimonial_enter_title' ) ) {
	function pe_testimonial_enter_title( $input ) {
		global $post_type;

		if ( is_admin() && 'testimonial' == $post_type ) {
			return __( 'Enter Author Name here', 'pe-terraclassic-plugin' );
		}

		return $input;
	}
}
add_filter( 'enter_title_here', 'pe_testimonial_enter_title' );

?>
