<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

if (!defined('ABSPATH')) {
	die();
}

/*-----------------------------------------------------------------------------------*/
/*	Generator name / Feed links / HTML5 Support
/*-----------------------------------------------------------------------------------*/

if (!function_exists('pe_theme_setup')) {
	/**
	 * Add theme WordPress support, register menus
	 */
	function pe_theme_setup()
	{
		//head title
		add_theme_support('title-tag');

		//feed links
		add_theme_support('automatic-feed-links');

		//html5
		add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));

		//post thumbnails
		add_theme_support('post-thumbnails');

		//defult thumbnail size
		set_post_thumbnail_size(get_option('medium_size_w'), get_option('medium_size_h')); // default Post Thumbnail dimensions (medium)

		//languages
		load_theme_textdomain('pe-terraclassic', get_template_directory() . '/languages');

		//content width
		if (!isset($content_width)) {
			if (PEsettings::get('theme-width,units') == 'px') {
				$content_width = PEsettings::get('theme-width,width');
			} else {
				$content_width = PEsettings::$default['theme-width']['width'];
			}
		}
		//register menus
		register_nav_menus(
			array(
				'main-menu' => esc_html__('Main Menu', 'pe-terraclassic'),
				'skip-menu' => __('Skip Content Menu', 'pe-terraclassic'),
			)
		);
	}
}
add_action('after_setup_theme', 'pe_theme_setup');

/*-----------------------------------------------------------------------------------*/
/*	Check plugin
/*-----------------------------------------------------------------------------------*/

if (!function_exists('pe_framework_check')) {
	function pe_framework_check()
	{
		if (!is_plugin_active('pe-terraclassic-plugin/pe-terraclassic-plugin.php') && !isset($_GET['page'])) {
			$my_theme   = wp_get_theme(get_template());
			$theme_name = $my_theme->get('Name');
			echo '<div class="notice notice-error is-dismissible"><p><strong>';
			echo $theme_name . ' ' . esc_html__('plugin must be installed and activated !', 'pe-terraclassic');
			echo '</strong></p><p>';
			echo sprintf("<a href='%s' class='button-primary'>%s</a>", admin_url('plugins.php'), esc_html__('Click here to go to the plugins page', 'pe-terraclassic'));
			echo '</p></div>';
		}
	}
}
add_action('admin_notices', 'pe_framework_check');

/*-----------------------------------------------------------------------------------*/
/*	Theme menu
/*-----------------------------------------------------------------------------------*/

if (!class_exists('PE_Main_Menu')) {
	class PE_Main_Menu extends Walker_Nav_Menu
	{

		/**
		 * Modify menu start level
		 */
		function start_lvl(&$output, $depth = 0, $args = array())
		{
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<div class=\"nav-dropdown\"><ul class=\"nav-dropdown-in main-menu\">\n";
		}

		/**
		 * Modify menu element
		 */
		function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
		{
			$indent = ($depth) ? str_repeat("\t", $depth) : '';

			$class_names = '';

			$classes   = empty($item->classes) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
			$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

			$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
			$id = $id ? ' id="' . esc_attr($id) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names . '>';

			$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
			$attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
			$attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
			$attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

			if (array_search('menu-item-has-children', $classes)) {
				$attributes .= ' aria-haspopup="true"';
			}

			$item_output = $args->before;
			$item_output .= '<a' . $attributes . '>';
			$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;

			$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
		}

		/**
		 * Modify menu end level
		 */
		function end_lvl(&$output, $depth = 0, $args = array())
		{
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul></div>\n";
		}
	}
}

/*-----------------------------------------------------------------------------------*/
//	Widget Size and custom class fields
/*-----------------------------------------------------------------------------------*/

if (!class_exists('PE_Widget_Fields')) {
	class PE_Widget_Fields
	{

		/**
		 * Display widget size field
		 *
		 * @param  object $widget
		 */
		public static function displayField($widget, $return, $instance)
		{

			if (!isset($instance['pe_classes'])) {
				$instance['pe_classes'] = null;
			}

			if (!isset($instance['pe_widget_size_lg'])) {
				$instance['pe_widget_size_lg'] = null;
			}
			if (!isset($instance['pe_widget_size_md'])) {
				$instance['pe_widget_size_md'] = null;
			}
			if (!isset($instance['pe_widget_size_sm'])) {
				$instance['pe_widget_size_sm'] = null;
			}
			if (!isset($instance['pe_widget_size_xs'])) {
				$instance['pe_widget_size_xs'] = null;
			}

			$row = "<div>";
			$row .= "<p><label for='widget-{$widget->id_base}-{$widget->number}-pe_classes'>" . apply_filters('widget_css_classes', esc_html__('Custom Widget Classes', 'pe-terraclassic')) . ":</label></p>";
			$row .= "<p><input type='text' name='widget-{$widget->id_base}[{$widget->number}][pe_classes]' id='widget-{$widget->id_base}-{$widget->number}-pe_classes' value='{$instance['pe_classes']}' class='widefat' /></p>";
			$row .= "</div>";

			$row .= "<div>";
			$row .= "<p><label for='widget-{$widget->id_base}-{$widget->number}-pe_widget_size'>" . apply_filters('widget_css_classes', esc_html__('Widget Size', 'pe-terraclassic')) . ":</label> <small>(<a href='https://www.pixelemu.com/blog/tutorials/how-to-use-bootstrap-grid-system-with-wordpress-theme' target='_blank' title='" . esc_html__('More details about grid', 'pe-terraclassic') . "'>?</a>)</small></p>";
			//col-lg
			$row .= "<p style='display: inline-block; vertical-align: top; margin-top: 0;'><small style='display: block;'>" . esc_html__('Large Desktop ( &ge; 1200px )', 'pe-terraclassic') . "</small>";
			$row .= "<select style='min-width: 155px;' name='widget-{$widget->id_base}[{$widget->number}][pe_widget_size_lg]' id='widget-{$widget->id_base}-{$widget->number}-pe_widget_size_lg'>";
			$row .= "<option value=''> " . esc_html__('auto', 'pe-terraclassic') . " </option>";
			for ($i = 12; $i > 0; $i--) {
				$percentage = floor(100 / (12 / $i));
				$row        .= "<option value='col-lg-" . $i . "' " . selected($instance['pe_widget_size_lg'], 'col-lg-' . $i, false) . ">" . $percentage . "% - col-lg-" . $i . "</option>";
			}
			$row .= "</select></p>";
			//col-md
			$row .= "<p style='display: inline-block; vertical-align: top; margin-top: 0;'><small style='display: block;'>" . esc_html__('Desktop ( &ge; 992px )', 'pe-terraclassic') . "</small>";
			$row .= "<select style='min-width: 155px;' name='widget-{$widget->id_base}[{$widget->number}][pe_widget_size_md]' id='widget-{$widget->id_base}-{$widget->number}-pe_widget_size_md'>";
			$row .= "<option value='' " . selected($instance['pe_widget_size_md'], '', false) . "> " . esc_html__('auto', 'pe-terraclassic') . " </option>";
			for ($i = 12; $i > 0; $i--) {
				$percentage = floor(100 / (12 / $i));
				$row        .= "<option value='col-md-" . $i . "' " . selected($instance['pe_widget_size_md'], 'col-md-' . $i, false) . ">" . $percentage . "% - col-md-" . $i . "</option>";
			}
			$row .= "</select></p>";
			//col-sm
			$row .= "<p style='display: inline-block; vertical-align: top; margin-top: 0;'><small style='display: block;'>" . esc_html__('Tablet ( &ge; 768px )', 'pe-terraclassic') . "</small>";
			$row .= "<select style='min-width: 155px;' name='widget-{$widget->id_base}[{$widget->number}][pe_widget_size_sm]' id='widget-{$widget->id_base}-{$widget->number}-pe_widget_size_sm'>";
			$row .= "<option value=''> " . esc_html__('auto', 'pe-terraclassic') . " </option>";
			for ($i = 12; $i > 0; $i--) {
				$percentage = floor(100 / (12 / $i));
				$row        .= "<option value='col-sm-" . $i . "' " . selected($instance['pe_widget_size_sm'], 'col-sm-' . $i, false) . ">" . $percentage . "% - col-sm-" . $i . "</option>";
			}
			$row .= "</select></p>";
			//col-xs
			$row .= "<p style='display: inline-block; vertical-align: top; margin-top: 0;'><small style='display: block;'>" . esc_html__('Phone ( &lt; 768px )', 'pe-terraclassic') . "</small>";
			$row .= "<select style='min-width: 155px;' name='widget-{$widget->id_base}[{$widget->number}][pe_widget_size_xs]' id='widget-{$widget->id_base}-{$widget->number}-pe_widget_size_xs'>";
			$row .= "<option value=''> " . esc_html__('auto', 'pe-terraclassic') . " </option>";
			for ($i = 12; $i > 0; $i--) {
				$percentage = floor(100 / (12 / $i));
				$row        .= "<option value='col-xs-" . $i . "' " . selected($instance['pe_widget_size_xs'], 'col-xs-' . $i, false) . ">" . $percentage . "% - col-xs-" . $i . "</option>";
			}
			$row .= "</select></p>";
			$row .= "</div>";

			echo $row;

			return $instance;
		}

		/**
		 * Widget update settings
		 */
		public static function widgetUpdate($instance, $new_instance)
		{
			$instance['pe_classes']        = $new_instance['pe_classes'];
			$instance['pe_widget_size_xs'] = $new_instance['pe_widget_size_xs'];
			$instance['pe_widget_size_sm'] = $new_instance['pe_widget_size_sm'];
			$instance['pe_widget_size_md'] = $new_instance['pe_widget_size_md'];
			$instance['pe_widget_size_lg'] = $new_instance['pe_widget_size_lg'];

			return $instance;
		}

		/**
		 * Update widgets params
		 *
		 * @param  array $params
		 *
		 * @return array
		 */
		public static function sidebarParams($params)
		{
			global $wp_registered_widgets;
			$widget_id    = $params[0]['widget_id'];
			$widget_obj   = $wp_registered_widgets[$widget_id];
			$widget_opt   = get_option($widget_obj['callback'][0]->option_name);
			$widget_num   = $widget_obj['params'][0]['number'];
			$widget_class = array();

			if (!empty($widget_opt[$widget_num]['pe_widget_size_xs'])) {
				$widget_class[] = $widget_opt[$widget_num]['pe_widget_size_xs'];
			}
			if (!empty($widget_opt[$widget_num]['pe_widget_size_sm'])) {
				$widget_class[] = $widget_opt[$widget_num]['pe_widget_size_sm'];
			}
			if (!empty($widget_opt[$widget_num]['pe_widget_size_md'])) {
				$widget_class[] = $widget_opt[$widget_num]['pe_widget_size_md'];
			}
			if (!empty($widget_opt[$widget_num]['pe_widget_size_lg'])) {
				$widget_class[] = $widget_opt[$widget_num]['pe_widget_size_lg'];
			}

			if (!empty($widget_opt[$widget_num]['pe_classes'])) {
				$widget_custom_class = $widget_opt[$widget_num]['pe_classes'];
				$widget_custom_class = preg_replace('/\s\s+/', ' ', $widget_custom_class);
				$widget_custom_class = explode(' ', $widget_custom_class);
				$widget_class        = array_merge($widget_class, $widget_custom_class);
			}

			$widget_class = array_map('sanitize_html_class', $widget_class);
			$widget_class = implode(' ', $widget_class); //array to string

			$params[0]['before_widget'] = preg_replace('/class="/', "class=\"{$widget_class} ", $params[0]['before_widget'], 1);

			return $params;
		}
	}
}

if (is_admin()) {
	add_filter('in_widget_form', array('PE_Widget_Fields', 'displayField'), 10, 3);
	add_filter('widget_update_callback', array('PE_Widget_Fields', 'widgetUpdate'), 10, 2);
} else {
	add_filter('dynamic_sidebar_params', array('PE_Widget_Fields', 'sidebarParams'));
}

/*-----------------------------------------------------------------------------------*/
/*	Modify Widget Title
/*-----------------------------------------------------------------------------------*/

if (!function_exists('pe_widget_title')) {
	/**
	 * Add span to each title word
	 *
	 * @param  string $title Widget title
	 *
	 * @return string Widget title with spans
	 */
	function pe_widget_title($title)
	{
		if (!empty($title)) {
			$title_array = preg_split('#\s#', $title);
			$title       = '';
			foreach ($title_array as $title_word) {
				$title .= '<span>' . $title_word . '</span> ';
			}

			return $title;
		}
	}
}
add_filter('widget_title', 'pe_widget_title');

/*-----------------------------------------------------------------------------------*/
/*	Modify wp readmore
/*-----------------------------------------------------------------------------------*/

if (!function_exists('pe_read_more_link')) {
	/**
	 * Modify default readmore link
	 * @return string with readmore paragraphe
	 */
	function pe_read_more_link()
	{
		return '<p class="pe-article-read-more"><a class="readmore readmore-icon" href="' . esc_url(get_permalink()) . '"><span class="sr-only"> ' . esc_html(get_the_title()) . '</span>' . esc_html__('Read more ...', 'pe-terraclassic') . '</a></p>';
	}
}
add_filter('the_content_more_link', 'pe_read_more_link');

/*-----------------------------------------------------------------------------------*/
//	Theme Pagination Method
/*-----------------------------------------------------------------------------------*/

if (!function_exists('pe_pagination')) {
	/**
	 * Modify default pagination
	 *
	 * @param integer $pages Number of pages in listing
	 */
	function pe_pagination($pages = false)
	{
		global $paged;

		if (empty($paged)) {
			$paged = 1;
		}

		$prev      = $paged - 1;
		$next      = $paged + 1;
		$range     = 1; // only change it to show more links
		$showitems = ($range * 2) + 1;

		if ($pages === false) {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if (!$pages) {
				$pages = 1;
			}
		}

		if ($pages != 1) {
			echo '<nav class="pe-pagination-block"><ul class="pe-pagination">';
			echo ($paged > 2 && $paged > $range + 1 && $showitems < $pages) ? '<li class="start"><a href="' . esc_url(get_pagenum_link(1)) . '" title="' . esc_html__('Start', 'pe-terraclassic') . '" aria-label="' . esc_html__('Start', 'pe-terraclassic') . '">' . esc_html__('Start', 'pe-terraclassic') . '</a></li>' : '';
			echo ($paged > 1 && $showitems < $pages) ? '<li class="prev"><a href="' . esc_url(get_pagenum_link($prev)) . '" title="' . esc_html__('Prev', 'pe-terraclassic') . '" aria-label="' . esc_html__('Prev', 'pe-terraclassic') . '">' . esc_html__('Prev', 'pe-terraclassic') . '</a></li>' : '';
			for ($i = 1; $i <= $pages; $i++) {
				if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
					echo ($paged == $i) ? '<li class="active"><span>' . $i . '</span></li> ' : '<li><a href="' . esc_url(get_pagenum_link($i)) . '">' . $i . '</a></li>';
				}
			}
			echo ($paged < $pages && $showitems < $pages) ? '<li class="next"><a href=' . esc_url(get_pagenum_link($next)) . ' title="' . esc_html__('Next', 'pe-terraclassic') . '" aria-label="' . esc_html__('Next', 'pe-terraclassic') . '">' . esc_html__('Next', 'pe-terraclassic') . '</a></li>' : '';
			echo ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages) ? '<li class="end"><a href="' . esc_url(get_pagenum_link($pages)) . '" title="' . esc_html__('End', 'pe-terraclassic') . '" aria-label="' . esc_html__('End', 'pe-terraclassic') . '">' . esc_html__('End', 'pe-terraclassic') . '</a></li>' : '';
			echo '</ul></nav>';
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Breadcrumbs
/*-----------------------------------------------------------------------------------*/

if (!function_exists('pe_breadcrumbs')) {
	/**
	 * Breadcrumbs
	 *
	 * @param array $args
	 */
	function pe_breadcrumbs($args = array())
	{
		if (is_front_page()) {
			return;
		}
		global $post;
		$defaults = array(
			'separator_icon'      => '/',
			'breadcrumbs_id'      => 'pe-breadcrumbs-list',
			'breadcrumbs_classes' => 'pe-breadcrumbs',
			'home_title'          => esc_html__('Home', 'pe-terraclassic'),
			'home_icon'           => 'fa fa-home',
		);
		$args     = apply_filters('pe_breadcrumbs_args', wp_parse_args($args, $defaults));

		$separator_icon = ($args['separator_icon']) ? esc_attr($args['separator_icon']) : '';
		$separator      = '<li class="separator">' . $separator_icon . '</li>';

		// Open the breadcrumbs
		$html = '<ul id="' . esc_attr($args['breadcrumbs_id']) . '" class="' . sanitize_html_class($args['breadcrumbs_classes']) . '">';
		// Add Homepage link & separator (always present)
		$html .= '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '"><span class="' . esc_attr($args['home_icon']) . '" aria-hidden="true"></span><span class="sr-only">' . esc_attr($args['home_title']) . '</span></a></li>';
		$html .= $separator;
		// Post
		if (is_singular('post')) {
			$category        = get_the_category();
			$category_values = array_values($category);
			$last_category   = end($category_values);
			$cat_parents     = rtrim(get_category_parents($last_category->term_id, true, ','), ',');
			$cat_parents     = explode(',', $cat_parents);
			foreach ($cat_parents as $parent) {
				$html .= '<li class="item-cat">' . wp_kses($parent, wp_kses_allowed_html('a')) . '</li>';
				$html .= $separator;
			}
			$html .= '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '">' . get_the_title() . '</span></li>';
		} elseif (is_singular('page')) {
			if ($post->post_parent) {
				$parents = get_post_ancestors($post->ID);
				$parents = array_reverse($parents);
				foreach ($parents as $parent) {
					$html .= '<li class="item-parent item-parent-' . esc_attr($parent) . '"><a class="bread-parent bread-parent-' . esc_attr($parent) . '" href="' . esc_url(get_permalink($parent)) . '">' . get_the_title($parent) . '</a></li>';
					$html .= $separator;
				}
			}
			$html .= '<li class="item-current item-' . $post->ID . '"><span> ' . esc_attr(get_the_title()) . '</span></li>';
		} elseif (is_singular('attachment')) {
			$parent_id        = $post->post_parent;
			$parent_title     = get_the_title($parent_id);
			$parent_permalink = get_permalink($parent_id);
			$html             .= '<li class="item-parent"><a class="bread-parent" href="' . esc_url($parent_permalink) . '">' . esc_attr($parent_title) . '</a></li>';
			$html             .= $separator;
			$html             .= '<li class="item-current item-' . $post->ID . '"><span> ' . esc_attr(get_the_title()) . '</span></li>';
		} elseif (is_singular()) {
			$post_type         = get_post_type();
			$post_type_object  = get_post_type_object($post_type);
			$post_type_archive = get_post_type_archive_link($post_type);
			$html              .= '<li class="item-cat item-custom-post-type-' . esc_attr($post_type) . '"><a class="bread-cat bread-custom-post-type-' . esc_attr($post_type) . '" href="' . esc_url($post_type_archive) . '">' . esc_attr($post_type_object->labels->name) . '</a></li>';
			$html              .= $separator;
			$html              .= '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '">' . $post->post_title . '</span></li>';
		} elseif (is_category()) {
			$parent = get_queried_object()->category_parent;
			if ($parent !== 0) {
				$parent_category = get_category($parent);
				$category_link   = get_category_link($parent);
				$html            .= '<li class="item-parent item-parent-' . esc_attr($parent_category->slug) . '"><a class="bread-parent bread-parent-' . esc_attr($parent_category->slug) . '" href="' . esc_url($category_link) . '">' . esc_attr($parent_category->name) . '</a></li>';
				$html            .= $separator;
			}
			$html .= '<li class="item-current item-cat"><span class="bread-current bread-cat">' . single_cat_title('', false) . '</span></li>';
		} elseif (is_tag()) {
			$html .= '<li class="item-current item-tag"><span class="bread-current bread-tag">' . single_tag_title('', false) . '</span></li>';
		} elseif (is_author()) {
			$html .= '<li class="item-current item-author"><span class="bread-current bread-author">' . get_queried_object()->display_name . '</span></li>';
		} elseif (is_day()) {
			$html .= '<li class="item-current item-day"><span class="bread-current bread-day">' . get_the_date() . '</span></li>';
		} elseif (is_month()) {
			$html .= '<li class="item-current item-month"><span class="bread-current bread-month">' . get_the_date('F Y') . '</span></li>';
		} elseif (is_year()) {
			$html .= '<li class="item-current item-year"><span class="bread-current bread-year">' . get_the_date('Y') . '</span></li>';
		} elseif (is_archive()) {


			if (!empty(get_queried_object()->label)) {
				$custom_tax_name = get_queried_object()->label;
			} else if (!empty(get_queried_object()->name)) {
				$custom_tax_name = get_queried_object()->name;
			} else {
				$custom_tax_name = '';
			}

			$html            .= '<li class="item-current item-archive"><span class="bread-current bread-archive">' . esc_attr($custom_tax_name) . '</span></li>';
		} elseif (is_search()) {
			$html .= '<li class="item-current item-search"><span class="bread-current bread-search">' . esc_html__('Search results for: ', 'pe-terraclassic') . get_search_query() . '</span></li>';
		} elseif (is_404()) {
			$html .= '<li>' . esc_html__('Error 404', 'pe-terraclassic') . '</li>';
		} elseif (is_home()) {
			$html .= '<li>' . get_the_title(get_option('page_for_posts')) . '</li>';
		}
		$html .= '</ul>';
		$html = apply_filters('pe_breadcrumbs_filter', $html);
		echo wp_kses_post($html);
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Custom Excerpt Method
/*-----------------------------------------------------------------------------------*/

if (!function_exists('pe_excerpt')) {
	/**
	 * Show content depends on quicktag, excerpt limit and readmore
	 *
	 * @param          integer   / string $len Excerpt length (words)
	 * @param  string  $trim     (...) cut sign
	 * @param  boolean $readmore Show readmore
	 */
	function pe_excerpt($len = 55, $trim = '&hellip;', $readmore = false, $ignore = false)
	{
		global $post;

		if (strpos($post->post_content, '<!--more-->') && $len > 0 && $ignore == false) { //if more quicktag in post
			if ($readmore === true) {
				echo '<!-- with readmore -->';
				the_content(); //with readmore
			} else {
				echo '<!-- no readmore -->';
				the_content(''); //no readmore
			}
		} elseif ($len == 'full') {
			echo '<!-- full content -->';
			the_content('');
		} elseif ($len == 0) {
			echo '<!-- excerpt 0 -->';
		} else { //prepare excerpt depends on limit
			echo '<!-- excerpt ' . $len . ' -->';
			$limit     = $len + 1;
			$excerpt   = explode(' ', strip_tags(get_the_content()), $limit);
			$num_words = count($excerpt);
			$trim      = ' ' . $trim;

			if ($num_words >= $len) {
				$last_item = array_pop($excerpt);
			} else {
				$trim = '';
			}

			$excerpt = implode(' ', $excerpt);

			$excerpt = rtrim($excerpt, ',');
			$excerpt = rtrim($excerpt, '.');

			$excerpt .= $trim;

			if ($readmore === true) { //with readmore
				$excerpt .= pe_read_more_link();
			}
			$excerpt = strip_shortcodes($excerpt);
			echo apply_filters('the_content', $excerpt);
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Custom Password Form
/*-----------------------------------------------------------------------------------*/
if (!function_exists('pe_custom_password_form')) {
	add_filter('the_password_form', 'pe_custom_password_form');
	function pe_custom_password_form()
	{
		global $post;
		if (is_archive() || is_home()) {
			$output = esc_html__('Post is password protected. Please go to single post view to enter the password.', 'pe-terraclassic');
		} else {
			$label = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);
			$output = '<form class="protected-post-form" action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post">
		    ' . esc_html__('This content is password protected. To view it please enter your password below: ', 'pe-terraclassic') . '
		    <label class="pass-label" for="' . $label . '">' . esc_html__('Password: ', 'pe-terraclassic') . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" /> <input type="submit" name="Submit" class="button" value="' . esc_attr__('Submit ', 'pe-terraclassic') . '" />
		    </form>';
		}
		return $output;
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Comingsoon Tempalte
/*-----------------------------------------------------------------------------------*/

if (!function_exists('pe_coming_soon_page')) {
	/**
	 * Load coming soon layout instead other theme blocks
	 */
	function pe_coming_soon_page($template)
	{

		$future_time  = strtotime(PEsettings::get('coming-soon-until-date'));
		$current_time = current_time('timestamp');

		if (!is_user_logged_in() && PEsettings::get('coming-soon') && $future_time && $current_time < $future_time) {

			//add body class
			add_filter('body_class', function ($classes) {
				return array_merge($classes, array('coming-soon'));
			});

			$cs_template = locate_template(array('tpl/comingsoon.php'));
			if ($cs_template) {
				return $cs_template;
			}
		}

		return $template;
	}
}
add_filter('template_include', 'pe_coming_soon_page', 99);

/*-----------------------------------------------------------------------------------*/
/*	Custom Comment
/*-----------------------------------------------------------------------------------*/

if (!function_exists('pe_enqueue_comments_reply')) {
	/**
	 * Enqueue comments script
	 */
	function pe_enqueue_comments_reply()
	{
		if (get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}
	}
}
add_action('comment_form_before', 'pe_enqueue_comments_reply');

/**
 * Modify comments output
 */
function pe_comment($comment, $args, $depth)
{
	global $comment;
	extract($args, EXTR_SKIP);

	if ('div' == $args['style']) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo $tag ?><?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
		<?php if ('div' != $args['style']) : ?>
			<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
			<?php endif; ?>

			<div class="comment-avatar">
				<?php if ($args['avatar_size'] != 0) {
					echo get_avatar($comment, 60);
				} ?>
			</div>

			<div class="comment-details">
				<div class="comment-author vcard">
					<?php printf(__('<strong class="fn">%s</strong> <span class="says">says:</span>', 'pe-terraclassic'), get_comment_author_link()); ?>
				</div>
				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>"> <?php printf(__('%1$s at %2$s', 'pe-terraclassic'), get_comment_date(), get_comment_time()); ?></a> <?php edit_comment_link(esc_html__('Edit', 'pe-terraclassic'), '<span class="separator">|</span>', ''); ?>
				</div>

				<?php if ($comment->comment_approved == '0') : ?>
					<div class="pe-info"><?php esc_html_e('Your comment is awaiting moderation.', 'pe-terraclassic'); ?></div>
				<?php endif; ?>

				<?php comment_text(); ?>

				<?php comment_reply_link(array_merge($args, array(
					'add_below' => $add_below,
					'depth'     => $depth,
					'max_depth' => $args['max_depth']
				))); ?>

			</div>

			<?php if ('div' != $args['style']) : ?>
			</div>
			<?php endif; ?><?php
						}

						/*-----------------------------------------------------------------------------------*/
						/*	Add IDs for images in Media Library (List View)
/*-----------------------------------------------------------------------------------*/

						if (!function_exists('pe_media_library_column_id')) {
							/**
							 * Add Item ID column in Media Manager
							 */
							function pe_media_library_column_id($columns)
							{
								$columns['colID'] = esc_html__('ID', 'pe-terraclassic');

								return $columns;
							}
						}
						add_filter('manage_media_columns', 'pe_media_library_column_id');

						if (!function_exists('pe_media_library_column_id_row')) {
							/**
							 * Add ID for item in Media Manager
							 */
							function pe_media_library_column_id_row($columnName, $columnID)
							{
								if ($columnName == 'colID') {
									echo $columnID;
								}
							}
						}
						add_filter('manage_media_custom_column', 'pe_media_library_column_id_row', 10, 2);

						/*-----------------------------------------------------------------------------------*/
						/*	Image with Caption
/*-----------------------------------------------------------------------------------*/

						if (!function_exists('pe_show_thumbnail')) {
							/**
							 * Show thumbnail with caption in post
							 *
							 * @param  string  $size     thumbnail size
							 * @param  boolean $show_cap show / hide caption
							 * @param array    $attr     query string or array of attributes
							 */
							function pe_show_thumbnail($size = 'large', $show_cap = true, $class = '', $attr = '')
							{
								$body_classes = get_body_class();

								if (in_array('blog', $body_classes)) {
									$thumbnails_link   = PEsettings::get('blog-thumbnails-link');
								} else {
									$thumbnails_link   = PEsettings::get('archive-thumbnails-link');
								}
								$post_id       = get_post_thumbnail_id();
								$caption       = (!empty($post_id)) ? get_post($post_id)->post_excerpt : false;
								$wrapper_class = (!empty($class)) ? sanitize_html_class($class) : '';
								$figure_class  = (!empty($caption) && $show_cap === true) ? 'wp-caption' : 'no-caption';
								echo '<div class="pe-image ' . $wrapper_class . '"><figure class="' . $figure_class . '">';
								if (is_singular()) {
									the_post_thumbnail($size, $attr);
								} else {
									if ($thumbnails_link == true) {
										echo '<a href="' . get_permalink() . '" title="' . get_the_title() . '">';
									}
									the_post_thumbnail($size, $attr);
									if ($thumbnails_link == true) {
										echo '</a>';
									}
								}
								if (!empty($caption) && $show_cap === true) {
									echo '<figcaption class="wp-caption-text">' . esc_attr($caption) . '</figcaption>';
								}
								echo '</figure></div>';
							}
						}

						/*-----------------------------------------------------------------------------------*/
						/*	Fallback webfonts load
/*-----------------------------------------------------------------------------------*/

						if (!function_exists('pe_fallback_fonts_url')) {
							/**
							 * Prepare Google Webfont URL
							 * @return string
							 */
							function pe_fallback_fonts_url()
							{
								$fonts_url = '';

								$font_families   = array();
								$font_families[] = 'Montserrat:400,700';

								$query_args = array(
									'family' => urlencode(implode('|', $font_families)),
									'subset' => urlencode('latin'),
								);

								$fonts_url = add_query_arg($query_args, '//fonts.googleapis.com/css');

								return esc_url_raw($fonts_url);
							}
						}

						/*-----------------------------------------------------------------------------------*/
						/*	Tags widget
/*-----------------------------------------------------------------------------------*/

						add_filter('widget_tag_cloud_args', 'pe_tag_cloud_sizes');
						if (!function_exists('pe_tag_cloud_sizes')) {
							/**
							 * Change tag widget font size
							 *
							 * @param  array $args
							 *
							 * @return array
							 */
							function pe_tag_cloud_sizes($args)
							{
								$args['largest']  = 1.5;  //largest tag
								$args['smallest'] = 1;    //smallest tag
								$args['unit']     = 'em'; //tag font unit

								return $args;
							}
						}

						/*-----------------------------------------------------------------------------------*/
						/*	BODY / POST Class
/*-----------------------------------------------------------------------------------*/

						//body class
						add_filter('body_class', 'pe_body_class');
						if (!function_exists('pe_body_class')) {
							/**
							 * Add class to body classes
							 *
							 * @param  array $classes
							 *
							 * @return array
							 */
							function pe_body_class($classes)
							{
								$body_classes = array();

								if (PEsettings::get('sticky-topbar')) {
									$body_classes[] = 'sticky-bar';
								}

								if (PEsettings::get('main-menu-switch')) {
									$body_classes[] = 'menu-' . sanitize_html_class(PEsettings::get('main-menu-switch'));
								}

								if (PEsettings::get('off-canavs-sidebar') && is_active_sidebar('off-canvas-sidebar')) {
									$body_classes[] = 'off-canvas';
								}

								if (is_active_sidebar('header')) {
									$body_classes[] = 'header';
								} else {
									$body_classes[] = 'noheader';
								}

								//wcag
								$nightVersion     = PEsettings::get('nightVersion');
								$highContrast     = PEsettings::get('highContrast');
								$wcagAnimation = PEsettings::get('wcagAnimation');
								$wideSite         = PEsettings::get('wideSite');
								$fontSizeSwitcher = PEsettings::get('fontSizeSwitcher');
								$verticalMainMenuAbsolute = PEsettings::get('vertical-main-menu-absolute');
								$headerSidebarActive = is_active_sidebar('header');
								$headerBackgroundFrontpage = PEsettings::get('headerBackgroundFrontpage');

								if (is_active_sidebar('top-bar-menu') || $nightVersion || $highContrast || $wideSite || $fontSizeSwitcher) {
									$body_classes[] = 'top-bar';
								}

								if ($highContrast) {
									$body_classes[] = 'wcag';
									$body_classes[] = sanitize_html_class(PEwcag::getContrast());
								}

								if ($highContrast && $wcagAnimation) {
									$body_classes[] = 'wcaganimation';
								}

								if (PEsettings::get('wcagFocus')) {
									$body_classes[] = 'wcagfocus';
								}

								if ($wideSite) {
									$body_classes[] = sanitize_html_class(PEwcag::getWidth());
								}

								if ($fontSizeSwitcher) {
									$body_classes[] = sanitize_html_class(PEwcag::getFont());
								}

								if ($verticalMainMenuAbsolute && $headerSidebarActive && (is_front_page() || is_home())) {
									$body_classes[] = 'vertical-menu-absolute';
								}

								if ($headerBackgroundFrontpage) {
									$body_classes[] = 'header-background-frontpage';
								}

								return array_merge($classes, $body_classes);
							}
						}

						//post class
						add_filter('post_class', 'pe_post_class');
						if (!function_exists('pe_post_class')) {
							/**
							 * Add class to post classes
							 *
							 * @param  array $classes
							 *
							 * @return array
							 */
							function pe_post_class($classes)
							{
								return array_merge($classes, array('clearfix'));
							}
						}

						/*-----------------------------------------------------------------------------------*/
						/*	Sanitize multiple classes
/*-----------------------------------------------------------------------------------*/

						if (!function_exists('pe_sanitize_class')) {
							function pe_sanitize_class($classes)
							{
								$classes = explode(' ', $classes);
								$classes = array_map('sanitize_html_class', $classes);
								$classes = implode(' ', $classes); //array to string

								return $classes;
							}
						}

						/*-----------------------------------------------------------------------------------*/
						/*	Sanitize size ( width / height )
/*-----------------------------------------------------------------------------------*/

						if (!function_exists('pe_sanitize_size')) {
							function pe_sanitize_size($index)
							{
								if (preg_match('/[0-9]+(px|%)/', $index)) {
									$output = $index;
								} else {
									$output = (int) $index . 'px';
								}

								return $output;
							}
						}

						/*-----------------------------------------------------------------------------------*/
						/*	esc_url protocols
/*-----------------------------------------------------------------------------------*/

						add_filter('kses_allowed_protocols', 'pe_more_protocols');
						if (!function_exists('pe_more_protocols')) {
							function pe_more_protocols($protocols)
							{
								$protocols[] = 'skype';

								return $protocols;
							}
						}

						/*-----------------------------------------------------------------------------------*/
						/*	add post types to search
						/*-----------------------------------------------------------------------------------*/

						add_action('pre_get_posts', 'pe_cpt_search');
						function pe_cpt_search($query)
						{
							if (!is_admin() && is_search() && $query->is_search && $query->is_main_query()) {
								$current = (array) get_query_var('post_type', 'post');
								$cpt = array('faqs', 'member', 'testimonial');
								$query->set('post_type', array_merge($current, $cpt));
							}
							return $query;
						}

						add_theme_support('terraclassifieds');

						/*-----------------------------------------------------------------------------------*/
						/*	notice about theme options in Appearance -> Themes
/*-----------------------------------------------------------------------------------*/
						function pe_appearance_themes()
						{
							global $pagenow;
							if ($pagenow == 'themes.php') {
								echo '<div class="notice notice-info is-dismissible pe-notice">';
								echo  '<p>' . __('Go to <a href="admin.php?page=pixelemu_options&tab=1"><strong>Theme Options</strong></a> to see theme settings.', 'pe-terraclassic') . '</p>';
								echo '</div>';
							}
						}
						add_action('admin_notices', 'pe_appearance_themes');
							?>