<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*	Theme menu activation
/*-----------------------------------------------------------------------------------*/
	function register_pe_menu() {
		register_nav_menus(
			array(
				'main-menu' => __( 'Main Menu', 'PixelEmu' ),
			)
		);
	}
	add_action( 'init', 'register_pe_menu' );


/*-----------------------------------------------------------------------------------*/
/*	Register Sidebars
/*-----------------------------------------------------------------------------------*/
	if ( function_exists('register_sidebar') ) {

				// Location: Top Bar
				register_sidebar(
						array(
								'name'            =>__('Top Bar','PixelEmu'),
								'id'              => 'top-bar-menu',
								'before_widget'   => '<div id="%1$s" class="widget %2$s">',
								'after_widget'    => '</div>',
								'before_title'    => '<span class="invisible">',
								'after_title'     => '</span>'
						)
				);

				// Location: Header
				register_sidebar(
						array(
								'name'            =>__('Header','PixelEmu'),
								'id'              => 'header',
								'before_widget'   => '<div id="%1$s" class="widget %2$s"><div class="pe-module-in clearfix">',
								'after_widget'    => '</div></div>',
								'before_title'    => '<h3 class="pe-title">',
								'after_title'     => '</h3>'
						)
				);

				// Location: Top
				register_sidebar(
						array(
								'name'            =>__('Top','PixelEmu'),
								'id'              => 'top',
								'before_widget'   => '<div id="%1$s" class="pe-module widget %2$s"><div class="pe-module-in clearfix">',
								'after_widget'    => '</div></div>',
								'before_title'    => '<h3 class="pe-title">',
								'after_title'     => '</h3>'
						)
				);

				// Location: Left
				register_sidebar(
						array(
								'name'            =>__('Left Sidebar','PixelEmu'),
								'id'              => 'left-column',
								'before_widget'   => '<div id="%1$s" class="pe-module widget %2$s"><div class="pe-module-in clearfix">',
								'after_widget'    => '</div></div>',
								'before_title'    => '<h3 class="pe-title">',
								'after_title'     => '</h3>'
						)
		)		;

				// Location: Left
				register_sidebar(
						array(
								'name'            =>__('Right Sidebar','PixelEmu'),
								'id'              => 'right-column',
								'before_widget'   => '<div id="%1$s" class="pe-module widget %2$s"><div class="pe-module-in clearfix">',
								'after_widget'    => '</div></div>',
								'before_title'    => '<h3 class="pe-title">',
								'after_title'     => '</h3>'
						)
				);

				// Location: Content Top
				register_sidebar(
						array(
								'name'            =>__('Content Top','PixelEmu'),
								'id'              => 'content-top',
								'before_widget'   => '<div id="%1$s" class="pe-module widget %2$s"><div class="pe-module-in clearfix">',
								'after_widget'    => '</div></div>',
								'before_title'    => '<h3 class="pe-title">',
								'after_title'     => '</h3>'
						)
				);

				// Location: Content Bottom
				register_sidebar(
						array(
								'name'            =>__('Content Bottom','PixelEmu'),
								'id'              => 'content-bottom',
								'before_widget'   => '<div id="%1$s" class="pe-module widget %2$s"><div class="pe-module-in clearfix">',
								'after_widget'    => '</div></div>',
								'before_title'    => '<h3 class="pe-title">',
								'after_title'     => '</h3>'
						)
				);

				// Location: Bottom
				register_sidebar(
						array(
								'name'            =>__('Bottom','PixelEmu'),
								'id'              => 'bottom',
								'before_widget'   => '<div id="%1$s" class="pe-module widget %2$s"><div class="pe-module-in clearfix">',
								'after_widget'    => '</div></div>',
								'before_title'    => '<h3 class="pe-title">',
								'after_title'     => '</h3>'
						)
				);

				// Location: Footer
				register_sidebar(
						array(
								'name'            =>__('Footer','PixelEmu'),
								'id'              => 'footer-mod',
								'before_widget'   => '<div id="%1$s" class="pe-module widget %2$s"><div class="pe-module-in clearfix">',
								'after_widget'    => '</div></div>',
								'before_title'    => '<h3 class="pe-title">',
								'after_title'     => '</h3>'
						)
				);

				// Location: Offcanvas Sidebar
				register_sidebar(
						array(
								'name'				=>__('Off-canvas Sidebar','PixelEmu'),
								'id'				=> 'off-canvas-sidebar',
								'before_widget' 	=> '<div id="%1$s" class="pe-module widget %2$s"><div class="pe-module-in clearfix">',
								'after_widget' 		=> '</div></div>',
								'before_title' 		=> '<h3 class="pe-title">',
								'after_title' 		=> '</h3>'
						)
				);

				// Location: Coming Soon Page
				register_sidebar(
						array(
								'name'              =>__('ComingSoon','PixelEmu'),
								'id'                => 'coming-soon-sidebar',
								'before_widget'     => '<div id="%1$s" class="pe-module widget clearfix %2$s">',
								'after_widget'      => '</div>',
								'before_title'      => '<h3 class="pe-title">',
								'after_title'       => '</h3>'
						)
				);

	}
/*-----------------------------------------------------------------------------------*/
/*  Add title-tag Support
/*-----------------------------------------------------------------------------------*/
	function theme_slug_setup() {
		 add_theme_support( 'title-tag' );
	}
	add_action( 'after_setup_theme', 'theme_slug_setup' );

	if ( ! function_exists( '_wp_render_title_tag' ) ) :
	 function spi_render_title() {
	?>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php
	 }
	 add_action( 'wp_head', 'spi_render_title' );
	endif;

	add_filter( 'wp_title', 'baw_hack_wp_title_for_home' );
	function baw_hack_wp_title_for_home( $title )
	{
		if( empty( $title ) && ( is_home() || is_front_page() ) ) {
			return bloginfo( 'name' );
		}
		return $title;
	}
/*-----------------------------------------------------------------------------------*/
//	Load Widgets
/*-----------------------------------------------------------------------------------*/
		get_template_part( '/functions/includes/widgets/pe-team-carousel-widget' );
		get_template_part( '/functions/includes/widgets/pe-testimonial-carousel-widget');
		get_template_part( '/functions/includes/widgets/pe-social-widget');
		get_template_part( '/functions/includes/widgets/pe-contact-widget');

/*-----------------------------------------------------------------------------------*/
//  Register Widgets
/*-----------------------------------------------------------------------------------*/
		if( !function_exists( 'register_pe_widgets' ) ){
				function register_pe_widgets() {
						register_widget( 'PE_Team_Carousel' );
						register_widget( 'PE_Testimonial_Carousel' );
						register_widget( 'PE_Social_Icons' );
						register_widget( 'PE_Contact' );
				}
		}
		add_action( 'widgets_init', 'register_pe_widgets' );

/*-----------------------------------------------------------------------------------*/
/*	Sanitize multiple classes
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'pe_sanitize_class' ) ) {
	function pe_sanitize_class( $classes ) {
		$classes = explode(' ', $classes);
		$classes = array_map( 'sanitize_html_class', $classes );
		$classes = implode( ' ', $classes ); //array to string
		return $classes;
	}
}

/*-----------------------------------------------------------------------------------*/
//  Custom class field for all widgets
/*-----------------------------------------------------------------------------------*/
	class PE_Custom_CSS {

		public static function pe_show_widget_new_class( $widget, $return, $instance ) {
			if ( !isset($instance['pe_classes']) ) $instance['pe_classes'] = null;

			$row = "<p>\n";
			$row .= "\t<p><label for='widget-{$widget->id_base}-{$widget->number}-pe_classes'>".apply_filters( 'widget_css_classes', esc_html__( 'Custom Widget Classes', 'PixelEmu' ) ).":</label>\n";
			$row .= "\t<input type='text' name='widget-{$widget->id_base}[{$widget->number}][pe_classes]' id='widget-{$widget->id_base}-{$widget->number}-pe_classes' value='{$instance['pe_classes']}' class='widefat' /></p>\n";
			$row .= "</p>\n";

			echo $row;
			return $instance;
		}

		public static function pe_widget_update( $instance, $new_instance ) {
			$instance['pe_classes'] = $new_instance['pe_classes'];
			return $instance;
		}

		public static function pe_dynamic_sidebar_params( $params ) {
			global $wp_registered_widgets;
			$widget_id	= $params[0]['widget_id'];
			$widget_obj	= $wp_registered_widgets[$widget_id];
			$widget_opt	= get_option($widget_obj['callback'][0]->option_name);
			$widget_num	= $widget_obj['params'][0]['number'];

			if ( isset($widget_opt[$widget_num]['pe_classes']) && !empty($widget_opt[$widget_num]['pe_classes']) )
				$params[0]['before_widget'] = preg_replace( '/class="/', "class=\"{$widget_opt[$widget_num]['pe_classes']} ", $params[0]['before_widget'], 1 );
			return $params;
		}

	}

	if ( is_admin() ) {
		add_action( 'in_widget_form', array('PE_Custom_CSS', 'pe_show_widget_new_class'),  10, 3 );
		add_filter( 'widget_update_callback', array('PE_Custom_CSS','pe_widget_update'), 10, 2 );
	}

	if ( !is_admin() ) {
		add_filter( 'dynamic_sidebar_params', array('PE_Custom_CSS', 'pe_dynamic_sidebar_params') );
	}

/*-----------------------------------------------------------------------------------*/
/*  Enable shortcode on widget text
/*-----------------------------------------------------------------------------------*/
	add_filter('widget_text', 'do_shortcode');

/*-----------------------------------------------------------------------------------*/
/*  Modify wp readmore
/*-----------------------------------------------------------------------------------*/
		add_filter( 'the_content_more_link', 'pe_modify_read_more_link' );
		function pe_modify_read_more_link() {
				return '<p class="pe-article-read-more"><a class="readmore" href="' . get_permalink() . '">'.__('Read more...', 'PixelEmu').'</a></p>';
		}

/*-----------------------------------------------------------------------------------*/
/*  Adding Default Thumbnail Sizes
/*-----------------------------------------------------------------------------------*/
		if( function_exists( 'add_theme_support' ) ){
				add_theme_support( 'post-thumbnails' );
				set_post_thumbnail_size( 150, 150 );                        // default Post Thumbnail dimensions

				add_image_size( 'post-featured-image', 185, 165, true);     // For Standard Post Thumbnails
				add_image_size( 'member-carousel-small', 90, 90, true);		// For members carousel small
				add_image_size( 'member-carousel-large', 150, 150, true);	// For members carousel large
				add_image_size( 'member-grid-small', 150, 167, true);		// For members grid small
				add_image_size( 'member-grid-large', 270, 300, true);		// For members gridl large
		}
/*-----------------------------------------------------------------------------------*/
/*  Adding Feed Links Support
/*-----------------------------------------------------------------------------------*/
if( function_exists( 'add_theme_support' ) ) {
		add_theme_support('automatic-feed-links');
}

/*-----------------------------------------------------------------------------------*/
//	Theme Pagination Method
/*-----------------------------------------------------------------------------------*/

	if ( !function_exists( 'pe_pagination' ) ) {
		function pe_pagination() {
			echo '<div class="pe-pagination"><nav>';
				global $wp_query;
				$big = 999999999; // need an unlikely integer
				$pages = paginate_links( array(
								'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format' => '?paged=%#%',
								'current' => max( 1, get_query_var('paged') ),
								'total' => $wp_query->max_num_pages,
								'prev_next' => false,
								'type'  => 'array',
								'prev_next'   => TRUE,
					'prev_text'    => __( 'Prev', 'PixelEmu' ),
					'next_text'    => __( 'Next', 'PixelEmu' ),
						) );
						if( is_array( $pages ) ) {
								$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
								echo '<ul class="pagination">';
								foreach ( $pages as $page ) {
												echo "<li>$page</li>";
								}
							 echo '</ul>';
						}
			echo '</nav></div>';
		}
	}

		if( !function_exists( 'pe_pagination_services' ) ){
				function pe_pagination_services($pages = ''){
						global $paged;

						if(empty($paged))$paged = 1;

						$prev = $paged - 1;
						$next = $paged + 1;
						$range = 2; // only change it to show more links
						$showitems = ($range * 2)+1;

						if($pages == ''){
								global $wp_query;
								$pages = $wp_query->max_num_pages;
								if(!$pages){
										$pages = 1;
								}
						}

						if(1 != $pages){
								echo "<div class='pe-pagination'><nav><ul class='pagination'>";
								echo ($paged > 2 && $paged > $range+1 && $showitems < $pages)? "<li><a href='".get_pagenum_link(1)."' data-toggle='tooltip' data-placement='top' title='' aria-label='".__('Start', 'PixelEmu')."' data-original-title='".__('Start', 'PixelEmu')."'>&laquo; ".__('Start', 'PixelEmu')."</a></li> ":"";
								echo ($paged > 1 && $showitems < $pages)? "<li><a href='".get_pagenum_link($prev)."' data-toggle='tooltip' data-placement='top' title='' aria-label='".__('Prev', 'PixelEmu')."' data-original-title='".__('Prev', 'PixelEmu')."'>&laquo; ". __('Prev', 'PixelEmu')."</a></li> ":"";
								for ($i=1; $i <= $pages; $i++){
										if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
												echo ($paged == $i)? "<li class='active'><span>".$i."<span class='sr-only'>(current)</span></span></li> ":"<li><a href='".get_pagenum_link($i)."'>".$i."</a></li> ";
										}
								}
								echo ($paged < $pages && $showitems < $pages) ? "<li><a href='".get_pagenum_link($next)."' data-toggle='tooltip' data-placement='top' title='' aria-label='".__('Next', 'PixelEmu')."' data-original-title='".__('Next', 'PixelEmu')."'>". __('Next', 'PixelEmu') ." &raquo;</a></li> " :"";
								echo ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? "<li><a href='".get_pagenum_link($pages)."' data-toggle='tooltip' data-placement='top' title='' aria-label='".__('End', 'PixelEmu')."' data-original-title='".__('End', 'PixelEmu')."'>". __('End', 'PixelEmu') ." &raquo;</a></li> ":"";
								echo "</ul></nav></div>";
						}
				}
		}
/*-----------------------------------------------------------------------------------*/
/*  Custom Excerpt Method
/*-----------------------------------------------------------------------------------*/
		if( !function_exists( 'pe_excerpt' ) ){
				function pe_excerpt($len=15, $trim="&hellip;"){
						echo get_pe_excerpt($len,$trim);
				}
		}

		if( !function_exists( 'get_pe_excerpt' ) ){
				function get_pe_excerpt($len=15, $trim="&hellip;"){
						$limit = $len+1;
						$excerpt = explode(' ', get_the_excerpt(), $limit);
						$num_words = count($excerpt);
						if($num_words >= $len){
								$last_item=array_pop($excerpt);
						}
						else{
								$trim="";
						}
						$excerpt = implode(" ",$excerpt)."$trim";
						return $excerpt;
				}
		}

		if( !function_exists( 'blog_excerpt' ) ){
				function blog_excerpt($len=15, $trim="&hellip;"){
						echo get_blog_excerpt($len,$trim);
				}
		}

		if( !function_exists( 'get_blog_excerpt' ) ){
				function get_blog_excerpt($len=15, $trim="&hellip;"){
						$limit = $len+1;
						$excerpt = explode(' ', get_the_excerpt(), $limit);
						$num_words = count($excerpt);
						if($num_words >= $len){
								$last_item=array_pop($excerpt);
						}
						else{
								$trim="";
						}
						$excerpt = implode(" ",$excerpt)."$trim";
						$excerpt .= '<p class="pe-article-read-more"><a class="readmore" href="'.get_permalink().'">'.__('Read more...', 'PixelEmu').'</a></p>';
						return $excerpt;
				}
		}

/*-----------------------------------------------------------------------------------*/
/*  HTML5 Support
/*-----------------------------------------------------------------------------------*/
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

/*-----------------------------------------------------------------------------------*/
/*  Change help text for FAQ post type
/*-----------------------------------------------------------------------------------*/
	add_filter( 'enter_title_here', 'faq_enter_title' );

	function faq_enter_title( $input ) {
			global $post_type;

			if ( is_admin() && 'faqs' == $post_type )
					return __( 'Enter Question here', 'PixelEmu' );
			return $input;
	}

/*-----------------------------------------------------------------------------------*/
/*  Comingsoon Tempalte
/*-----------------------------------------------------------------------------------*/
	add_filter( 'template_include', 'coming_soon_page', 99 );

	function load_global_theme_options() {
		$GLOBALS['comingsoonmode'] = ot_get_option( 'coming-soon', 'off' );
		$GLOBALS['otdateFormat'] = ot_get_option( 'coming-soon-date' );
		$GLOBALS['comingsoondateFormat'] = date('j F Y h:i:s', strtotime($GLOBALS['otdateFormat']));
		$GLOBALS['current_time'] = current_time( 'mysql' );
		$GLOBALS['futuredate'] = ($GLOBALS['current_time'] > $GLOBALS['otdateFormat']) ? '0' : '1';
		$GLOBALS['socials'] = ot_get_option( 'social_links' );
		$GLOBALS['contact_address'] = ot_get_option( 'contact_address' );
		$GLOBALS['email_address'] = ot_get_option( 'email_address' );
	}

	add_action('after_setup_theme', 'load_global_theme_options', 2);

	function coming_soon_page( $template ) {
			if (!is_user_logged_in() && ($GLOBALS['comingsoonmode'] == 'on') && ($GLOBALS['otdateFormat'] !='') && $GLOBALS['futuredate'] == 1) {
					$cs_template = locate_template( array( 'tpl/comingsoon.php' ) );
					if ( '' != $cs_template ) {
							return $cs_template ;
					}
			}
			return $template;
	}

/*-----------------------------------------------------------------------------------*/
/*  Add empty Option Type to theme options used for separator
/*-----------------------------------------------------------------------------------*/
		if ( ! function_exists( 'ot_type_empty' ) ) {
			function ot_type_empty( $args = array() ) {
				/* turns arguments array into variables */
				extract( $args );
			}
		}

/*-----------------------------------------------------------------------------------*/
/*  Add Option for main color on Theme Option
/*-----------------------------------------------------------------------------------*/
	if ( ! function_exists( 'ot_type_main_color' ) ) {
		function ot_type_main_color( $args = array() ) {
			/* turns arguments array into variables */
			extract( $args );
			/* verify a description */
			$has_desc = $field_desc ? true : false;
			/* format setting outer wrapper */
			echo '<div class="format-setting type-main-color ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
			/* description */
			echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
			/* format setting inner wrapper */
			echo '<div class="format-setting-inner">';
			/* allow fields to be filtered */
			$ot_recognized_main_color_fields = apply_filters( 'ot_recognized_main_color_fields', array(
				'main'		=> _x( 'Main scheme color', 'color picker', 'PixelEmu' ),
				'darken'	=> _x( 'General hover color', 'color picker', 'PixelEmu' ),
			), $field_id );
			/* build main color fields */
			foreach( $ot_recognized_main_color_fields as $type => $label ) {

				if ( array_key_exists( $type, $ot_recognized_main_color_fields ) ) {
					echo '<div class="option-tree-ui-colorpicker-input-wrap">';
					echo '<label for="' . esc_attr( $field_id ) . '-picker-' . $type . '" class="option-tree-ui-colorpicker-label">' . esc_attr( $label ) . '</label>';
					/* colorpicker JS */
					echo '<script>jQuery(document).ready(function($) { OT_UI.bind_colorpicker("' . esc_attr( $field_id ) . '-picker-' . $type . '"); });</script>';
					/* set color */
					$color = isset( $field_value[ $type ] ) ? esc_attr( $field_value[ $type ] ) : '';
					/* set default color */
					$std = isset( $field_std[ $type ] ) ? 'data-default-color="' . $field_std[ $type ] . '"' : '';
					/* input */
					echo '<input type="text" name="' . esc_attr( $field_name ) . '[' . $type . ']" id="' . esc_attr( $field_id ) . '-picker-' . $type . '" value="' . $color . '" class="hide-color-picker ' . esc_attr( $field_class ) . '" ' . $std . ' />';
					echo '</div>';
				}
			}
			echo '</div>';
			echo '</div>';
		}
	}

/*-----------------------------------------------------------------------------------*/
/*  Register the new options
/*-----------------------------------------------------------------------------------*/
	function add_new_option_types( $types ) {
		$types['empty'] = 'Empty';
		$types['main_color'] = 'Main Color';
		return $types;
	}
	add_filter( 'ot_option_types_array', 'add_empty_option_types' );

/*-----------------------------------------------------------------------------------*/
/*	Load the theme's translated strings.
/*-----------------------------------------------------------------------------------*/
	add_action('after_setup_theme', 'pe_load_theme_textdomain');
	function pe_load_theme_textdomain(){
			load_theme_textdomain('PixelEmu', get_template_directory() . '/languages');
	}

/*-----------------------------------------------------------------------------------*/
/*	Custom CPT Search
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'pe_cpt_search' ) ) {
	/**
	 * This function modifies the main WordPress query to include an array of
	 * post types instead of the default 'post' post type.
	 *
	 * @param object $query  The original query.
	 * @return object $query The amended query.
	 */
	function pe_cpt_search( $query ) {
		if ( is_search() && $query->is_search ) {
			$query->set( 'post_type', array( 'post', 'faqs', 'member', 'service', 'testimonial' ) );
		}
		return $query;
	}
}
add_filter( 'pre_get_posts', 'pe_cpt_search' );

/*-----------------------------------------------------------------------------------*/
/*	Post class
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'pe_post_classes' ) ) {
	function pe_post_classes( $classes ) {
		$classes = array_diff( $classes, array( 'hentry' ) );
		if( ! is_admin() ) {
			$classes = array_merge( $classes, array( 'clearfix' ) );
		}
		return $classes;
	}
}
add_filter( 'post_class','pe_post_classes' );

?>
