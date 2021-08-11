<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*  Readmore
/*-----------------------------------------------------------------------------------*/

add_shortcode( 'readmore', 'pe_readmore_link' );

if ( ! function_exists( 'pe_readmore_link' ) ) {
	function pe_readmore_link( $atts, $content = null ) {
		$a = shortcode_atts( array(
			'link'  => '',
			'icon'  => '',
			'class' => '',
			'target'  => '',
		), $atts );

		//default
		$link  = ( ! empty( $a['link'] ) ) ? esc_url( $a['link'] ) : '#';
		$icon  = ( ! empty( $a['icon'] ) ) ? pe_sanitize_class( $a['icon'] ) : '';
		$class = ( ! empty( $a['class'] ) ) ? pe_sanitize_class( $a['class'] ) : '';
		$target = ( !empty($a['target']) ) ? pe_sanitize_class( $a['target'] ) : '_self';

		if($target == 'self' || $target == '_self'){
			$target = '_self';
		}
		if($target == 'blank'){
			$target = '_blank';
		}
		
		$final_class = '';

		if ( ! empty( $icon ) ) {
			$final_class .= ' readmore-icon';
		}

		if ( ! empty( $class ) ) {
			$final_class .= ' ' . $class;
		}

		$output = '<a href="' . $link . '" class="readmore' . $final_class . '" target="' . $target . '">';
		$output .= do_shortcode( $content );
		if ( ! empty( $icon ) ) {
			$output .= '<span class="fa ' . $icon . '" aria-hidden="true"></span>';
		}
		$output .= '</a>';

		return $output;

	}
}

?>
