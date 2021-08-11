<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Code
/*-----------------------------------------------------------------------------------*/

add_shortcode( 'code', 'pe_code' );

if ( ! function_exists( 'pe_code' ) ) {
	function pe_code( $atts, $content = null ) {
		$a = shortcode_atts(
			array(
				'class' => '',
				'style' => '',
			), $atts );

		$style = ( $a['style'] ) ? 'style="' . esc_attr( $a['style'] ) . '"' : '';
		$class = ( $a['class'] ) ? 'class="' . sanitize_html_class( $a['class'] ) . '"' : '';

		$content = str_replace( '<br />', '', $content );
		$content = str_replace( '<', '&lt;', $content );
		$content = str_replace( '>', '&gt;', $content );

		//strong / italic
		$content = preg_replace( '#\"(.*?)\"#', '<b>"$1"</b>', $content );

		$content = str_replace( '[b]', '<b>', $content );
		$content = str_replace( '[/b]', '</b>', $content );
		$content = str_replace( '[i]', '<i>', $content );
		$content = str_replace( '[/i]', '</i>', $content );

		$content = str_replace( '[', '&#91;', $content );
		$content = str_replace( ']', '&#93;', $content );

		return '<pre ' . $class . ' ' . $style . '>' . $content . '</pre>';
	}
}

?>
