<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*  Tabs
/*-----------------------------------------------------------------------------------*/

$tabs_divs = '';

// tabs navigation and tab content wrapper
add_shortcode( 'tabs', 'pe_tabs_group' );

if ( ! function_exists( 'pe_tabs_group' ) ) {

	function pe_tabs_group( $atts, $content = null ) {

		global $tabs_divs;

		$tabs_divs = '';

		$a = shortcode_atts( array(
			'class' => '',
		), $atts );

		$class = ( ! empty( $a['class'] ) ) ? sanitize_html_class( $a['class'] ) : '';

		$unID = uniqid( 'pe-tabs-' );

		$output = '<div id="' . $unID . '" class="pe-tabs ' . $class . '"><ul class="pe-tab-links" role="tablist" tabindex="0">';
		$output .= do_shortcode( $content );
		$output .= '</ul><div class="pe-tabs-content">' . $tabs_divs . '</div></div>';

		return $output;

	}

}

// tab navigation and tab content
add_shortcode( 'tab', 'pe_tab_item' );

if ( ! function_exists( 'pe_tab_item' ) ) {

	function pe_tab_item( $atts, $content = null ) {

		global $tabs_divs;

		$a = shortcode_atts( array(
			'id'     => '',
			'title'  => '',
			'status' => '',
		), $atts );

		if ( empty( $a['id'] ) ) {
			$a['id'] = uniqid( 'pe-tab-' );
		}

		$output = '<li class="' . sanitize_html_class( $a['status'] ) . '" role="presentation">';
		$output .= '<a href="#' . sanitize_html_class( $a['id'] ) . '" aria-controls="' . sanitize_html_class( $a['id'] ) . '" role="tab" >' . esc_attr( $a['title'] ) . '</a>';
		$output .= '</li>';

		$tabs_divs .= '<div id="' . sanitize_html_class( $a['id'] ) . '" class="pe-tab ' . sanitize_html_class( $a['status'] ) . '" role="tabpanel">' . do_shortcode( $content ) . '</div>'; // accepts [pe_shortcodes] for each tab item

		return $output;

	}
}

?>
