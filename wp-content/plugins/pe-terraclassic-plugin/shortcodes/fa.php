<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Font Awesome
/*-----------------------------------------------------------------------------------*/

add_shortcode( 'fa', 'pe_fa' );

if ( ! function_exists( 'pe_fa' ) ) {
	function pe_fa( $atts, $content ) {
		$a = shortcode_atts(
			array(
				'class' => '',
			), $atts );

		$class = ( ! empty( $a['class'] ) ) ? ' ' . sanitize_html_class( $a['class'] ) : '';

		$html = '';

		if ( ! empty( $content ) ) {

			$array      = explode( ' ', $content );
			$icon_class = '';

			foreach ( $array as $key => $val ) {
				$val        = sanitize_html_class( $val );
				$icon_class .= ' ' . $val;
			}

			$html .= '<span class="fa' . $icon_class . $class . '" aria-hidden="true"></span>';

		}

		return $html;
	}
}

?>
