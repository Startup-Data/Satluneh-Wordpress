<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Pricing Table
/*-----------------------------------------------------------------------------------*/

add_shortcode( 'pricing', 'pe_pricing' );

if ( ! function_exists( 'pe_pricing' ) ) {
	function pe_pricing( $atts, $content ) {
		$a = shortcode_atts( array(
			'title'        => '',
			'price'        => '',
			'before_price' => '',
			'after_price'  => '',
			'subtitle'     => '',
			'button_name'  => '',
			'button_url'   => '',
			'class'        => '',
		), $atts );

		$content = trim( strip_tags( $content ) );
		$content = do_shortcode( $content );

		$a['title'] = esc_attr( $a['title'] );
		$a['price'] = esc_attr( $a['price'] );

		$a['before_price'] = esc_attr( $a['before_price'] );
		$a['after_price']  = esc_attr( $a['after_price'] );

		$a['subtitle'] = esc_attr( $a['subtitle'] );

		$a['button_name'] = esc_attr( $a['button_name'] );
		$a['button_url']         = esc_url( $a['button_url'] );

		$a['class'] = pe_sanitize_class( $a['class'] );

		$class = '';
		if ( ! empty( $a['class'] ) ) {
			$class .= ' ' . $a['class'];
		}

		$html = '';

		if ( ! empty( $content ) ) {
			$list = array_map( 'trim', (array) explode( '|', $content ) );
		}

		$html .= '<div class="pe-pricing' . $class . '">';

		if ( isset( $a['price'] ) && is_numeric( $a['price'] ) ) {
			$before = ( ! empty( $a['before_price'] ) ) ? '<span class="before">' . $a['before_price'] . '</span>' : '';
			$after  = ( ! empty( $a['after_price'] ) ) ? '<span class="after">' . $a['after_price'] . '</span>' : '';
			$html   .= '<div class="price">' . $before . '<span class="p">' . $a['price'] . '</span>' . $after . '</div>';
		}

		if ( ! empty( $a['title'] ) ) {
			$html .= '<div class="title">' . $a['title'] . '</div>';
		}


		$html .= '<div class="content">';
		if ( ! empty( $a['subtitle'] ) ) {
			$html .= '<div class="subtitle">' . $a['subtitle'] . '</div>';
		}
		if ( ! empty( $content ) ) {
			$html .= '<ul>';
			foreach ( $list as $id => $li ) {
				$html .= '<li>' . $li . '</li>';
			}
			$html .= '</ul>';
		}
		$html .= '</div>';


		if ( ! empty( $a['button_name'] ) && ! empty( $a['button_url'] ) ) {
			$html .= '<div class="bottom"><a href="' . $a['button_url'] . '" class="button">' . $a['button_name'] . '</a></div>';
		}

		$html .= '</div>';

		return $html;

	}
}
