<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

function taxMeta() {

	/*
	* configure taxonomy custom fields
	*/
	$config = array(
		'id'             => 'category_layout_chooser',
		// meta box id, unique per meta box
		'title'          => 'Category Layout Chooser',
		// meta box title
		'pages'          => array( 'category' ),
		// taxonomy name, accept categories, post_tag and custom taxonomies
		'context'        => 'normal',
		// where the meta box appear: normal (default), advanced, side; optional
		'fields'         => array(),
		// list of meta fields (can be added by field arrays)
		'local_images'   => false,
		// Use local or hosted images (meta box images for add/remove)
		'use_with_theme' => true
		//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	);

	/*
	* Initiate your taxonomy custom fields
	*/

	$my_meta = new Tax_Meta_Class( $config );

	//select field
	$my_meta->addSelect( 'category_layout',
		array(
			''  => esc_html__( 'Global Settings', 'pe-terraclassic' ),
			'1' => esc_html__( '1 column', 'pe-terraclassic' ),
			'2' => esc_html__( '2 columns', 'pe-terraclassic' ),
			'3' => esc_html__( '3 columns', 'pe-terraclassic' ),
			'4' => esc_html__( '4 columns', 'pe-terraclassic' ),
		),
		array(
			'name' => esc_html__( 'Blog columns', 'pe-terraclassic' ),
			'desc' => esc_html__( 'Option will override default settings from theme options.', 'pe-terraclassic' ),
			'std'  => array( 'global_settings' )
		)
	);

	//select field
	$my_meta->addSelect( 'category_style',
		array(
			''         => esc_html__( 'Global Settings', 'pe-terraclassic' ),
			'standard' => esc_html__( 'Standard', 'pe-terraclassic' ),
			'effect'   => esc_html__( 'Intro Effect', 'pe-terraclassic' ),
		),
		array(
			'name' => esc_html__( 'Blog style', 'pe-terraclassic' ),
			'desc' => esc_html__( 'Option will override default settings from theme options.', 'pe-terraclassic' ),
			'std'  => array( 'global_settings' )
		)
	);


	/*
	* Don't Forget to Close up the meta box deceleration
	*/
	//Finish Taxonomy Extra fields Deceleration
	$my_meta->Finish();
}

taxMeta();


?>
