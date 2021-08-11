<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

get_template_part( 'layout-options' );

// Get info about breadcrumbs
$off_canvas_position = ot_get_option( 'offcanvas_position', 'right' );

?>

<!DOCTYPE html>

<html <?php language_attributes(); // language attributes ?>>
	
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); // address pingback ?>">
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
		<![endif]-->
		<?php

		$favicon = ot_get_option( 'favicon' );

		if($favicon) { ?>

			<link rel="icon" href="<?php echo esc_url( $favicon ); ?>" type="image/x-icon" />
			<link rel="shortcut icon" href="<?php echo esc_url( $favicon ); ?>" type="image/x-icon" />		
		
		<?php } ?>
		
		<?php get_template_part( 'tpl/google-webmaster' ); ?>
		<?php get_template_part( 'tpl/custom-code' ); ?>
		<?php get_template_part( 'tpl/google-analytics' ); ?>
		
		<?php

			$sticky_topbar = ot_get_option( 'sticky_topbar', 'on' );

			if($sticky_topbar == 'on'){

				$sticky_topbar_val = 'sticky-bar';

			} else{

				$sticky_topbar_val = '';

			}
		?>
		<?php wp_head(); ?>
	</head>
	
	<body <?php body_class( 'off-canvas-'.$off_canvas_position.' '.$sticky_topbar_val ); ?>>
		
		<div id="pe-main">

		<?php

			//offcanvas
			get_template_part( 'tpl/offcanvas' );
		
			//top bar menu, logo and main menu
			get_template_part( 'tpl/top-bar' );
			
			//header section for slider and custom widgets
			get_template_part( 'tpl/header-section' );
			
			//top widget position
			get_template_part( 'tpl/top' );

			// breadcrumb position
			if (!is_front_page() && !is_home() ) :
				if ( is_page() && ot_get_option( 'breadcrumb_page') == 'on' 
					|| is_singular('post') && ot_get_option( 'breadcrumb_single') == 'on' 
					|| is_singular('service') && ot_get_option( 'breadcrumb_service') == 'on' 
					|| is_singular('member') && ot_get_option( 'breadcrumb_member') == 'on'
					|| is_singular('testimonial') && ot_get_option( 'breadcrumb_testimonial') == 'on'
					|| is_archive() && ot_get_option( 'breadcrumb_archive') == 'on' ) {
					get_template_part( 'tpl/breadcrumbs' );
				}
			endif;
		
		?>