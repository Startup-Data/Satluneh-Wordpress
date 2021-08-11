<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
Website: http://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Theme Mode
/*-----------------------------------------------------------------------------------*/

add_filter( 'ot_theme_mode', '__return_true' );

/*-----------------------------------------------------------------------------------*/
/*	Child Theme Mode
/*-----------------------------------------------------------------------------------*/

add_filter( 'ot_child_theme_mode', '__return_false' );

/*-----------------------------------------------------------------------------------*/
/*	Hide Settings Page
/*-----------------------------------------------------------------------------------*/

add_filter( 'ot_show_pages', '__return_false' );

/*-----------------------------------------------------------------------------------*/
/*	Show Theme Options UI Builder
/*-----------------------------------------------------------------------------------*/

add_filter( 'ot_show_options_ui', '__return_false' );

/*-----------------------------------------------------------------------------------*/
/*	Show Settings Import
/*-----------------------------------------------------------------------------------*/

add_filter( 'ot_show_settings_import', '__return_false' );

/*-----------------------------------------------------------------------------------*/
/*	Show Settings Export
/*-----------------------------------------------------------------------------------*/

add_filter( 'ot_show_settings_export', '__return_false' );

/*-----------------------------------------------------------------------------------*/
/*	Hide New Layout
/*-----------------------------------------------------------------------------------*/

add_filter( 'ot_show_new_layout', '__return_false' );

/*-----------------------------------------------------------------------------------*/
/*	Hide Documentation
/*-----------------------------------------------------------------------------------*/

add_filter( 'ot_show_docs', '__return_false' );

/*-----------------------------------------------------------------------------------*/
/*	Custom Theme Option page
/*-----------------------------------------------------------------------------------*/

add_filter( 'ot_use_theme_options', '__return_false' );

/*-----------------------------------------------------------------------------------*/
/*	Allow Unfiltered HTML in textareas options
/*-----------------------------------------------------------------------------------*/

add_filter( 'ot_allow_unfiltered_html', '__return_false' );

/*-----------------------------------------------------------------------------------*/
/*	Meta Boxes
/*-----------------------------------------------------------------------------------*/

add_filter( 'ot_meta_boxes', '__return_true' );

/*-----------------------------------------------------------------------------------*/
/*	Loads the meta boxes for post formats
/*-----------------------------------------------------------------------------------*/

add_filter( 'ot_post_formats', '__return_true' );

/*-----------------------------------------------------------------------------------*/
/*	OptionTree in Theme Mode
/*-----------------------------------------------------------------------------------*/

require( trailingslashit( get_template_directory() ) . 'inc/option-tree/ot-loader.php' );

/*-----------------------------------------------------------------------------------*/
/*	Custom fields
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Add empty Option Type to theme options used for separator
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'ot_type_empty' ) ) {
	function ot_type_empty( $args = array() ) {
		/* turns arguments array into variables */
		extract( $args );
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Add Option for Opening Hours on Theme Option
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'ot_type_opening_hours' ) ) {
	function ot_type_opening_hours( $args = array() ) {
		/* turns arguments array into variables */
		extract( $args );

		/* verify a description */
		$has_desc = $field_desc ? true : false;
		/* format setting outer wrapper */
		echo '<div class="format-setting type-opening_hours ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
		/* description */
		echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
		/* format setting inner wrapper */
		echo '<div class="format-setting-inner">';

		/* build fields */
		foreach ( $field_std as $key => $value ) {

			if ( array_key_exists( $key, $field_std ) ) {
				echo '<div class="option-tree-ui-opening-hours-input-wrap">';
				echo '<label for="' . esc_attr( $field_id ) . '-' . $type . '" class="option-tree-ui-opening-hours-label">' . esc_attr( $value['label'] ) . '</label>';

				/* set color */

				$from_field = $value['id'] . '-from';
				$to_field   = $value['id'] . '-to';

				$from_value = isset( $field_value[ $from_field ] ) ? esc_attr( $field_value[ $from_field ] ) : '';
				$to_value   = isset( $field_value[ $to_field ] ) ? esc_attr( $field_value[ $to_field ] ) : '';
				echo '<div class="clearfix">';
				echo '<div class="row-from"><p>' . esc_html__( 'From:', 'pe-terraclassic' ) . '</p><input type="text" name="' . esc_attr( $field_name ) . '[' . $from_field . ']" id="' . esc_attr( $from_field ) . '" value="' . $from_value . '" class="widefat option-tree-ui-input"	/></div>';
				echo '<div class="row-to"><p>' . esc_html__( 'To:', 'pe-terraclassic' ) . '</p><input type="text" name="' . esc_attr( $field_name ) . '[' . $to_field . ']" id="' . esc_attr( $to_field ) . '" value="' . $to_value . '" class="widefat option-tree-ui-input"	/></div>';
				echo '</div>';
				echo '</div>';
			}
		}
		echo '</div></div>';
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Register the new options
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'pe_new_option_types' ) ) {
	function pe_new_option_types( $types ) {
		$types['empty']         = 'Empty';
		$types['opening_hours'] = PEsettings::$default['member-opening-hours-label'];

		return $types;
	}
}
add_filter( 'ot_option_types_array', 'pe_new_option_types' );


/*-----------------------------------------------------------------------------------*/
/*	Meta Boxes
/*-----------------------------------------------------------------------------------*/

/**
 * Initialize the custom Meta Boxes.
 */
add_action( 'admin_init', 'custom_meta_boxes' );

if ( ! function_exists( 'custom_meta_boxes' ) ) {
	function custom_meta_boxes() {

		/* Members */

		$PE_Members_Meta_Box = array(
			'id'       => 'member_meta_box',
			'title'    => esc_html__( 'Provide member info', 'pe-terraclassic' ),
			'pages'    => array( 'member' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(

				array(
					'label' => esc_html__( 'Proffesion', 'pe-terraclassic' ),
					'id'    => 'member_profession',
					'std'   => '',
					'type'  => 'text',
					'desc'  => esc_html__( 'Provide member profession.', 'pe-terraclassic' )
				),
				array(
					'label' => esc_html__( 'Phone', 'pe-terraclassic' ),
					'id'    => 'member_phone',
					'std'   => '',
					'type'  => 'text',
					'desc'  => esc_html__( 'Provide member phone number, it will be displayed on his/her profile.', 'pe-terraclassic' )
				),
				array(
					'label' => esc_html__( 'Email', 'pe-terraclassic' ),
					'id'    => 'member_email',
					'std'   => '',
					'type'  => 'text',
					'desc'  => esc_html__( 'Provide member email address, it will be displayed on his profile.', 'pe-terraclassic' )
				),

				array(
					'label' => esc_html__( 'Facebook', 'pe-terraclassic' ),
					'id'    => 'member_facebook',
					'std'   => '',
					'type'  => 'text',
					'desc'  => esc_html__( 'Provide member Facebook profile link.', 'pe-terraclassic' )
				),
				array(
					'label' => esc_html__( 'Twitter', 'pe-terraclassic' ),
					'id'    => 'member_twitter',
					'std'   => '',
					'type'  => 'text',
					'desc'  => esc_html__( 'Provide member Twitter profile link.', 'pe-terraclassic' )
				),
				array(
					'label' => esc_html__( 'Google Plus', 'pe-terraclassic' ),
					'id'    => 'member_google',
					'std'   => '',
					'type'  => 'text',
					'desc'  => esc_html__( 'Provide member Google Plus profile link.', 'pe-terraclassic' )
				),
				array(
					'label' => esc_html__( 'LinkedIn', 'pe-terraclassic' ),
					'id'    => 'member_li',
					'std'   => '',
					'type'  => 'text',
					'desc'  => esc_html__( 'Provide member LinkedIn profile link.', 'pe-terraclassic' )
				),
				array(
					'label' => esc_html__( 'Pinterest', 'pe-terraclassic' ),
					'id'    => 'member_pinterest',
					'std'   => '',
					'type'  => 'text',
					'desc'  => esc_html__( 'Provide member Pinterest profile link.', 'pe-terraclassic' )
				),
				array(
					'label' => esc_html__( 'Skype', 'pe-terraclassic' ),
					'id'    => 'member_skype',
					'std'   => '',
					'type'  => 'text',
					'desc'  => esc_html__( 'Provide member Skype profile link.', 'pe-terraclassic' )
				),
				array(
					'label' => esc_html__( 'Youtube', 'pe-terraclassic' ),
					'id'    => 'member_youtube',
					'std'   => '',
					'type'  => 'text',
					'desc'  => esc_html__( 'Provide member Youtube profile link.', 'pe-terraclassic' )
				),
				array(
					'label' => esc_html__( 'Vimeo', 'pe-terraclassic' ),
					'id'    => 'member_vimeo',
					'std'   => '',
					'type'  => 'text',
					'desc'  => esc_html__( 'Provide member Vimeo profile link.', 'pe-terraclassic' )
				),
				array(
					'label' => esc_html__( 'RSS', 'pe-terraclassic' ),
					'id'    => 'member_rss',
					'std'   => '',
					'type'  => 'text',
					'desc'  => esc_html__( 'Provide member RSS link.', 'pe-terraclassic' )
				),

				//opening hours
				array(
					'id'    => 'opening_hours',
					'label' => PEsettings::$default['member-opening-hours-label'],
					'desc'  => esc_html__( 'Provide member working hours, it will be displayed in his profile.', 'pe-terraclassic' ),
					'type'  => 'opening_hours',
					'std'   => array(
						array(
							'label' => esc_html__( 'Monday', 'pe-terraclassic' ),
							'id'    => 'monday',
							'std'   => array( 'from' => '', 'to' => '' )
						),
						array(
							'label' => esc_html__( 'Tuesday', 'pe-terraclassic' ),
							'id'    => 'tuesday',
							'std'   => array( 'from' => '', 'to' => '' )
						),
						array(
							'label' => esc_html__( 'Wednesday', 'pe-terraclassic' ),
							'id'    => 'wednesday',
							'std'   => array( 'from' => '', 'to' => '' )
						),
						array(
							'label' => esc_html__( 'Thursday', 'pe-terraclassic' ),
							'id'    => 'thursday',
							'std'   => array( 'from' => '', 'to' => '' )
						),
						array(
							'label' => esc_html__( 'Friday', 'pe-terraclassic' ),
							'id'    => 'friday',
							'std'   => array( 'from' => '', 'to' => '' )
						),
						array(
							'label' => esc_html__( 'Saturday', 'pe-terraclassic' ),
							'id'    => 'saturday',
							'std'   => array( 'from' => '', 'to' => '' )
						),
						array(
							'label' => esc_html__( 'Sunday', 'pe-terraclassic' ),
							'id'    => 'sunday',
							'std'   => array( 'from' => '', 'to' => '' )
						)
					)
				),

				//color
				array(
					'id'    => 'member_color',
					'label' => esc_html__( 'Member color', 'pe-terraclassic' ),
					'desc'  => esc_html__( 'Set the ovelay color on the image or ignore.', 'pe-terraclassic' ),
					'std'   => '',
					'type'  => 'colorpicker-opacity',
				),
			)
		);

		if ( function_exists( 'ot_register_meta_box' ) ) {
			ot_register_meta_box( $PE_Members_Meta_Box );
		}

		/* TESTIMONIALS */

		$PE_Testimonial_Meta_Box = array(
			'id'       => 'testimonial_meta_box',
			'title'    => __( 'Provide testimonial info used for widgets', 'pe-terraclassic' ),
			'desc'     => '',
			'pages'    => array( 'testimonial' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(
				array(
					'label' => __( 'Profession', 'pe-terraclassic' ),
					'id'    => 'testimonial_occupation',
					'std'   => '',
					'type'  => 'text',
					'desc'  => __( 'Please provide testimonial occupation or company.', 'pe-terraclassic' )
				)
			)
		);

		if ( function_exists( 'ot_register_meta_box' ) ) {
			ot_register_meta_box( $PE_Testimonial_Meta_Box );
		}

	}
}
