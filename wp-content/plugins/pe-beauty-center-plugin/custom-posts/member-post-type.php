<?php
/* Team member post type */
if( !function_exists( 'create_member_post_type' ) ){
    function create_member_post_type(){
        $labels = array(
            'name' 						=> __('Members','PixelEmu'),
            'singular_name' 			=> __('Member','PixelEmu' ),
            'add_new' 					=> __('Add New','PixelEmu'),
            'add_new_item' 				=> __('Add New Member','PixelEmu'),
            'edit_item' 				=> __('Edit Member','PixelEmu'),
            'new_item' 					=> __('New Member','PixelEmu'),
            'view_item' 				=> __('View Member','PixelEmu'),
            'search_items' 				=> __('Search Member','PixelEmu'),
            'not_found' 				=> __('No Member found','PixelEmu'),
            'not_found_in_trash' 		=> __('No Member found in Trash','PixelEmu'),
            'parent_item_colon' 		=> ''
        );

        $args = array(
            'labels' 				=> $labels,
            'public' 				=> true,
            'exclude_from_search' 	=> true,
            'publicly_queryable' 	=> true,
            'show_ui' 				=> true,
            'query_var' 			=> true,
            'capability_type' 		=> 'post',
            'hierarchical' 			=> false,
            'menu_position' 		=> 5,
            'menu_icon'				=> get_template_directory_uri().'/images/admin/members.png',
            'supports' 				=> array('title','editor','thumbnail','revisions'),
            'rewrite' 				=> array( 'slug' => __('member', 'PixelEmu') )
        );

        register_post_type('member',$args);
    }
}
add_action( 'init', 'create_member_post_type' );

/* Edit Default Columns */
if( !function_exists( 'member_edit_columns' ) ){
    function member_edit_columns($columns)
    {

        $columns = array(
            "cb" 			=> "<input type=\"checkbox\" />",
            "id" 			=> __('ID','PixelEmu'),
            "title" 		=> __('Member','PixelEmu'),
            "position" 		=> __('Member Position','PixelEmu'),
            "date" 			=> __('Date','PixelEmu')
        );

        return $columns;
    }
}
add_filter("manage_edit-member_columns", "member_edit_columns");

/* Add Custom Column */
if( !function_exists( 'member_custom_column_position' ) ){
	function member_custom_column_position($column){  
	    global $post;  
	    switch ($column) {  
	        case 'position':
				$position = get_post_meta($post->ID, 'member_position',true);
				if(!empty($position)) {
					echo $position;
				}
	            break;
	    }  
	}
}
add_action("manage_member_posts_custom_column",  "member_custom_column_position");

if( !function_exists( 'member_custom_columns_id' ) ){
	function member_custom_columns_id($columnName, $columnID){
	    if($columnName == 'id'){
	       echo $columnID;
	    }
	}
}
add_filter( 'manage_member_posts_custom_column', 'member_custom_columns_id', 10, 2 );
?>