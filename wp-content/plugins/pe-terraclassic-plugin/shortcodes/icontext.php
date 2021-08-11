<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*  Icontext
/*-----------------------------------------------------------------------------------*/


add_shortcode( 'icontext', 'pe_icon_text' );

if ( ! function_exists( 'pe_icon_text' ) ) {
	function pe_icon_text( $atts, $content = null ) {
		$a = shortcode_atts( array(
			'link'          => '',
			'title'         => '',
			'icon'          => '',
			'icon_width'    => '',
			'content_width' => '',
			'class'         => '',
		), $atts );

		//default
		$a['link']  = ( ! empty( $a['link'] ) ) ? $a['link'] : false;
		$a['title'] = ( ! empty( $a['title'] ) ) ? $a['title'] : false;
		$a['icon']  = ( ! empty( $a['icon'] ) ) ? $a['icon'] : false;

		$class = ( ! empty( $a['class'] ) ) ? $a['class'] : '';

		$icon_width    = ( ! empty( $a['icon_width'] ) ) ? 'style="min-width: ' . pe_sanitize_size( $a['icon_width'] ) . '"' : '';
		$content_width = ( ! empty( $a['content_width'] ) ) ? 'style="min-width: ' . pe_sanitize_size( $a['content_width'] ) . '"' : '';

		$output = '<div class="pe-icontext ' . pe_sanitize_class( $class ) . '">';
		if ( $a['icon'] ) {
			$output .= '<div class="pe-icon" ' . $icon_width . '><span class="fa ' . pe_sanitize_class( $a['icon'] ) . '" aria-hidden="true"></span></div>';
		}
		$output .= '<div class="pe-content" ' . $content_width . '>';
		if ( $a['title'] ) {
			$output .= '<div class="pe-label">';
			if ( $a['link'] ) {
				$output .= '<a href="' . esc_attr( $a['link'] ) . '">' . esc_attr( $a['title'] ) . '</a>';
			} else {
				$output .= esc_attr( $a['title'] );
			}
			$output .= '</div>';
		}
		$output .= '<div class="pe-desc">' . do_shortcode( $content ) . '</div>';
		$output .= '</div>';

		$output .= '</div>';

		return $output;

	}
}

?>
