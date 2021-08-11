<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Accordion
/*-----------------------------------------------------------------------------------*/

add_shortcode( 'accordion', 'pe_accordion_group' );

// Accordion group
if ( ! function_exists( 'pe_accordion_group' ) ) {
	function pe_accordion_group( $atts, $content = null ) {

		$unID = uniqid( 'pe-accordion-' );

		$output = '<div id="' . $unID . '" class="pe-accordion-container" role="tablist">';
		$output .= do_shortcode( $content );
		$output .= '</div>';

		return $output;
	}
}

add_shortcode( 'accordion_content', 'pe_accordion_content' );

//Accordion group container
if ( ! function_exists( 'pe_accordion_content' ) ) {
	function pe_accordion_content( $atts, $content = null ) {
		$a = shortcode_atts(
			array(
				'title'    => '',
				'headerid' => '',
				'targetid' => '',
				'status'   => ''
			), $atts );

		if ( empty( $a['headerid'] ) ) {
			$a['headerid'] = uniqid( 'pe-heading-' );
		}

		if ( empty( $a['targetid'] ) ) {
			$a['targetid'] = uniqid( 'pe-accordion-' );
		}

		if ( ! empty( $a['status'] ) && $a['status'] == 'active' ) {
			$aria_expanded = 'true';
		} else {
			$aria_expanded = 'false';
		}

		$output = '<div class="pe-accordion"><div class="accordion-in">';
		$output .= '<div id="' . sanitize_html_class( $a['headerid'] ) . '" class="pe-accordion-heading ' . sanitize_html_class( $a['status'] ) . '" role="tab">';
		$output .= '<a href="#' . sanitize_html_class( $a['targetid'] ) . '" role="button" aria-controls="' . sanitize_html_class( $a['targetid'] ) . '">' . esc_attr( $a['title'] ) . '</a>';
		$output .= '</div>';
		$output .= '<div id="' . sanitize_html_class( $a['targetid'] ) . '" class="pe-accordion-content ' . sanitize_html_class( $a['status'] ) . '" role="tabpanel" aria-labelledby="' . sanitize_html_class( $a['headerid'] ) . '"  aria-expanded="' . sanitize_html_class( $aria_expanded ) . '">';
		$output .= do_shortcode( $content ); // accepts [pe_shortcodes] for each accordion item
		$output .= '</div>';
		$output .= '</div></div>';

		return $output;
	}
}

?>
