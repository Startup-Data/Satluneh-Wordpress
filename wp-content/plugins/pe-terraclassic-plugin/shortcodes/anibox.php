<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*  Animated boxes
/*-----------------------------------------------------------------------------------*/

add_shortcode('anibox', 'pe_anibox');

if ( !function_exists('pe_anibox') ) {
	function pe_anibox( $atts, $content = null ) {
		$a = shortcode_atts(
			array(
				'effect'     => 'sadie',
				'background' => '',
				'width'      => 480,
				'height'     => 360,
				'link'       => '',
				'target'     => '_self',
				'title'      => '',
				'subtitle'   => '',
				'fontcolor'  => '',
				'alt'        => '',
			), $atts);

		$px = 'px';
		if($a['height'] == 'auto' || $a['height'] == 'none'){
			$px = '';
			$a['height'] = 'none';
		}
		
		$font_color_class = ( !empty($a['fontcolor']) ) ? ' style="color: ' . esc_attr( $a['fontcolor'] ) . ';"' : '';

		$output = '<div class="pe-anibox"><figure class="effect-' . sanitize_html_class( $a['effect'] ) . '" style="max-width: ' . esc_attr( $a['width'] ) . 'px; max-height: ' . esc_attr( $a['height'] ) . $px . ';">';
		
		if ( is_numeric( $a['background'] ) ) {
			$img             = wp_get_attachment_image_src( (int) $a['background'], 'full' );
			$a['background'] = ( ! empty( $img ) ) ? $img[0] : false;
		}

		if ( ! empty( $a['background'] ) ) {
			$output .= '<img src="' . esc_url( $a['background'] ) . '" alt="' . mb_substr (esc_attr( $a['subtitle'] ), 0, 20) . '" />';
		}

		if( !empty($a['title']) || !empty($a['subtitle']) ) {
			$output .= '<figcaption>';
				if( !empty($a['title']) ) {
					$output .= '<h2 ' . $font_color_class . '>' . esc_attr( $a['title'] ) . '</h2>';
				}
				if( !empty($a['subtitle']) ) {
					$output .= '<p ' . $font_color_class . '>' . esc_attr( $a['subtitle'] ) . '</p>';
				}
				if ( ! empty( $a['link'] ) ) {
					if ( $a['effect'] == 'julia' ) {
						$output .= '<p class="p-more"><a class="btn readmore-julia" href="' . esc_url( $a['link'] ) . '" target="' . esc_attr( $a['target'] ) . '">' . esc_html__( 'Readmore', 'pe-terraclassic-plugin' ) . '</a></p>';
					} else {
						$output .= '<a href="' . esc_url( $a['link'] ) . '" target="' . esc_attr( $a['target'] ) . '">' . esc_attr( $a['link'] ) . '</a>';
					}
				}
			$output .= '</figcaption>';
		}

		$output .= '</figure></div>';

		return $output;
	}
}

?>
