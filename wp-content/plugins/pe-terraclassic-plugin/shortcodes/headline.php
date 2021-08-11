<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Headline
/*-----------------------------------------------------------------------------------*/

function comma_separated_to_array( $string, $separator = ',' ) {
	//Explode on comma
	$vals = explode( $separator, $string );

	//Trim whitespace
	foreach ( $vals as $key => $val ) {
		$vals[ $key ] = trim( $val );
	}

	return array_diff( $vals, array( "" ) );
}

add_shortcode( 'headline', 'pe_headline' );

if ( ! function_exists( 'pe_headline' ) ) {
	function pe_headline( $atts, $content = null ) {

		$a = shortcode_atts(
			array(
				'subtitle' => '',
				'class'    => '',
				'style'    => '',
			), $atts );

		$headline_class = ( ! empty( $a['class'] ) ) ? sanitize_html_class( $a['class'] ) : '';
		$headline_style = ( ! empty( $a['style'] ) ) ? 'style="' . esc_attr( $a['style'] ) . '"' : '';

		$output = '<div class="cd-intro ' . $headline_class . '"><h2 class="cd-headline loading-bar" ' . $headline_style . '>';

		if ( ! empty( $content ) ) {
			$output .= '<span class="cd-desc">';
			$output .= do_shortcode( $content );
			$output .= '</span>';
		}

		if ( ! empty( $a['subtitle'] ) ) {
			$count          = 0;
			$subttile_array = comma_separated_to_array( $a['subtitle'] );
			$output         .= '<span class="cd-words-wrapper">';
			foreach ( $subttile_array as $value ) {
				if ( $count == 0 ) {
					$output .= '<strong class="is-visible">' . esc_attr( $value ) . '</strong>';
				} else {
					$output .= '<strong>' . esc_attr( $value ) . '</strong>';
				}
				$count ++;
			}
			$output .= '</span>';
		}

		$output .= '</h2></div>';

		return $output;
	}
}

?>
