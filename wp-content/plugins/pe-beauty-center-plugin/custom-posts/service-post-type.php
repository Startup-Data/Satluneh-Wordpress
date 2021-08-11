<?php
/* Services post type */
if (!function_exists('create_service_post_type')) {
	function create_service_post_type() {
		$labels = array('name' => __('Services', 'PixelEmu'), 'singular_name' => __('Service', 'PixelEmu'), 'add_new' => __('Add New', 'PixelEmu'), 'add_new_item' => __('Add New Service', 'PixelEmu'), 'edit_item' => __('Edit Service', 'PixelEmu'), 'new_item' => __('New Service', 'PixelEmu'), 'view_item' => __('View Service', 'PixelEmu'), 'search_items' => __('Search Service', 'PixelEmu'), 'not_found' => __('No Service found', 'PixelEmu'), 'not_found_in_trash' => __('No Service found in Trash', 'PixelEmu'), 'parent_item_colon' => '');

		$args = array('labels' => $labels, 'public' => true, 'exclude_from_search' => true, 'publicly_queryable' => true, 'show_ui' => true, 'query_var' => true, 'capability_type' => 'post', 'hierarchical' => false, 'menu_position' => 5, 'menu_icon' => get_template_directory_uri() . '/images/admin/services.png', 'supports' => array('title', 'editor', 'thumbnail', 'revisions'), 'rewrite' => array('slug' => __('service', 'PixelEmu')));

		register_post_type('service', $args);
	}

}
add_action('init', 'create_service_post_type');

/* Create Services Taxonomies */
if (!function_exists('pe_taxonomies')) {
	function pe_taxonomies() {

		$services_category = array('name' => __('Service Categories', 'PixelEmu'), 'singular_name' => __('Service Category', 'PixelEmu'), 'search_items' => __('Search Service Categories', 'PixelEmu'), 'popular_items' => __('Popular Service Categories', 'PixelEmu'), 'all_items' => __('All Service Categories', 'PixelEmu'), 'parent_item' => __('Parent Service Category', 'PixelEmu'), 'parent_item_colon' => __('Parent Service Category:', 'PixelEmu'), 'edit_item' => __('Edit Service Category', 'PixelEmu'), 'update_item' => __('Update Service Category', 'PixelEmu'), 'add_new_item' => __('Add New Service Category', 'PixelEmu'), 'new_item_name' => __('New Service Category Name', 'PixelEmu'), 'separate_items_with_commas' => __('Separate Service Categories with commas', 'PixelEmu'), 'add_or_remove_items' => __('Add or remove Service Categories', 'PixelEmu'), 'choose_from_most_used' => __('Choose from the most used Service Categories', 'PixelEmu'), 'menu_name' => __('Service Categories', 'PixelEmu'));

		register_taxonomy('service-category', array('service'), array('hierarchical' => true, 'labels' => $services_category, 'show_ui' => true, 'show_in_nav_menus' => false, 'query_var' => true, 'rewrite' => array('slug' => __('service-category', 'PixelEmu'))));
	}

}
add_action('init', 'pe_taxonomies', 0);

/* Edit Default Columns */
if (!function_exists('service_edit_columns')) {
	function service_edit_columns($columns) {

		$columns = array("cb" => "<input type=\"checkbox\" />", "title" => __('Service', 'PixelEmu'), "category" => __('Service Category', 'PixelEmu'), "date" => __('Date', 'PixelEmu'));

		return $columns;
	}

}
add_filter("manage_edit-service_columns", "service_edit_columns");

/* Add Custom Column */
if (!function_exists('service_custom_columns')) {
	function service_custom_columns($column) {
		global $post;
		switch ($column) {
			case 'category' :
				echo get_the_term_list($post -> ID, 'service-category', '', ', ', '');
				break;
		}
	}

}
add_action("manage_service_posts_custom_column", "service_custom_columns");
?>