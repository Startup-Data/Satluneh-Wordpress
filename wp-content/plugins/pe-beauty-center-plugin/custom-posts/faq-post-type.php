<?php
/* Services post type */
if( !function_exists( 'create_faq_post_type' ) ){
    function create_faq_post_type(){
        $labels = array(
            'name' 							=> __('FAQ','PixelEmu'),
            'singular_name' 				=> __('FAQ','PixelEmu' ),
            'add_new' 						=> __('Add New','PixelEmu'),
            'add_new_item' 					=> __('Add New FAQ','PixelEmu'),
            'edit_item' 					=> __('Edit FAQ','PixelEmu'),
            'new_item' 						=> __('New FAQ','PixelEmu'),
            'view_item' 					=> __('View FAQ','PixelEmu'),
            'search_items' 					=> __('Search FAQs','PixelEmu'),
            'not_found' 					=> __('No FAQs found','PixelEmu'),
            'not_found_in_trash' 			=> __('No FAQs found in Trash','PixelEmu'),
            'parent_item_colon' 			=> ''
        );

        $args = array(
            'labels' 					=> $labels,
            'public' 					=> true,
            'exclude_from_search' 		=> true,
            'publicly_queryable' 		=> true,
            'show_ui'	 				=> true,
            'query_var' 				=> true,
            'capability_type' 			=> 'post',
            'hierarchical' 				=> false,
            'menu_position' 			=> 5,
            'menu_icon'					=> get_template_directory_uri().'/images/admin/faq_icon.png',
            'supports' 					=> array('title','editor','revisions'),
            'rewrite' 					=> array('slug' => __('faqs', 'PixelEmu') )
        );

        register_post_type('faqs',$args);
    }
}
add_action( 'init', 'create_faq_post_type' );

/* Edit Default Columns */
if( !function_exists( 'faq_edit_columns' ) ){
    function faq_edit_columns($columns)
    {

        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => __( 'Question','PixelEmu' ),
            "date" => __( 'Date','PixelEmu' )
        );

        return $columns;
    }
}
add_filter("manage_edit-faqs_columns", "faq_edit_columns");

?>