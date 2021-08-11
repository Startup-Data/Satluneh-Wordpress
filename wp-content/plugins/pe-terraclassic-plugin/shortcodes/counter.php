<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*  Counter
/*-----------------------------------------------------------------------------------*/

add_shortcode( 'counter', 'pe_counter' );

if ( ! function_exists( 'pe_counter' ) ) {
	function pe_counter( $atts, $content = null ) {
		$a = shortcode_atts(
			array(
				'icon'   => '',
				'size'   => '',
				'number' => '',
				'unit'   => '',
				'link'   => '',
				'title'  => '',
			), $atts );

		$size = ( ! empty( $a['size'] ) ) ? ' style="font-size: ' . sanitize_html_class( $a['size'] ) . ';"' : '';

		if ( ! empty( $a['number'] ) ) {
			$output = '<div class="pe-counter">';

			if ( ! empty( $a['icon'] ) ) {
				$output .= '<div class="pe-icon" ' . $size . '><em class="fa ' . esc_attr( $a["icon"] ) . '" aria-hidden="true"></em></div>';
			}

			$output .= '<div class="pe-count"><span class="pe-number" data-to="' . (int) $a['number'] . '" data-from="0">0</span>';

			if ( ! empty( $a['unit'] ) ) {
				$output .= '<span class="pe-unit">' . esc_html( $a['unit'] ) . '</span>';
			}

			$output .= '</div>';

			if ( ! empty( $a['title'] ) ) {

				$output .= '<div class="pe-title">';

				if ( ! empty( $a['link'] ) ) {
					$output .= '<a class="pe-counter-link" href="' . esc_url( $a['link'] ) . '">';
				}

				$output .= esc_attr( $a['title'] );

				if ( ! empty( $a['link'] ) ) {
					$output .= '</a>';
				}

				$output .= '</div>';
			}

			$output .= '</div>';

			return $output;
		}

	}
}

?>
