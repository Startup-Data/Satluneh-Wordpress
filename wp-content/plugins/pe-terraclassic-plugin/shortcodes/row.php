<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*  Grid Columns
/*-----------------------------------------------------------------------------------*/

add_shortcode( 'row', 'pe_row' );

if ( ! function_exists( 'pe_row' ) ) {
	function pe_row( $atts, $content = null ) {
		$a = shortcode_atts( array(
			'margin'  => 1,
			'padding' => 1,
			'class'   => '',
		), $atts );

		$class = ( ! empty( $a['class'] ) ) ? ' ' . pe_sanitize_class( $a['class'] ) : '';

		if ( $a['margin'] == 0 || $a['margin'] == 'false' ) {
			$class .= ' margin';
		}

		if ( $a['padding'] == 0 || $a['padding'] == 'false' ) {
			$class .= ' padding';
		}

		$output = '<div class="row sc' . $class . '">' . do_shortcode( $content ) . '</div>';

		return $output;
	}
}

add_shortcode( 'col', 'pe_columns' );
if ( ! function_exists( 'pe_columns' ) ) {
	function pe_columns( $atts, $content = null ) {
		$a = shortcode_atts( array(
			'size'   => '12',
			'screen' => 'md',
			'class'  => '',
		), $atts );

		$output = '<div class="item col-' . sanitize_html_class( $a['screen'] ) . '-' . sanitize_html_class( $a['size'] ) . ' ' . pe_sanitize_class( $a['class'] ) . '">' . do_shortcode( $content ) . '</div>';

		return $output;

	}
}

?>
