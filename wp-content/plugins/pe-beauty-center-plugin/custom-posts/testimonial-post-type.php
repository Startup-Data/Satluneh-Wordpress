<?php
/* Team member post type */
if( !function_exists( 'create_testimonial_post_type' ) ){
    function create_testimonial_post_type(){
        $labels = array(
            'name' 										=> __( 'Testimonials','PixelEmu'),
            'singular_name' 					=> __( 'Testimonial','PixelEmu' ),
            'add_new' 								=> __('Add New','PixelEmu'),
            'add_new_item' 						=> __('Add New Testimonial','PixelEmu'),
            'edit_item' 							=> __('Edit Testimonial','PixelEmu'),
            'new_item' 								=> __('New Testimonial','PixelEmu'),
            'view_item' 							=> __('View Testimonial','PixelEmu'),
            'search_items'						=> __('Search Testimonial','PixelEmu'),
            'not_found' 							=>  __('No Testimonial found','PixelEmu'),
            'not_found_in_trash' 			=> __('No Testimonial found in Trash','PixelEmu'),
            'parent_item_colon' 			=> ''
        );

        $args = array(
            'labels' 									=> $labels,
            'public' 									=> true,
            'exclude_from_search' 		=> true,
            'publicly_queryable' 			=> true,
            'show_ui' 								=> true,
            'query_var' 							=> true,
            'capability_type' 				=> 'post',
            'hierarchical' 						=> false,
            'menu_position' 					=> 5,
            'menu_icon'								=> get_template_directory_uri().'/images/admin/testimonials.png',
            'supports' 								=> array('title','editor','thumbnail','revisions'),
            'rewrite' 								=> array( 'slug' => __('testimonial', 'PixelEmu') )
        );

        register_post_type('testimonial',$args);
    }
}
add_action( 'init', 'create_testimonial_post_type' );
?>