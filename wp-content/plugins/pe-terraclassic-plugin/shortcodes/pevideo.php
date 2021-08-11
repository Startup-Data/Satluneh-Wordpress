<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*  Video Gallery
/*-----------------------------------------------------------------------------------*/

add_shortcode( 'pevideo', 'video_shortcode' );

if ( ! function_exists( 'video_shortcode' ) ) {
	function video_shortcode( $atts, $content = null ) {
		$a = shortcode_atts( array(
			'web'  => 'youtube',
			'id'   => '',
			'fs'   => '1',
			'size' => ''
		), $atts );

		if ( $a['fs'] == 1 ) {
			$videofs = 'allowfullscreen';
		} else {
			$videofs = ' ';
		}

		if ( ! empty( $a['size'] ) ) {
			$output = '<div class="item col-md-' . sanitize_html_class( $a['size'] ) . '">';
		} else {
			$output = '<div class="item">';
		}
		$output .= '<figure class="pe_video embed-responsive embed-responsive-16by9">';
		if ( $a['web'] == 'youtube' ) {
			$output .= '<iframe src="//www.youtube.com/embed/' . esc_attr( $a['id'] ) . '" ' . $videofs . '></iframe>';
		} else if ( $a['web'] == 'vimeo' ) {
			$output .= '<iframe src="//player.vimeo.com/video/' . esc_attr( $a['id'] ) . '" ' . $videofs . '></iframe>';
		} else if ( $a['web'] != 'vimeo' || $a['web'] != 'youtube' ) {
			$output .= __( 'Only Youtube and Vimeo services supported !', 'pe-terraclassic-plugin' );
		}
		$output .= '</figure>';
		$output .= '</div>';

		return $output;

	}
}

?>
