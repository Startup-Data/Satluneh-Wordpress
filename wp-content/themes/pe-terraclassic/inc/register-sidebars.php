<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/*-----------------------------------------------------------------------------------*/
/*	Register Sidebars
/*-----------------------------------------------------------------------------------*/



if ( ! function_exists( 'pe_widgets_init' ) ) {
	/**
	 * Add dynamic sidebars in WordPress
	 */
	function pe_widgets_init() {
		
		$left_heading = PEsettings::get( 'left-heading' );
		$right_heading = PEsettings::get( 'right-heading' );
		$top_bar_heading = PEsettings::get( 'top-bar-heading' );
		$header_heading = PEsettings::get( 'header-heading' );
		$top1_heading = PEsettings::get( 'top1-heading' );
		$top2_heading = PEsettings::get( 'top2-heading' );
		$top3_heading = PEsettings::get( 'top3-heading' );
		$content_top_heading = PEsettings::get( 'content-top-heading' );
		$content_bottom_heading = PEsettings::get( 'content-bottom-heading' );
		$bottom1_heading = PEsettings::get( 'bottom1-heading' );
		$bottom2_heading = PEsettings::get( 'bottom2-heading' );
		$footer_heading = PEsettings::get( 'footer-heading' );
		$offcanvas_heading = PEsettings::get( 'offcanvas-heading' );
		$coming_soon_heading = PEsettings::get( 'coming-soon-heading' );

		// Location: Left
		register_sidebar(
			array(
				'name'          => esc_html__( 'Left', 'pe-terraclassic' ),
				'id'            => 'left-column',
				'before_widget' => '<div id="%1$s" class="pe-widget widget %2$s"><div class="pe-widget-in clearfix">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h'.$left_heading.' class="pe-title">',
				'after_title'   => '</h'.$left_heading.'>'
			)
		);

		// Location: Right
		register_sidebar(
			array(
				'name'          => esc_html__( 'Right', 'pe-terraclassic' ),
				'id'            => 'right-column',
				'before_widget' => '<div id="%1$s" class="pe-widget widget %2$s"><div class="pe-widget-in clearfix">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h'.$right_heading.' class="pe-title">',
				'after_title'   => '</h'.$right_heading.'>'
			)
		);
		
		// Location: Top Bar
		register_sidebar(
			array(
				'name'          => esc_html__( 'Top Bar', 'pe-terraclassic' ),
				'id'            => 'top-bar',
				'before_widget' => '<div id="%1$s" class="pe-widget widget %2$s"><div class="pe-widget-in clearfix">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h'.$top_bar_heading.' class="pe-title">',
				'after_title'   => '</h'.$top_bar_heading.'>'
			)
		);

		// Location: Top Bar 2
		register_sidebar(
			array(
				'name'          => esc_html__( 'Top Bar 2', 'pe-terraclassic' ),
				'id'            => 'top-bar2',
				'before_widget' => '<div id="%1$s" class="pe-widget widget %2$s"><div class="pe-widget-in clearfix">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h'.$top_bar_heading.' class="pe-title">',
				'after_title'   => '</h'.$top_bar_heading.'>'
			)
		);
		
		// Location: Header
		register_sidebar(
			array(
				'name'          => esc_html__( 'Header', 'pe-terraclassic' ),
				'id'            => 'header',
				'before_widget' => '<div id="%1$s" class="pe-widget widget %2$s"><div class="pe-widget-in clearfix">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h'.$header_heading.' class="pe-title">',
				'after_title'   => '</h'.$header_heading.'>'
			)
		);

		// Location: Top1
		register_sidebar(
			array(
				'name'          => esc_html__( 'Top 1', 'pe-terraclassic' ),
				'id'            => 'top1',
				'before_widget' => '<div id="%1$s" class="pe-widget widget %2$s"><div class="pe-widget-in clearfix">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h'.$top1_heading.' class="pe-title">',
				'after_title'   => '</h'.$top1_heading.'>'
			)
		);

		// Location: Top2
		register_sidebar(
			array(
				'name'          => esc_html__( 'Top 2', 'pe-terraclassic' ),
				'id'            => 'top2',
				'before_widget' => '<div id="%1$s" class="pe-widget widget %2$s"><div class="pe-widget-in clearfix">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h'.$top2_heading.' class="pe-title">',
				'after_title'   => '</h'.$top2_heading.'>'
			)
		);
		
		// Location: Top3
		register_sidebar(
			array(
				'name'          => esc_html__( 'Top 3', 'pe-terraclassic' ),
				'id'            => 'top3',
				'before_widget' => '<div id="%1$s" class="pe-widget widget %2$s"><div class="pe-widget-in clearfix">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h'.$top3_heading.' class="pe-title">',
				'after_title'   => '</h'.$top3_heading.'>'
			)
		);

		// Location: Content Top
		register_sidebar(
			array(
				'name'          => esc_html__( 'Content Top', 'pe-terraclassic' ),
				'id'            => 'content-top',
				'before_widget' => '<div id="%1$s" class="pe-widget widget %2$s"><div class="pe-widget-in clearfix">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h'.$content_top_heading.' class="pe-title">',
				'after_title'   => '</h'.$content_top_heading.'>'
			)
		);

		// Location: Content Bottom
		register_sidebar(
			array(
				'name'          => esc_html__( 'Content Bottom', 'pe-terraclassic' ),
				'id'            => 'content-bottom',
				'before_widget' => '<div id="%1$s" class="pe-widget widget %2$s"><div class="pe-widget-in clearfix">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h'.$content_bottom_heading.' class="pe-title">',
				'after_title'   => '</h'.$content_bottom_heading.'>'
			)
		);

		// Location: Bottom1
		register_sidebar(
			array(
				'name'          => esc_html__( 'Bottom 1', 'pe-terraclassic' ),
				'id'            => 'bottom1',
				'before_widget' => '<div id="%1$s" class="pe-widget widget %2$s"><div class="pe-widget-in clearfix">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h'.$bottom1_heading.' class="pe-title">',
				'after_title'   => '</h'.$bottom1_heading.'>'
			)
		);

		// Location: Bottom2
		register_sidebar(
			array(
				'name'          => esc_html__( 'Bottom 2', 'pe-terraclassic' ),
				'id'            => 'bottom2',
				'before_widget' => '<div id="%1$s" class="pe-widget widget %2$s"><div class="pe-widget-in clearfix">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h'.$bottom2_heading.' class="pe-title">',
				'after_title'   => '</h'.$bottom2_heading.'>'
			)
		);

		// Location: Footer
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer', 'pe-terraclassic' ),
				'id'            => 'footer',
				'before_widget' => '<div id="%1$s" class="pe-widget widget %2$s"><div class="pe-widget-in clearfix">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h'.$footer_heading.' class="pe-title">',
				'after_title'   => '</h'.$footer_heading.'>'
			)
		);

		// Location: Offcanvas Sidebar
		register_sidebar(
			array(
				'name'          => esc_html__( 'Off-canvas', 'pe-terraclassic' ),
				'id'            => 'off-canvas-sidebar',
				'before_widget' => '<div id="%1$s" class="pe-widget widget %2$s"><div class="pe-widget-in clearfix">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h'.$offcanvas_heading.' class="pe-title">',
				'after_title'   => '</h'.$offcanvas_heading.'>'
			)
		);

		// Location: Coming Soon Page
		register_sidebar(
			array(
				'name'          => esc_html__( 'Coming-Soon', 'pe-terraclassic' ),
				'id'            => 'coming-soon-sidebar',
				'before_widget' => '<div id="%1$s" class="pe-widget-raw widget clearfix %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h'.$coming_soon_heading.' class="pe-title">',
				'after_title'   => '</h'.$coming_soon_heading.'>'
			)
		);
	}
}
add_action( 'widgets_init', 'pe_widgets_init' );
?>
