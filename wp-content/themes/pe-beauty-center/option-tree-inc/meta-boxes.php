<?php
/**
* Initialize the custom Meta Boxes. 
*/
add_action( 'admin_init', 'custom_meta_boxes' );

/**
* Meta Boxes demo code.
*
* You can find all the available option types in theme-options.php.
*
* @return    void
* @since     2.3.0
*/

function custom_meta_boxes() {

    /**
    * Create a custom meta boxes array that we pass to 
    * the OptionTree Meta Box API Class.
    */
    $PE_Members_Meta_Box = array(
        'id'          => 'member_meta_box',
        'title'       => __( 'Provide member info used for widgets', 'PixelEmu' ),
        'desc'        => '',
        'pages'       => array( 'member' ),
        'context'     => 'normal',
        'priority'    => 'high',
        'fields'      => array(
            array(
                'label'       => __( 'Position', 'PixelEmu' ),
                'id'          => 'member_position',
                'std'         => 'CEO',
                'type'        => 'text',
                'desc'        => __( 'Please provide member job position.', 'PixelEmu' )
            ),
            array(
                'label'       => __( 'Facebook', 'PixelEmu' ),
                'id'          => 'member_fb',
                'std'         => '',
                'type'        => 'text',
                'desc'        => __( 'Please provide members Facebook profile link.', 'PixelEmu' )
            ),
            array(
                'label'       => __( 'Twitter', 'PixelEmu' ),
                'id'          => 'member_tw',
                'std'         => '',
                'type'        => 'text',
                'desc'        => __( 'Please provide members Twitter profile link.', 'PixelEmu' )
            ),
            array(
                'label'       => __( 'LinkedIn', 'PixelEmu' ),
                'id'          => 'member_li',
                'std'         => '',
                'type'        => 'text',
                'desc'        => __( 'Please provide members LinkedIn profile link.', 'PixelEmu' )
            ),
            array(
                'label'       => __( 'Phone', 'PixelEmu' ),
                'id'          => 'member_phone',
                'std'         => '',
                'type'        => 'text',
                'desc'        => __( 'Please provide member phone number, it will be displayed on his/her profile.', 'PixelEmu' )
            ),
            array(
                'label'       => __( 'Email', 'PixelEmu' ),
                'id'          => 'member_email',
                'std'         => '',
                'type'        => 'text',
                'desc'        => __( 'Please provide member email address, it will be displayed on his profile.', 'PixelEmu' )
            )
        )
    );

    if ( function_exists( 'ot_register_meta_box' ) )
    ot_register_meta_box( $PE_Members_Meta_Box );


    $PE_Testimonial_Meta_Box = array(
        'id'          => 'testimonial_meta_box',
        'title'       => __( 'Provide testimonial info used for widgets', 'PixelEmu' ),
        'desc'        => '',
        'pages'       => array( 'testimonial' ),
        'context'     => 'normal',
        'priority'    => 'high',
        'fields'      => array(
            array(
                'label'       => __( 'Occupation', 'PixelEmu' ),
                'id'          => 'testimonial_occupation',
                'std'         => '',
                'type'        => 'text',
                'desc'        => __( 'Please provide testimonial occupation or company.', 'PixelEmu' )
            )
        )
    );

    if ( function_exists( 'ot_register_meta_box' ) )
    ot_register_meta_box( $PE_Testimonial_Meta_Box );

    $PE_Services_Meta_Box = array(
        'id'          => 'services_meta_box',
        'title'       => __( 'Choose a subtitle for your service', 'PixelEmu' ),
        'desc'        => '',
        'pages'       => array( 'service' ),
        'context'     => 'normal',
        'priority'    => 'high',
        'fields'      => array(
            array(
                'label'       => __( 'Service Subtitle', 'PixelEmu' ),
                'id'          => 'service_subtitle',
                'std'         => '',
                'type'        => 'text'
            )
        )
    );

    if ( function_exists( 'ot_register_meta_box' ) )
    ot_register_meta_box( $PE_Services_Meta_Box );


    $PE_Service_Page_Meta_Box = array(
        'id'          => 'service_categories_meta_box',
        'title'       => __( 'Service Page Options', 'PixelEmu' ),
        'desc'        => '',
        'pages'       => array( 'page' ),
        'context'     => 'normal',
        'priority'    => 'high',
        'fields'      => array(
            array(
                'id'          => 'service_categories',
                'label'       => __( 'Service Categories', 'PixelEmu' ),
                'desc'        => __( 'Choose categories to display items from.', 'PixelEmu' ),
                'std'         => '',
                'type'        => 'taxonomy-checkbox',
                'taxonomy'    => 'service-category',
            ),
            array(
                'id'          => 'services_total',
                'label'       => __( 'Items per Page', 'PixelEmu' ),
                'desc'        => __( 'Enter the number of items to display per page.', 'PixelEmu' ),
                'std'         => '6',
                'type'        => 'text',
                'section'     => 'services_page',
                'operator'    => 'and'
            ),
            array(
                'id'          => 'services_per_row',
                'label'       => __( 'Thumbnails per Row', 'PixelEmu' ),
                'desc'        => __( 'Enter the number of items to display per row.', 'PixelEmu' ),
                'std'         => '3',
                'type'        => 'text',
                'section'     => 'services_page',
                'operator'    => 'and'
            ),
            array(
                'id'          => 'thumbnails_position',
                'label'       => __( 'Thumbnails Position', 'PixelEmu' ),
                'desc'        => __( 'Choose thumbnails position.', 'PixelEmu' ),
                'std'         => '1',
                'type'        => 'select',
                'operator'    => 'and',
                'choices'     => array( 
                    array(
                        'value'       => '',
                        'label'       => __( '-- Choose One --', 'PixelEmu' ),
                        'src'         => ''
                    ),
                    array(
                        'value'       => '1',
                        'label'       => __( 'Thumbnails @Top', 'PixelEmu' ),
                        'src'         => ''
                    ),
                    array(
                        'value'       => '2',
                        'label'       => __( 'Thumbnails @Bottom', 'PixelEmu' ),
                        'src'         => ''
                    ),
                    array(
                        'value'       => '3',
                        'label'       => __( 'Thumbnails Right', 'PixelEmu' ),
                        'src'         => ''
                    ),
                    array(
                        'value'       => '4',
                        'label'       => __( 'Thumbnails Left', 'PixelEmu' ),
                        'src'         => ''
                    )
                )
            ),
            array(
                'id'          => 'thumbnails_size',
                'label'       => __( 'Thumbnails Size', 'PixelEmu' ),
                'desc'        => __( 'Choose thumbnails size.', 'PixelEmu' ),
                'std'         => 'medium',
                'type'        => 'select',
                'operator'    => 'and',
                'choices'     => array( 
                    array(
                        'value'       => '',
                        'label'       => __( '-- Choose One --', 'PixelEmu' ),
                        'src'         => ''
                    ),
                    array(
                        'value'       => 'thumbnail',
                        'label'       => __( 'Thumbnail', 'PixelEmu' ),
                        'src'         => ''
                    ),
                    array(
                        'value'       => 'medium',
                        'label'       => __( 'Medium', 'PixelEmu' ),
                        'src'         => ''
                    ),
                    array(
                        'value'       => 'large',
                        'label'       => __( 'Large', 'PixelEmu' ),
                        'src'         => ''
                    )
                )
            )
        )
    );
		
    $PE_Service_Top_Bottom_Schema_Meta_Box = array(
        'id'          => 'service_top_bottom_meta_box',
        'title'       => __( 'Size options for Top and Bottom View', 'PixelEmu' ),
        'desc'        => '',
        'pages'       => array( 'page' ),
        'context'     => 'normal',
        'priority'    => 'high',
        'fields'      => array(
            array(
                'id'          => 'item_height',
                'label'       => __( 'Item height', 'PixelEmu' ),
                'desc'        => __( ' Enter the height for items in pixels. The option is helpful in case your images height is not equal or service title has much different length. Leave it empty if you want the item height to be based on feature image height.', 'PixelEmu' ),
                'std'         => '',
                'type'        => 'text',
                'operator'    => 'and',
            )
        )
    );
		
    $PE_Service_Left_Right_Schema_Meta_Box = array(
        'id'          => 'service_left_right_meta_box',
        'title'       => __( 'Size options for Left and Right View', 'PixelEmu' ),
        'desc'        => '',
        'pages'       => array( 'page' ),
        'context'     => 'normal',
        'priority'    => 'high',
        'fields'      => array(
            array(
                'id'          => 'thumbnail_width',
                'label'       => __( 'Thumbnail Section Width', 'PixelEmu' ),
                'desc'        => __( 'Please choose Thumbnail width in percents.', 'PixelEmu' ),
                'std'         => '4',
                'type'        => 'select',
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
            )
        )
    );

    $post_id = isset( $_GET['post'] ) ? $_GET['post'] : ( isset( $_POST['post_ID'] ) ? $_POST['post_ID'] : 0 );
    $template_file = get_post_meta($post_id, '_wp_page_template', TRUE);
    if ($template_file == 'page-services.php') {
        if ( function_exists( 'ot_register_meta_box' ) )
        ot_register_meta_box( $PE_Service_Page_Meta_Box );
				ot_register_meta_box( $PE_Service_Top_Bottom_Schema_Meta_Box );
        ot_register_meta_box( $PE_Service_Left_Right_Schema_Meta_Box );
    }

		$PE_Single_Feature_Image = array(
        'id'          => 'single_archive_image',
        'title'       => __( 'Feature Image Single Post', 'PixelEmu' ),
        'desc'        => '',
        'pages'       => array( 'post' ),
        'context'     => 'side',
        'priority'    => 'default',
        'fields'      => array(
            array(
                'label'       => '',
                'id'          => 'feature_img_archive',
                'std'         => '',
                'type'        => 'upload',
                'desc'        => ''
            ),
        )
		);
	
	if ( function_exists( 'ot_register_meta_box' ) )
    ot_register_meta_box( $PE_Single_Feature_Image );
	
		$PE_Gallery_Meta_Box = array(
				'id'					=> 'gallery_meta_box',
				'title'				=> __( 'Gallery Settings', 'PixelEmu' ),
				'desc'				=> '',
				'pages'				=> array( 'gallery' ),
				'context'			=> 'normal',
				'priority'		=> 'high',
				'fields'			=> array(
						array(
								'label'				=> __( 'Modal', 'PixelEmu' ),
								'id'					=> 'gallery_modal',
								'std'					=> 'on',
								'type'				=> 'on-off',
								'desc'				=> __( 'Enable/Disable image modal on click.', 'PixelEmu' )
						),
						array(
								'label'				=> __( 'Images', 'PixelEmu' ),
								'id'					=> 'gallery_images',
								'std'					=> '',
								'type'				=> 'gallery',
								'desc'				=> __( 'Upload images that you want to show on this gallery.', 'PixelEmu' )
						)
				)
		);

		if ( function_exists( 'ot_register_meta_box' ) )
		ot_register_meta_box( $PE_Gallery_Meta_Box );

}