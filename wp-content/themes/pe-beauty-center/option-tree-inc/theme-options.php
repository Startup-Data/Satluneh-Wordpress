<?php
/**
 * Initialize the custom Theme Options.
 */
add_action( 'init', 'custom_theme_options' );

/**
 * Build the custom settings & update OptionTree.
 *
 * @return    void
 * @since     2.3.0
 */
function custom_theme_options() {

	/* OptionTree is not loaded yet, or this is not an admin request */
	if ( ! function_exists( 'ot_settings_id' ) || ! is_admin() )
		return false;

	/**
	 * Get a copy of the saved settings array.
	 */
	$saved_settings = get_option( ot_settings_id(), array() );

	/**
	 * Custom settings array that will eventually be
	 * passes to the OptionTree Settings API Class.
	 */
	$custom_settings = array(
		/*'contextual_help' => array(
			'content'       => array(
				array(
					'id'        => 'basic_settings_help',
					'title'     => __( 'Option Types', 'PixelEmu' ),
					'content'   => '<p>' . __( 'Help content goes here!', 'PixelEmu' ) . '</p>'
				)
			),
			'sidebar'       => '<p>' . __( 'Sidebar content goes here!', 'PixelEmu' ) . '</p>'
		),*/
		'sections'        => array(
			array(
				'id'          => 'basic_settings',
				'title'       => __( 'General Settings', 'PixelEmu' )
			),
			array(
				'id'          => 'posts_pages',
				'title'       => __( 'Posts & Pages', 'PixelEmu' )
			),
			array(
				'id'          => 'layout',
				'title'       => __( 'Layout', 'PixelEmu' )
			),
			array(
				'id'          => 'columns',
				'title'       => __( 'Default Blog Layout', 'PixelEmu' )
			),
			array(
				'id'          => 'background_colors',
				'title'       => __( 'Background Colors', 'PixelEmu' )
			),
			array(
				'id'          => 'fonts',
				'title'       => __( 'Fonts', 'PixelEmu' )
			),
			array(
				'id'          => 'footer',
				'title'       => __( 'Footer', 'PixelEmu' )
			),
			array(
				'id'          => 'advanced',
				'title'       => __( 'Advanced', 'PixelEmu' )
			),
			array(
				'id'          => 'contact_page',
				'title'       => __( 'Contact Page', 'PixelEmu' )
			),
			array(
				'id'          => 'theme_css',
				'title'       => __( 'Dynamic CSS', 'PixelEmu' )
			)
		),
		'settings'        => array(
			array(
				'id'          => 'logo',
				'label'       => __( 'Logo', 'PixelEmu' ),
				'desc'        => __( 'Upload a logo image here.', 'PixelEmu' ),
				'std'         => '',
				'type'        => 'upload',
				'section'     => 'basic_settings',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'favicon',
				'label'       => __( 'Favicon', 'PixelEmu' ),
				'desc'        => __( 'Upload a favicon file here.', 'PixelEmu' ),
				'std'         => '',
				'type'        => 'upload',
				'section'     => 'basic_settings',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'back_to_top',
				'label'       => __( 'Back to Top', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable back to top button.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'basic_settings',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'sticky_topbar',
				'label'       => __( 'Sticky Topbar', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable the sticky topbar with the menu.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'basic_settings',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'offcanvas-sidebar',
				'label'       => __( 'Off-Canvas sidebar', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable the Off-Canvas sidebar.', 'PixelEmu' ),
				'std'         => 'off',
				'type'        => 'on-off',
				'section'     => 'basic_settings',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'offcanvas_width',
				'label'       => __( 'Off-Canvas Width (px)', 'PixelEmu' ),
				'desc'        => __( 'Enter the Off-Canvas width in pixels.', 'PixelEmu' ),
				'std'         => '300',
				'type'        => 'text',
				'section'     => 'basic_settings',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'offcanvas_position',
				'label'       => __( 'Off-Canvas position', 'PixelEmu' ),
				'desc'        => __( 'Choose the position of Off-Canvas sidebar.', 'PixelEmu' ),
				'std'         => 'right',
				'type'        => 'select',
				'section'     => 'basic_settings',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => array(
					array(
						'value'       => 'right',
						'label'       => __( 'Right', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => 'left',
						'label'       => __( 'Left', 'PixelEmu' ),
						'src'         => ''
					)
				)
			),
			array(
				'id'          => 'coming-soon',
				'label'       => __( 'Coming Soon Mode', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable the Comming Soon Mode.', 'PixelEmu' ),
				'std'         => 'off',
				'type'        => 'on-off',
				'section'     => 'basic_settings',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'coming-soon-date',
				'label'       => __( 'Coming Soon Date', 'PixelEmu' ),
				'desc'        => __( 'Please choose comming soon date to enable it.', 'PixelEmu' ),
				'std'         => '',
				'type'        => 'date-time-picker',
				'section'     => 'basic_settings',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),

			/** FRONT PAGE SETTINGS **/
			array(
				'id'          => 'front_page',
				'label'       => __( 'Front Page', 'PixelEmu' ),
				'type'        => 'empty',
				'section'     => 'posts_pages',
				'operator'    => 'and'
			),
			array(
				'id'          => 'font_sizer_front',
				'label'       => __( 'Font Sizer', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable the font size switcher in Front Page. It is displayed above the content area.', 'PixelEmu' ),
				'std'         => 'off',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'front_page_title',
				'label'       => __( 'Front Page Title', 'PixelEmu' ),
				'desc'        => __( 'Show/hide Page Title when static page is used as front page.', 'PixelEmu' ),
				'std'         => 'off',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			/** FRONT PAGE SETTINGS END **/

			/** SINGLE POST SETTINGS **/
			array(
				'id'          => 'single_post',
				'label'       => __( 'Single Post', 'PixelEmu' ),
				'type'        => 'empty',
				'section'     => 'posts_pages',
				'operator'    => 'and'
			),
			array(
				'id'          => 'breadcrumb_single',
				'label'       => __( 'Breadcrumb', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable Breadcrumb in Single Post.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'font_sizer_single',
				'label'       => __( 'Font Sizer', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable the font size switcher in Single Post. It is displayed above the content area.', 'PixelEmu' ),
				'std'         => 'off',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'post_info_single',
				'label'       => __( 'Post Info', 'PixelEmu' ),
				'desc'        => __( 'Show/Hide post info (ex: post date, category, author) in single posts.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'post_tags_single',
				'label'       => __( 'Tags', 'PixelEmu' ),
				'desc'        => __( 'Show/Hide tags in sigle post.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'author_info_single',
				'label'       => __( 'Author Info', 'PixelEmu' ),
				'desc'        => __( 'Show/Hide Author info (ex: avatar, bio, website) under content in single posts.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'comments_single',
				'label'       => __( 'Comments', 'PixelEmu' ),
				'desc'        => __( 'Show/Hide comments for all single posts, default is On.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			/** SINGLE POST SETTINGS END **/

			/** SINGLE PAGE SETTINGS **/
			array(
				'id'          => 'single_page',
				'label'       => __( 'Single Page', 'PixelEmu' ),
				'type'        => 'empty',
				'section'     => 'posts_pages',
				'operator'    => 'and'
			),
			array(
				'id'          => 'breadcrumb_page',
				'label'       => __( 'Breadcrumb', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable Breadcrumb in Pages.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'font_sizer_page',
				'label'       => __( 'Font Sizer', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable the font size switcher in Pages. It is displayed above the content area.', 'PixelEmu' ),
				'std'         => 'off',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'comments_page',
				'label'       => __( 'Comments', 'PixelEmu' ),
				'desc'        => __( 'Show/Hide comments for all Pages, default is Off.', 'PixelEmu' ),
				'std'         => 'off',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			/** SINGLE PAGE SETTINGS END **/

			/** SINGLE SERVICE PAGE SETTINGS **/
			array(
				'id'          => 'single_service',
				'label'       => __( 'Single Service', 'PixelEmu' ),
				'type'        => 'empty',
				'section'     => 'posts_pages',
				'operator'    => 'and'
			),
			array(
				'id'          => 'breadcrumb_service',
				'label'       => __( 'Breadcrumb', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable Breadcrumb in Services.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'font_sizer_service',
				'label'       => __( 'Font Sizer', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable the font size switcher in Services. It is displayed above the content area.', 'PixelEmu' ),
				'std'         => 'off',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			/** SINGLE SERVICES SETTINGS END **/

			/** SINGLE MEMBER SETTINGS **/
			array(
				'id'          => 'single_member',
				'label'       => __( 'Single Member Page', 'PixelEmu' ),
				'type'        => 'empty',
				'section'     => 'posts_pages',
				'operator'    => 'and'
			),
			array(
				'id'          => 'breadcrumb_member',
				'label'       => __( 'Breadcrumb', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable Breadcrumb in Single Member Page.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'font_sizer_member',
				'label'       => __( 'Font Sizer', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable the font size switcher in Single Member Page. It is displayed above the content area.', 'PixelEmu' ),
				'std'         => 'off',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'avatar_size_single',
				'label'       => __( 'Members image size', 'PixelEmu' ),
				'desc'        => __( 'Please choose mebers image size on single member page.', 'PixelEmu' ),
				'std'         => '1',
				'type'        => 'select',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => array(
					array(
						'value'       => '',
						'label'       => __( '-- Choose One --', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '1',
						'label'       => __( 'Small Image', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '2',
						'label'       => __( 'Large Image', 'PixelEmu' ),
						'src'         => ''
					),
				)
			),
			array(
				'id'          => 'social_links_member',
				'label'       => __( 'Social Links', 'PixelEmu' ),
				'desc'        => __( 'Show/hide social link in Single Member Page.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'contact_info_member',
				'label'       => __( 'Contact Info', 'PixelEmu' ),
				'desc'        => __( 'Show/hide contact info in Single Member Page.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			/** SINGLE MEMBER SETTINGS END **/

			/** SINGLE TESTIMONIAL SETTINGS **/
			array(
				'id'          => 'single_testimonial',
				'label'       => __( 'Single Testimonial Page', 'PixelEmu' ),
				'type'        => 'empty',
				'section'     => 'posts_pages',
				'operator'    => 'and'
			),
			array(
				'id'          => 'breadcrumb_testimonial',
				'label'       => __( 'Breadcrumb', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable Breadcrumb in Single Testimonial Page.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'font_sizer_testimonial',
				'label'       => __( 'Font Sizer', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable the font size switcher in Single Testimonial Page. It is displayed above the content area.', 'PixelEmu' ),
				'std'         => 'off',
				'type'        => 'on-off',
				'section'     => 'posts_pages',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			/** SINGLE TESTIMONIAL SETTINGS END **/

			array(
				'id'          => 'google_map',
				'label'       => __( 'Google Map', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable Google Map on Contact Page.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'contact_page',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'map_api_key',
				'label'       => __( 'Google Maps API key', 'PixelEmu' ),
				'desc'        => __( 'Provide google map API key (<a href="http://googlegeodevelopers.blogspot.com.au/2016/06/building-for-scale-updates-to-google.html" target="_blank">more details</a>,
							<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">get key</a>).', 'PixelEmu' ),
				'std'         => '',
				'type'        => 'text',
				'section'     => 'contact_page',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'map_latitude',
				'label'       => __( 'Latitude', 'PixelEmu' ),
				'desc'        => __( 'Provice Google Map Latitude.', 'PixelEmu' ),
				'std'         => '51.519011',
				'type'        => 'text',
				'section'     => 'contact_page',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'map_longitude',
				'label'       => __( 'Longitude', 'PixelEmu' ),
				'desc'        => __( 'Provice Google Map Longitude.', 'PixelEmu' ),
				'std'         => '-0.116958',
				'type'        => 'text',
				'section'     => 'contact_page',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'map_zoom',
				'label'       => __( 'Zoom', 'PixelEmu' ),
				'desc'        => __( 'Provice Google Map zoom level.', 'PixelEmu' ),
				'std'         => '16',
				'type'        => 'text',
				'section'     => 'contact_page',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'contact_details',
				'label'       => __( 'Contact Details', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable Contact Details on Contact Page.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'contact_page',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'contact_address',
				'label'       => __( 'Contact Address', 'PixelEmu' ),
				'desc'        => __( 'Provide address that will be displayed on Contact Page.', 'PixelEmu' ),
				'std'         => '',
				'type'        => 'textarea',
				'section'     => 'contact_page',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'email_address',
				'label'       => __( 'Email Address', 'PixelEmu' ),
				'desc'        => __( 'Provide email address that will be displayed on Contact Page.', 'PixelEmu' ),
				'std'         => '',
				'type'        => 'text',
				'section'     => 'contact_page',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'contact_form',
				'label'       => __( 'Contact Form', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable Contact Form on Contact Page.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'contact_page',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'contact_email',
				'label'       => __( 'Contact Emails', 'PixelEmu' ),
				'desc'        => __( 'Provide email address that will be used to receive emails from contact form.', 'PixelEmu' ),
				'std'         => '',
				'type'        => 'text',
				'section'     => 'contact_page',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'theme_width',
				'label'       => __( 'Theme Width (px)', 'PixelEmu' ),
				'desc'        => __( 'Theme width in pixels.', 'PixelEmu' ),
				'std'         => array( 1230, 'px' ),
				'type'        => 'measurement',
				'section'     => 'layout',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'left_column_width',
				'label'       => __( 'Left Column Width', 'PixelEmu' ),
				'desc'        => __( 'Left column width in percents.', 'PixelEmu' ),
				'std'         => '3',
				'type'        => 'select',
				'section'     => 'layout',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => array(
					array(
						'value'       => '',
						'label'       => __( '-- Choose One --', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '1',
						'label'       => __( '8%', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '2',
						'label'       => __( '17%', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '3',
						'label'       => __( '25%', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '4',
						'label'       => __( '33%', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '5',
						'label'       => __( '42%', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '6',
						'label'       => __( '50%', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '7',
						'label'       => __( '58%', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '8',
						'label'       => __( '67%', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '9',
						'label'       => __( '75%', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '10',
						'label'       => __( '83%', 'PixelEmu' ),
						'src'         => ''
					)
				)
			),
			array(
				'id'          => 'right_column_width',
				'label'       => __( 'Right Column Width', 'PixelEmu' ),
				'desc'        => __( 'Right column in percents.', 'PixelEmu' ),
				'std'         => '3',
				'type'        => 'select',
				'section'     => 'layout',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => array(
					array(
						'value'       => '',
						'label'       => __( '-- Choose One --', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '1',
						'label'       => __( '8%', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '2',
						'label'       => __( '17%', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '3',
						'label'       => __( '25%', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '4',
						'label'       => __( '33%', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '5',
						'label'       => __( '42%', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '6',
						'label'       => __( '50%', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '7',
						'label'       => __( '58%', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '8',
						'label'       => __( '67%', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '9',
						'label'       => __( '75%', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => '10',
						'label'       => __( '83%', 'PixelEmu' ),
						'src'         => ''
					)
				)
			),
			array(
				'id'          => 'frontpage_layout',
				'label'       => __( 'Frontpage Layout', 'PixelEmu' ),
				'desc'        => __( 'Layout for frontpage - number of columns and arrangement of them.', 'PixelEmu' ),
				'std'         => 'left-sidebar',
				'type'        => 'radio-image',
				'section'     => 'layout',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'subpage_layout',
				'label'       => __( 'Subpage Layout', 'PixelEmu' ),
				'desc'        => __( 'Layout for subpage - number of columns and arrangement of them.', 'PixelEmu' ),
				'std'         => 'right-sidebar',
				'type'        => 'radio-image',
				'section'     => 'layout',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),

			/** BLOG VIEW SETTINGS **/
			array(
				'id'          => 'blog_page',
				'label'       => __( 'Blog', 'PixelEmu' ),
				'type'        => 'empty',
				'section'     => 'columns',
				'operator'    => 'and'
			),
			array(
				'id'          => 'blog_layout',
				'label'       => __( 'Choose Default Blog Layout', 'PixelEmu' ),
				'desc'        => __( 'Choose the layout:<br />
							1. <strong>1 column</strong>: 1 post in a row<br />
							2. <strong>2 columns</strong>: 2 posts in a row<br />
							3. <strong>2 columns, with intro post</strong>: 1 Leading post + 2 posts in a row<br />', 'PixelEmu' ),
				'std'         => 'blog-1col',
				'type'        => 'select',
				'section'     => 'columns',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => array(
					array(
						'value'       => 'blog-1col',
						'label'       => __( '1 column', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => 'blog-2cols',
						'label'       => __( '2 columns', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => 'blog-leading-2cols',
						'label'       => __( '2 columns, with intro post', 'PixelEmu' ),
						'src'         => ''
					)
				)
			),
			array(
				'id'          => 'font_sizer_blog',
				'label'       => __( 'Font Sizer', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable the font size switcher in Blog View. It is displayed above the content area.', 'PixelEmu' ),
				'std'         => 'off',
				'type'        => 'on-off',
				'section'     => 'columns',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'post_info_blog',
				'label'       => __( 'Post Info', 'PixelEmu' ),
				'desc'        => __( 'Show/Hide post info (ex: post date, category, author) in Blog View.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'columns',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'thumbnail_blog',
				'label'       => __( 'Post Thumbnail', 'PixelEmu' ),
				'desc'        => __( 'Show/Hide post thumbnails in Blog View.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'columns',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'readmore_blog',
				'label'       => __( 'Readmore', 'PixelEmu' ),
				'desc'        => __( 'Show/Hide readmore text in Blog View.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'columns',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			/** BLOG VIEW SETTINGS END **/

			/** ARCHIVE VIEW SETTINGS **/
			array(
				'id'          => 'archive_page',
				'label'       => __( 'Archive', 'PixelEmu' ),
				'type'        => 'empty',
				'section'     => 'columns',
				'operator'    => 'and'
			),
			array(
				'id'          => 'archive_layout',
				'label'       => __( 'Archive Layout (Category, Tag, Author, Day, Moth, Year View)', 'PixelEmu' ),
				'desc'        => __( 'Choose the layout:<br />
							1. <strong>1 column</strong>: 1 post in a row<br />
							2. <strong>2 columns</strong>: 2 posts in a row<br />', 'PixelEmu' ),
				'std'         => 'archive-1col',
				'type'        => 'select',
				'section'     => 'columns',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => array(
					array(
						'value'       => 'archive-1col',
						'label'       => __( '1 column', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => 'archive-2cols',
						'label'       => __( '2 columns', 'PixelEmu' ),
						'src'         => ''
					),
					array(
						'value'       => 'archive-leading-2cols',
						'label'       => __( '2 columns, with intro post', 'PixelEmu' ),
						'src'         => ''
					)
				)
			),
			array(
				'id'          => 'breadcrumb_archive',
				'label'       => __( 'Breadcrumb', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable Breadcrumb in Archive (Category, Tags,  Date etc).', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'columns',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'font_sizer_archive',
				'label'       => __( 'Font Sizer', 'PixelEmu' ),
				'desc'        => __( 'Enable/disable the font size switcher in Archive Archive (Category, Tags,  Date etc). It is displayed above the content area.', 'PixelEmu' ),
				'std'         => 'off',
				'type'        => 'on-off',
				'section'     => 'columns',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'header_title_archive',
				'label'       => __( 'Header Title', 'PixelEmu' ),
				'desc'        => __( 'Show/Hide header title (ex: All posts in category Peace) in Archive (Category, Tags,  Date etc).', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'columns',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'post_info_archive',
				'label'       => __( 'Post Info', 'PixelEmu' ),
				'desc'        => __( 'Show/Hide post info (ex: post date, category, author) in Archive (Category, Tags,  Date etc).', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'columns',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'thumbnail_archive',
				'label'       => __( 'Post Thumbnail', 'PixelEmu' ),
				'desc'        => __( 'Show/Hide post thumbnails in Archive (Category, Tags,  Date etc).', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'columns',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'readmore_archive',
				'label'       => __( 'Readmore', 'PixelEmu' ),
				'desc'        => __( 'Show/Hide readmore text in Archive (Category, Tags,  Date etc).', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'columns',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			/** ARCHIVE VIEW SETTINGS END **/

			array(
				'id'          => 'general_color',
				'label'       => __( 'General', 'PixelEmu' ),
				'type'        => 'empty',
				'section'     => 'background_colors',
				'operator'    => 'and'
			),
			array(
				'id'          => 'main_scheme_color',
				'label'       => __( '', 'PixelEmu' ),
				'desc'        => __( 'Color for buttons, links, pagination etc.<br />Choose the main scheme color instead of using the default Darkgoldenrod. Many general theme elements will be modified like buttons, links, pagination. Another elements like titles can be configured separately.', 'PixelEmu' ),
				'std'         => array('main' => '#B7853D', 'darken' => '#A47737'),
				'type'        => 'main_color',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'page_background',
				'label'       => __( 'Page background', 'PixelEmu' ),
				'desc'        => __( 'Main background color', 'PixelEmu' ),
				'std'         => '#F5F5F5',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'main_page_background',
				'label'       => __( 'Container background', 'PixelEmu' ),
				'desc'        => __( 'Container background color', 'PixelEmu' ),
				'std'         => '#FFFFFF',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'base_border',
				'label'       => __( 'Base border', 'PixelEmu' ),
				'desc'        => __( 'Choose base border color', 'PixelEmu' ),
				'std'         => '#ededed',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'top_color',
				'label'       => __( 'Top Bar', 'PixelEmu' ),
				'type'        => 'empty',
				'section'     => 'background_colors',
				'operator'    => 'and'
			),
			array(
				'id'          => 'top_bar_background',
				'label'       => __( 'Top bar background', 'PixelEmu' ),
				'desc'        => __( 'Choose the Topbar background color', 'PixelEmu' ),
				'std'         => '#F5F5F5',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'top_bar_text',
				'label'       => __( 'Top bar text', 'PixelEmu' ),
				'desc'        => __( 'Choose topbar text color', 'PixelEmu' ),
				'std'         => '#999999',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'menubar_color',
				'label'       => __( 'Menu and Logo bar', 'PixelEmu' ),
				'type'        => 'empty',
				'section'     => 'background_colors',
				'operator'    => 'and'
			),
			array(
				'id'          => 'menu_bar_background',
				'label'       => __( 'Bar background', 'PixelEmu' ),
				'desc'        => __( 'Menu and Logo bar background, colors for menu items may be changed at the menu configuration settings.', 'PixelEmu' ),
				'std'         => '#FFFFFF',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'header_color',
				'label'       => __( 'Header', 'PixelEmu' ),
				'type'        => 'empty',
				'section'     => 'background_colors',
				'operator'    => 'and'
			),
			array(
				'id'          => 'header_background',
				'label'       => __( 'Header background', 'PixelEmu' ),
				'desc'        => __( 'Choose the Header background color', 'PixelEmu' ),
				'std'         => '#f5f5f5',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'header_text',
				'label'       => __( 'Header text', 'PixelEmu' ),
				'desc'        => __( 'Choose the Header text color', 'PixelEmu' ),
				'std'         => '#8C8C8C',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'header_module_title',
				'label'       => __( 'Header widget title', 'PixelEmu' ),
				'desc'        => __( 'Choose Header widget title color', 'PixelEmu' ),
				'std'         => '#444444',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'offcanvas_color',
				'label'       => __( 'Off-Canvas', 'PixelEmu' ),
				'type'        => 'empty',
				'section'     => 'background_colors',
				'operator'    => 'and'
			),
			array(
				'id'          => 'offcanvas_icon',
				'label'       => __( 'Off-Canvas icon', 'PixelEmu' ),
				'desc'        => __( 'Choose the off-canvas icon color', 'PixelEmu' ),
				'std'         => '#2A2A2A',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'offcanvas_background',
				'label'       => __( 'Sidebar background', 'PixelEmu' ),
				'desc'        => __( 'Choose off-canvas sidebar background color', 'PixelEmu' ),
				'std'         => '#2A2A2A',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'offcanvas_text',
				'label'       => __( 'Sidebar text', 'PixelEmu' ),
				'desc'        => __( 'Choose off-canvas sidebar text color', 'PixelEmu' ),
				'std'         => '#C2C2C2',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'offcanvas_widget_title',
				'label'       => __( 'Sidebar widget title', 'PixelEmu' ),
				'desc'        => __( 'Choose off-canvas sidebar widget title color', 'PixelEmu' ),
				'std'         => '#FFFFFF',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'footer_color',
				'label'       => __( 'Footer', 'PixelEmu' ),
				'type'        => 'empty',
				'section'     => 'background_colors',
				'operator'    => 'and'
			),
			array(
				'id'          => 'footer_background',
				'label'       => __( 'Footer background', 'PixelEmu' ),
				'desc'        => __( 'Background for footer', 'PixelEmu' ),
				'std'         => '#2A2A2A',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'footer_text',
				'label'       => __( 'Footer text', 'PixelEmu' ),
				'desc'        => __( 'Color for footer text', 'PixelEmu' ),
				'std'         => '#717171',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'footer_widget_title',
				'label'       => __( 'Footer widget title', 'PixelEmu' ),
				'desc'        => __( 'Color for footer widget title', 'PixelEmu' ),
				'std'         => '#FFFFFF',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'widgets_color',
				'label'       => __( 'Widgets', 'PixelEmu' ),
				'type'        => 'empty',
				'section'     => 'background_colors',
				'operator'    => 'and'
			),
			array(
				'id'          => 'pe_light_background',
				'label'       => __( 'PE-Light background', 'PixelEmu' ),
				'desc'        => __( 'Background for widget with class "pe-light"', 'PixelEmu' ),
				'std'         => '#FFFFFF',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'pe_light_border',
				'label'       => __( 'PE-Light border', 'PixelEmu' ),
				'desc'        => __( 'Border for widget with class "pe-light"', 'PixelEmu' ),
				'std'         => '#F0F0F0',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'pe_light_text',
				'label'       => __( 'PE-Light text', 'PixelEmu' ),
				'desc'        => __( 'Text color for widget with class "pe-light"', 'PixelEmu' ),
				'std'         => '#8C8C8C',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'pe_light_widget_title',
				'label'       => __( 'PE-Light widget title', 'PixelEmu' ),
				'desc'        => __( 'Widget title color for widget with class "pe-light"', 'PixelEmu' ),
				'std'         => '#444444',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'pe_dark_background',
				'label'       => __( 'PE-Dark background', 'PixelEmu' ),
				'desc'        => __( 'Background for widget with class "pe-dark"', 'PixelEmu' ),
				'std'         => '#2A2A2A',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'pe_dark_text',
				'label'       => __( 'PE-Dark Text', 'PixelEmu' ),
				'desc'        => __( 'Text color for widget with class "pe-dark"', 'PixelEmu' ),
				'std'         => '#C2C2C2',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'pe_dark_widget_title',
				'label'       => __( 'PE-Dark Widget Title', 'PixelEmu' ),
				'desc'        => __( 'Widget title color for widget with class "pe-dark"', 'PixelEmu' ),
				'std'         => '#FFFFFF',
				'type'        => 'colorpicker',
				'section'     => 'background_colors',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'google_fonts',
				'label'       => __( 'Google Fonts', 'PixelEmu' ),
				'desc'        => __( 'The Google Fonts option type will dynamically enqueue any number of Google Web Fonts into the document HEAD.', 'PixelEmu' ),
				'std'         => array(
					array(
						'family'    => 'raleway',
						'variants'  => array( '300', 'regular', '500', '700' ),
					)
				),
				'type'        => 'google-fonts',
				'section'     => 'fonts',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'body_typography',
				'label'       => __( 'Body Typography', 'PixelEmu' ),
				'desc'        => __( 'Typography for BODY', 'PixelEmu' ),
				'std'         => array('font-color' => '#8C8C8C','font-family'     => 'raleway', 'font-size' => '14px','font-style'      => 'normal','font-weight' => '300','text-decoration' => 'none','text-transform'  => 'none'),
				'type'        => 'typography',
				'section'     => 'fonts',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'post_titles',
				'label'       => __( 'Post Titles', 'PixelEmu' ),
				'desc'        => __( 'Typography for post titles', 'PixelEmu' ),
				'std'         => array('font-color' => '#444444','font-family'     => 'raleway', 'font-size' => '24px','font-style' => 'normal','font-weight' => '300','text-decoration' => 'none','text-transform'  => 'uppercase'),
				'type'        => 'typography',
				'section'     => 'fonts',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'widgets_titles',
				'label'       => __( 'Widgets Titles', 'PixelEmu' ),
				'desc'        => __( 'Typography for widget titles', 'PixelEmu' ),
				'std'         => array('font-color' => '#444444','font-family'     => 'raleway', 'font-size' => '24px','font-style'      => 'normal','font-weight' => '500','text-decoration' => 'none','text-transform'  => 'uppercase'),
				'type'        => 'typography',
				'section'     => 'fonts',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'copyright_info',
				'label'       => __( 'Copyright Info', 'PixelEmu' ),
				'desc'        => __( 'Add text for copyright info at the bottom of the page.', 'PixelEmu' ),
				'std'         => 'PE Beauty Center All Rights Reserved.',
				'type'        => 'textarea-simple',
				'section'     => 'footer',
				'rows'        => '5',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'copyright_info_on_off',
				'label'       => '',
				'desc'        => __( 'Turn on or turn off copyright info.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'footer',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'pixelemu_copyright',
				'label'       => __( 'PixelEmu Copyright', 'PixelEmu' ),
				'desc'        => __( 'Turn on or turn off PixelEmu copyright.', 'PixelEmu' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'footer',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			/*array(
				'id'          => 'social_links',
				'label'       => __( 'Social links in the footer', 'PixelEmu' ),
				'desc'        => __( 'Enter social links and titles. They will be displayed in the PE Social Icons Widget.', 'PixelEmu' ),
				'std'         => '',
				'type'        => 'social-links',
				'section'     => 'footer',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),*/
			array(
				'id'          => 'custom_code',
				'label'       => __( 'Custom Code into The &lt;HEAD&gt; Section', 'PixelEmu' ),
				'desc'        => __( 'Add custom code into the head section if needed. Please put code inside script tags.', 'PixelEmu' ),
				'std'         => '',
				'type'        => 'textarea-simple',
				'section'     => 'advanced',
				'rows'        => '10',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'javascript_code',
				'label'       => __( 'Javascript Code Before The &lt;/BODY&gt; Tag', 'PixelEmu' ),
				'desc'        => __( 'This code will be inserted right before closing the BODY tag. Please put code inside script tags. Pas here Google Analytics Scripts, Google Re-marketing Tag, Google Webmaster Tools, etc.', 'PixelEmu' ),
				'std'         => '',
				'type'        => 'textarea-simple',
				'section'     => 'advanced',
				'rows'        => '10',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'google_analytics',
				'label'       => __( 'Google Analytics ID', 'PixelEmu' ),
				'desc'        => __( 'e.g. UA-XXXXX-Y or UA-XXXXX-YY', 'PixelEmu' ),
				'std'         => '',
				'type'        => 'text',
				'section'     => 'advanced',
				'rows'        => '10',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'google_webmaster',
				'label'       => __( 'Google Webmaster Tools Site Verification', 'PixelEmu' ),
				'desc'        => __( 'Please insert verification code for Webmaster tools in here', 'PixelEmu' ),
				'std'         => '',
				'type'        => 'text',
				'section'     => 'advanced',
				'rows'        => '10',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'addthis_code',
				'label'       => __( 'Addthis code', 'PixelEmu' ),
				'desc'        => __( 'Enter your Addthis Public ID to display social icons. You need to set up <strong>Sharing Buttons</strong> in your Addthis account. Recommended: small size.', 'PixelEmu' ),
				'std'         => '',
				'type'        => 'text',
				'section'     => 'advanced',
				'rows'        => '10',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'dynamic_css',
				'label'       => __( 'Dynamic CSS', 'PixelEmu' ),
				'desc'        => '<p>' . sprintf( __( 'The CSS option type is a textarea that when used properly can add dynamic CSS to your theme from within OptionTree. Unfortunately, due server limitations you will need to create a file named %s at the root level of your theme and change permissions using %s so the server can write to the file. I have had the most success setting this single file to %s but feel free to play around with permissions until everything is working. A good starting point is %s. When the server can save to the file, CSS will automatically be updated when you save your Theme Options.', 'PixelEmu' ), '<code>dynamic.css</code>', '<code>chmod</code>', '<code>0777</code>', '<code>0666</code>' ) . '</p>',
				'std'         => '/* main background */
#pe-main {
		background: {{page_background}};
}

/* Top bar */
#pe-top-bar {
		background: {{top_bar_background}};
		color: {{top_bar_text}};
}
#pe-top-bar .menu li:hover > a,
#pe-top-bar .menu li.current-menu-item > a {
		color: {{main_scheme_color|main}};
}
#pe-top-bar .menu li a {
		color: {{top_bar_text}};
}
#pe-top-bar .toggle-nav.menu {
	color: {{top_bar_text}};
}
#pe-top-bar .toggle-nav.menu:hover {
	color: {{main_scheme_color|main}};
}

/* Logo and main menu section*/
#pe-menu-bar {
	border-top: 1px solid {{base_border}};
	border-bottom: 1px solid {{base_border}};
	background: {{menu_bar_background}};
}
.pe-title-block.schema-bottom .pe-indicator::before, .pe-title-block.schema-top .pe-indicator::before{
	background-color: {{base_border}};
}
.pe-title-block.schema-bottom .active .pe-indicator::after, .pe-title-block.schema-top .active .pe-indicator::after{
	border-color: {{body_typography|font-color}};
}

/* Header */
#pe-header {
		background: {{header_background}};
	color: {{header_text}};
}
#pe-header .pe-module-in > h2,
#pe-header .pe-module-in > h3,
#pe-header .pe-module .pe-title {
	color: {{header_module_title}};
}
#pe-header .pe-module-in {
	color: {{header_text}};
}

/* Section colors */
#pe-top-in,
#pe-breadcrumbs-in,
#pe-content-in,
#pe-bottom-in {
		background: {{main_page_background}};
}

/* footer section */
#pe-footer {
	color: {{footer_text}};
	background: {{footer_background}};
	border-top: 6px solid {{main_scheme_color|main}};
}
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) .pe-module-in > h2,
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) .pe-module-in > h3,
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) .pe-title {
	color: {{footer_widget_title}};
}
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) .menu li:hover > a,
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) .menu li.current-menu-item > a {
	color: {{main_scheme_color|main}};
}
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) .menu li > a {
	color: {{footer_text}};
}
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) .pe-numbers .text,
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) .pe-testimonials .pe-custom-title a,
#pe-footer .PE_Recent_Posts:not(.pe-light):not(.pe-dark) .caption > h5 a,
#pe-footer .PE_Recent_Posts:not(.pe-light):not(.pe-dark).pe-popular .caption > h5 a,
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) .readmore {
		color: {{footer_widget_title}};
}
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) .pe-numbers .number {
	color: {{footer_background}};
}
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) .pe-numbers .number,
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) .readmore:after {
		background: {{footer_widget_title}};
}
#pe-footer .pe-classic:not(.pe-light):not(.pe-dark) .menu li a {
		color: {{footer_text}};
}
#pe-footer .pe-classic:not(.pe-light):not(.pe-dark) .menu li.current-menu-item a,
#pe-footer .pe-classic:not(.pe-light):not(.pe-dark) .menu li a:hover,
#pe-footer .pe-classic:not(.pe-light):not(.pe-dark) .menu li a:focus {
		color: {{main_scheme_color|main}};
}
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) h1,
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) h2,
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) h3,
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) h4,
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) h5,
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) h6 {
	color: {{footer_widget_title}};
}
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) h1 a:hover,
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) h2 a:hover,
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) h3 a:hover,
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) h4 a:hover,
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) h5 a:hover,
#pe-footer .pe-module:not(.pe-light):not(.pe-dark) h6 a:hover {
	color: {{main_scheme_color|main}};
}

/* Widgets */
.subheading-category,
.pe-module-in > h2,
.pe-module-in > h3,
.pe-module .pe-title {
		{{widgets_titles}};
}
.PE_Recent_Posts .caption > h5 a {
	font-size:  {{widgets_titles|font-size}};
	text-transform:  {{widgets_titles|text-transform}};
	color:  {{post_titles|font-color}};
	text-decoration:  {{widgets_titles|text-decoration}};
}
.PE_Recent_Posts.pe-popular .caption > h5 a:hover,
.PE_Recent_Posts .caption > h5 a:hover {
	color: {{main_scheme_color|main}};
}
.PE_Recent_Posts.pe-popular .caption > h5 a {
		font-size: {{body_typography|font-size}};
}
.pe-numbers .text,
.pe-avatar-box .title a,
.pe-testimonials .pe-custom-title a,
.PE_Recent_Posts.pe-popular .caption > h5 a {
	color: {{widgets_titles|font-color}};
}

.pe-numbers .number {
	background: {{widgets_titles|font-color}};
	color: {{main_page_background}};
}

/* PE-Dark */
.pe-module.pe-dark .pe-module-in {
	background: {{pe_dark_background}};
	color: {{pe_dark_text}};
}
.pe-module.pe-dark .pe-numbers .number {
	background: {{pe_dark_widget_title}};
	color: {{pe_dark_background}};
}
.pe-module.pe-dark .pe-module-in > h2,
.pe-module.pe-dark .pe-module-in > h3,
.pe-module.pe-dark .pe-title {
	color: {{pe_dark_widget_title}};
}
.pe-module.pe-dark .menu li:hover > a,
.pe-module.pe-dark .menu li.current-menu-item > a {
		color: {{main_scheme_color|main}};
}
.pe-module.pe-dark .menu li a {
		color: {{pe_dark_text}};
}
.pe-classic.pe-dark .menu li a {
		color: {{pe_dark_text}};
}
.pe-classic.pe-dark .menu li.current-menu-item a,
.pe-classic.pe-dark .menu li a:hover,
.pe-classic.pe-dark .menu li a:focus {
		color: {{main_scheme_color|main}};
}
.pe-module.pe-dark .pe-numbers .text,
.pe-module.pe-dark .pe-testimonials .pe-custom-title a,
.PE_Recent_Posts.pe-popular.pe-dark .caption > h5 a,
.pe-module.pe-dark .pe-avatar-box .title a,
.PE_Recent_Posts.pe-dark .caption > h5 a,
.pe-module.pe-dark .readmore {
		color: {{pe_dark_widget_title}};
}
.pe-module.pe-dark .readmore:after {
		background: {{pe_dark_widget_title}};
}
.pe-module.pe-dark h1,
.pe-module.pe-dark h2,
.pe-module.pe-dark h3,
.pe-module.pe-dark h4,
.pe-module.pe-dark h5,
.pe-module.pe-dark h6 {
	color: {{pe_dark_widget_title}};
}
.pe-module.pe-dark h1 a:hover,
.pe-module.pe-dark h2 a:hover,
.pe-module.pe-dark h3 a:hover,
.pe-module.pe-dark h4 a:hover,
.pe-module.pe-dark h5 a:hover,
.pe-module.pe-dark h6 a:hover {
	color: {{main_scheme_color|main}};
}

/* PE-Light */
.pe-module.pe-light .pe-module-in {
	background: {{pe_light_background}};
	border: 1px solid {{pe_light_border}};
	color: {{pe_light_text}};
}
.pe-module.pe-light .pe-numbers .number {
	background: {{pe_light_widget_title}};
	color: {{pe_light_background}};
}
.pe-module.pe-light .menu li:hover > a,
.pe-module.pe-light .menu li.current-menu-item > a {
		color: {{main_scheme_color|main}};
}
.pe-module.pe-light .menu li a {
		color: {{pe_light_text}};
}
.pe-classic.pe-light .menu li a {
		color: {{pe_light_text}};
}
.pe-classic.pe-light .menu li.current-menu-item a,
.pe-classic.pe-light .menu li a:hover,
.pe-classic.pe-light .menu li a:focus {
		color: {{main_scheme_color|main}};
}
.pe-module.pe-light .pe-numbers .text,
.pe-module.pe-light .pe-testimonials .pe-custom-title a,
.PE_Recent_Posts.pe-popular.pe-light .caption > h5 a,
.pe-module.pe-light .readmore,
.PE_Recent_Posts.pe-light .caption > h5 a,
.pe-module.pe-light .pe-avatar-box .title a,
.pe-module.pe-light .pe-module-in > h2,
.pe-module.pe-light .pe-module-in > h3,
.pe-module.pe-light .pe-title {
	color: {{pe_light_widget_title}};
}
.pe-module.pe-dark .readmore:after {
		background: {{pe_light_widget_title}};
}
.pe-module.pe-light h1,
.pe-module.pe-light h2,
.pe-module.pe-light h3,
.pe-module.pe-light h4,
.pe-module.pe-light h5,
.pe-module.pe-light h6 {
	color: {{pe_dark_widget_title}};
}
.pe-module.pe-light h1 a:hover,
.pe-module.pe-light h2 a:hover,
.pe-module.pe-light h3 a:hover,
.pe-module.pe-light h4 a:hover,
.pe-module.pe-light h5 a:hover,
.pe-module.pe-light h6 a:hover {
	color: {{main_scheme_color|main}};
}

/* Mega menu overrides */
#pe-main-menu.navbar #mega-menu-wrap-main-menu #mega-menu-main-menu > li.mega-current-menu-ancestor > a:before,
#pe-main-menu.navbar #mega-menu-wrap-main-menu #mega-menu-main-menu > li.mega-current-menu-item > a:before,
#pe-main-menu.navbar #mega-menu-wrap-main-menu #mega-menu-main-menu > li:hover > a:before {
		background: {{main_scheme_color|main}};
}
.mega-current-menu-item > a,
#pe-main-menu.navbar #mega-menu-wrap-main-menu #mega-menu-main-menu a:hover {
		color: {{main_scheme_color|main}} !important;
}
#mega-menu-wrap-main-menu .mega-menu-toggle{
	color: {{body_typography|font-color}};
}

/* back top top */
#pe-back-top a {
		color: {{footer_text}};
}

/* Typo */
/* Post and Page title */
.page-header > h1 a,
.page-header > h1,
.page-header > h2 a,
.page-header > h2 {
		{{post_titles}};
}
.page-header .pe-services-title {
	{{widgets_titles}}
}
.page-header > h2 a:hover {
		color: {{main_scheme_color|main}};
}
.contact-header,
.pe-error-page > h1,
.pe-error-page > h2 {
		color: {{post_titles|font-color}};
}
.pe-block span {
		font-size: {{body_typography|font-size}};
}

/* readmore button */
.readmore {
		font-size: {{body_typography|font-size}};
		color: {{post_titles|font-color}};
}
.readmore:after {
		background: {{post_titles|font-color}};
}
.readmore:before {
		background: {{main_scheme_color|main}};
}
.readmore:focus,
.readmore:hover {
		color: {{main_scheme_color|main}}!important;
}
.readmore:focus:after,
.readmore:hover:after {
		background: {{main_scheme_color|main}};
}

/* Author Info */
.comment-reply-title,
.comments-title,
.pe-author-info .pe-title {
		{{widgets_titles}};
}
.pe-author-name .name {
		color: {{widgets_titles|font-color}};
}

/* Tags */
.pe-post-tags {
		border-top: 1px solid {{base_border}};
}
.pe-post-tags .title {
		font-size: {{body_typography|font-size}};
}

/* Default WordPress menu */
.menu li a {
		font-size: {{body_typography|font-size}};
		color: {{body_typography|font-color}};
}
.menu li a:hover,
.menu li a:focus,
.menu li.current-menu-item > a,
.menu li.current-menu-parent > a{
		color: {{main_scheme_color|main}};
}
.menu .sub-menu > li:hover:after,
.menu .sub-menu > li.current-menu-item:after {
	color: {{main_scheme_color|main}};
}
/* Classis Menu */
.pe-classic .menu li.current-menu-item a {
		color: {{main_scheme_color|main}};
}

/* PE Easy Slider */
#pe-main .pe-easy-slider-title-readmore .pe-easy-slider-readmore:hover,
#pe-main .pe-easy-slider-title-readmore .post-title:hover {
	color: {{main_scheme_color|main}};
}

/* Testimonial Carousel */
.pe-testimonials .pe-custom-subtitle {
	color: {{main_scheme_color|main}};
}

/* PE Team */
.pe-meet-our-team .text,
.pe-meet-our-team .subtitle,
.pe-meet-our-team .title {
		font-size: {{body_typography|font-size}};
}

/* Light Box */
.pe-light-box a {
	background: {{pe_light_background}};
}
.pe-light-box .description {
	border: 1px solid {{pe_light_border}};
}
.pe-light-box .box-title,
.pe-dark-box .box-title {
		font-size:  {{widgets_titles|font-size}};
}
.pe-light-box .title,
.pe-light-box .subtitle {
	color: {{pe_light_widget_title}};
}
.pe-light-box .text,
.pe-light-box .price {
	color: {{pe_light_text}};
}
.pe-light-box .image:after {
	background: {{main_scheme_color|main}};
}

/* Dark Box */
.pe-dark-box {
	border: 1px solid {{base_border}};
}

.pe-dark-box a {
	background: {{pe_dark_background}};
}
.pe-dark-box .title,
.pe-dark-box .subtitle {
	color: {{pe_dark_widget_title}};
}
.pe-dark-box .text,
.pe-dark-box .price {
	color: {{pe_dark_text}};
}
.pe-dark-box .image:after {
	background: {{main_scheme_color|main}};
}

/* PE Testimonials */
.pe-testimonials .pe-custom-text {
	background: {{main_page_background}};
	border: 1px solid {{base_border}};
	color: {{body_typography|font-color}};
}
.pe-testimonials .pe-custom-text:after {
	background: {{main_page_background}};
	border: 1px solid {{base_border}};
	border-left: none;
	border-top: none;
}

/* Quotes */
blockquote,
.quote-left,
.quote-right {
	border: 1px solid {{base_border}};
}


/* Price Table */
#pe-main table.pricing td.price {
	color: {{main_scheme_color|main}};
}
#pe-main table.pricing th,
#pe-main table.pricing td {
		font-size: {{body_typography|font-size}};
}

/* Social Icons */
.pe-socials a:hover,
.pe-social-icons a:hover,
.pe-avatar-item .social .facebook:hover,
.pe-avatar-item .social .twitter:hover,
.pe-avatar-item .social .link:hover,
.pe-meet-our-team .social .facebook:hover,
.pe-meet-our-team .social .twitter:hover,
.pe-meet-our-team .social .link:hover {
	background-color: {{main_scheme_color|main}};
}

/* Indicators */
#pe-team-carousel .carousel-indicators li,
#pe-testimonial-carousel .carousel-indicators li {
	background-color: {{main_scheme_color|main}};
}

/* Services */
#pe-services-carousel .pe-services-title {
	{{widgets_titles}};
}
.pe-title-block .active .pe-indicator-name,
.pe-title-block .pe-indicator:hover .pe-indicator-name {
	color: {{widgets_titles|font-color}};
}
.pe-title-block .pe-indicator-name {
	color: {{main_scheme_color|main}};
}
.pe-title-block.schema-bottom .active .pe-indicator:after,
.pe-title-block.schema-top .active .pe-indicator:after {
	background: {{main_page_background}};
}

/* Offcanvas */
#pe-offcanvas {
	width: {{offcanvas_width}}px;
}
.off-canvas-right.off-canvas #pe-main {
	margin-left: -{{offcanvas_width}}px;
	margin-right: {{offcanvas_width}}px;
}
.off-canvas-left.off-canvas #pe-main {
	margin-right: -{{offcanvas_width}}px;
	margin-left: {{offcanvas_width}}px;
}
.off-canvas-right #pe-offcanvas {
	right: -{{offcanvas_width}}px;
}
.off-canvas-left #pe-offcanvas {
	left: -{{offcanvas_width}}px;
}
#pe-offcanvas {
	color: {{offcanvas_text}};
	background: {{offcanvas_background}};
}
.toggle-nav.menu {
	color: {{offcanvas_icon}};
}
.toggle-nav.menu:hover {
	color: {{main_scheme_color|main}};
}
.toggle-nav.close-menu {
	color: {{offcanvas_widget_title}};
}
#pe-offcanvas-content .pe-module:not(.pe-light):not(.pe-dark) {
	color: {{offcanvas_text}};
}
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) .pe-module-in > h2,
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) .pe-module-in > h3,
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) .pe-title {
	color: {{offcanvas_widget_title}};
}
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) .menu li:hover > a,
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) .menu li.current-menu-item > a {
		color: {{main_scheme_color|main}};
}
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) .menu li a {
	color: {{offcanvas_text}};
}
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) .pe-numbers .text,
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) .pe-testimonials .pe-custom-title a,
#pe-offcanvas .PE_Recent_Posts:not(.pe-light):not(.pe-dark) .caption > h5 a,
#pe-offcanvas .PE_Recent_Posts:not(.pe-light):not(.pe-dark).pe-popular .caption > h5 a,
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) .readmore {
		color: {{offcanvas_widget_title}};
}
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) .pe-numbers .number {
	color: {{offcanvas_background}};
}
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) .pe-numbers .number,
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) .readmore:after {
		background: {{offcanvas_widget_title}};
}
#pe-offcanvas .pe-classic:not(.pe-light):not(.pe-dark) .menu li a {
		color: {{offcanvas_text}};
}
#pe-offcanvas .pe-classic:not(.pe-light):not(.pe-dark) .menu li.current-menu-item a,
#pe-offcanvas .pe-classic:not(.pe-light):not(.pe-dark) .menu li a:hover,
#pe-offcanvas .pe-classic:not(.pe-light):not(.pe-dark) .menu li a:focus {
		color: {{main_scheme_color|main}};
}
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) h1,
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) h2,
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) h3,
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) h4,
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) h5,
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) h6 {
	color: {{offcanvas_widget_title}};
}
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) h1 a:hover,
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) h2 a:hover,
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) h3 a:hover,
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) h4 a:hover,
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) h5 a:hover,
#pe-offcanvas .pe-module:not(.pe-light):not(.pe-dark) h6 a:hover {
	color: {{main_scheme_color|main}};
}

/* Bootstrap Override */
/* Container Width */
body {
	{{body_typography}};
	background-color: {{footer_background}};
}
.container-fluid  {
		max-width: {{theme_width}};
}
a,
a:hover,
a:active,
a:focus {
	color: {{main_scheme_color|main}};
}

::selection,
::-webkit-selection,
::-moz-selection {
	background: {{main_scheme_color|main}};
}
#pe-main table thead tr th {
	background: {{main_scheme_color|main}};
}
#pe-main table td {
	border-bottom: 1px solid {{base_border}};
	border-right: 1px solid {{base_border}};
}

#pe-main table td:first-child {
	border-left: 1px solid {{base_border}};
}
.form-control {
	border: 1px solid {{base_border}};
}
.form-control:focus {
	border-color: {{main_scheme_color|main}};
}
.label-info {
		background: {{main_scheme_color|main}};
}
.label-info[href]:focus,
.label-info[href]:hover {
		background: {{main_scheme_color|darken}};
}
.pe-module input[type="search"]{
	font-size: {{body_typography|font-size}};
}
.btn,
a.button,
input.button,
button.button,
input[type="submit"] {
	background: {{main_scheme_color|main}};
	font-size: {{body_typography|font-size}};
}
.btn:hover,
a.button:hover,
input.button:hover,
button.button:hover,
input[type="submit"]:hover {
		background: {{main_scheme_color|darken}};
}
.btn2,
.btn3,
.btn4 {
		font-size: {{body_typography|font-size}};
}
.btn2,
.btn4 {
	color: {{widgets_titles|font-color}} !important;
}
.pe-dark .btn2,
.pe-dark .btn4 {
	color: {{pe_dark_widget_title}};
}
#pe-footer .btn2,
#pe-footer .btn4 {
	color: {{footer_widget_title}};
}
#pe-offcanvas .btn2,
.pe-offcanvas .btn4 {
	color: {{offcanvas_widget_title}};
}
.btn2 {
	border: 2px solid {{main_scheme_color|main}};
}
.btn2:hover {
	background: {{main_scheme_color|main}};
}
.btn3 {
	background: {{widgets_titles|font-color}};
}
.pe-dark .btn3 {
	background: {{pe_dark_widget_title}};
	color: {{pe_dark_background}};
}
.pe-light .btn3 {
	background: {{pe_light_widget_title}};
	color: {{pe_light_background}};
}
#pe-footer .btn3 {
	background: {{footer_widget_title}};
	color: {{footer_background}};
}
.pe-offcanvas .btn3 {
	background: {{offcanvas_widget_title}};
	color: {{offcanvas_background}};
}
.btn3:hover {
	background: #515151;
}
.btn4 {
	border: 2px solid {{widgets_titles|font-color}};
}
.btn4:hover {
	color: #ffffff !important;
	background: {{widgets_titles|font-color}};
}
.pe-dark .btn4 {
	border: 2px solid {{pe_dark_widget_title}};
}
.pe-dark .btn4:hover {
	color: {{pe_dark_background}}; !important;
	background: {{pe_dark_widget_title}};
}
.pe-light .btn4 {
	border: 2px solid {{pe_light_widget_title}};
}
.pe-light .btn4:hover {
	color: {{pe_light_background}}; !important;
	background: {{pe_light_widget_title}};
}
#pe-footer .btn4 {
	border: 2px solid {{footer_widget_title}};
}
#pe-footer .btn4:hover {
	color: {{footer_background}}; !important;
	background: {{footer_widget_title}};
}
#pe-offcanvas .btn4 {
	border: 2px solid {{offcanvas_widget_title}};
}
#pe-offcanvas .btn4:hover {
	color: {{offcanvas_background}}; !important;
	background: {{offcanvas_widget_title}};
}

.nav-stacked > li > a:hover {
	color: {{main_scheme_color|main}};
}
.navbar-toggle {
	background-color: {{base_border}};
	border: 1px solid {{base_border}};
}
.navbar-toggle .icon-bar {
	background-color: {{body_typography|font-color}};
}
.nav-tabs > li > a
.nav-tabs>li.active>a,
.nav-tabs>li.active>a:focus,
.nav-tabs>li.active>a:hover {
	color: {{body_typography|font-color}};
}
.panel-group .panel.pe-panel {
	border: 1px solid {{base_border}};
}
.panel-group .panel.pe-panel .panel-title a {
	color: {{body_typography|font-color}};
}
.panel-group .panel.pe-panel .panel-title a {
		font-size: {{body_typography|font-size}};
}
.pagination > li > a,
.pagination > li > span {
		font-size: {{body_typography|font-size}};
}
.ch-item.ch-first .ch-info,
.ch-item.ch-second .ch-info .ch-info-back,
.ch-item.ch-third .ch-info .ch-info-back {
		background: {{main_scheme_color|main}};
}
.form-control {
		font-size: {{body_typography|font-size}};
		color: {{body_typography|font-color}};
}
ul:not([class]) li:after,
#pe-services-carousel .pe-services-item-desc ul li::before {
		color: {{main_scheme_color|main}};
}

/* Bootstrap Menu */
#bs-pe-navbar-collapse-1 .nav > li > a,
#bs-pe-navbar-collapse-1 .navbar-nav > li > .dropdown-menu > li > a {
		color: {{top_bar_text}};
}
#bs-pe-navbar-collapse-1 .nav > li > a:after {
		background: {{base_border}};
}
#bs-pe-navbar-collapse-1 .navbar-nav > li > .dropdown-menu {
		border: 1px solid {{base_border}};
}
#bs-pe-navbar-collapse-1 .nav > li > a:hover,
#bs-pe-navbar-collapse-1 .nav > li > a:focus,
#bs-pe-navbar-collapse-1 .nav > li.active > a,
#bs-pe-navbar-collapse-1 .nav > li:hover > a,
#bs-pe-navbar-collapse-1 .nav .open > a,
#bs-pe-navbar-collapse-1 .nav .open > a:hover,
#bs-pe-navbar-collapse-1 .nav .open > a:focus,
#bs-pe-navbar-collapse-1 .navbar-nav > li > .dropdown-menu > li > a:hover,
#bs-pe-navbar-collapse-1 .navbar-nav > li > .dropdown-menu > li > a:focus,
#bs-pe-navbar-collapse-1 .navbar-nav > li > .dropdown-menu > li.active > a {
	color: {{main_scheme_color|main}};
}
#bs-pe-navbar-collapse-1 .nav > li.active:after,
#bs-pe-navbar-collapse-1 .nav > li:hover:after {
		background: {{main_scheme_color|main}};
}
/* Revolution Slider */
.rev_slider_wrapper .custom .tp-bullet,
.rev_slider_wrapper .custom .tp-bullet.selected {
		background-color: {{main_scheme_color|main}};
}
.metis.tparrows:before {
		color: {{main_scheme_color|main}};
}

/* Responsive */
@media (max-width: 767px) {
		#bs-pe-navbar-collapse-1 .nav > li {
				border-bottom: 1px solid {{base_border}};
		}
		#bs-pe-navbar-collapse-1 .nav > li > .dropdown-menu {
				border: none;
		border-top: 1px solid {{base_border}};
		}
}',
				'type'        => 'css',
				'section'     => 'theme_css',
				'rows'        => '40',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
		        'id'          => 'check_updates',
		        'label'       => __( 'Check for updates', 'PixelEmu' ),
		        'desc'        => __( 'Check for theme updates', 'PixelEmu' ),
		        'std'         => 'on',
		        'type'        => 'on-off',
		        'section'     => 'advanced',
		        'rows'        => '',
		        'post_type'   => '',
		        'taxonomy'    => '',
		        'min_max_step'=> '',
		        'class'       => '',
		        'condition'   => '',
		        'operator'    => 'and'
		      )
		)
	);

	/* allow settings to be filtered before saving */
	$custom_settings = apply_filters( ot_settings_id() . '_args', $custom_settings );

	/* settings are not the same update the DB */
	if ( $saved_settings !== $custom_settings ) {
		update_option( ot_settings_id(), $custom_settings );
	}

	/* Lets OptionTree know the UI Builder is being overridden */
	global $ot_has_custom_theme_options;
	$ot_has_custom_theme_options = true;

	//show only px and % on theme width
	function new_measurement_units($field_id = '') {

		$newFields['px'] = 'px';
		$newFields['%'] = '%';

		return $newFields;
	}

	add_filter( 'ot_measurement_unit_types', 'new_measurement_units' );

	// show only selected social links - BEGIN
	function new_socials($args) {

			foreach ($args as $social) {
					if ( $social['name'] == __( 'Facebook', 'PixelEmu' )
						|| $social['name'] == __( 'Google+', 'PixelEmu' )
						|| $social['name'] == __( 'Twitter', 'PixelEmu' )
						|| $social['name'] == __( 'Skype', 'PixelEmu' )
						|| $social['name'] == __( 'Pinterest', 'PixelEmu' )
						|| $social['name'] == __( 'Vimeo', 'PixelEmu' )
						|| $social['name'] == __( 'LinkedIn', 'PixelEmu' )
					) $newArgs[] = $social;
			}
			return $newArgs;
	}

	add_filter( 'ot_type_social_links_defaults', 'new_socials' );
	// show only selected social links - END

	// hide ADD NEW button for social links - BEGIN
	function disable_optiontree_button() {
	echo '
	<style type="text/css">
	a.option-tree-social-links-add,
	.type-social-list-item .list-item-description {
			display:none !important;
	}
	</style>';
	}
	add_action('admin_head', 'disable_optiontree_button');
	// hide ADD NEW button for social links - END
}
