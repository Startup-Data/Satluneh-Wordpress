<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Table
/*-----------------------------------------------------------------------------------*/

add_shortcode( 'table', 'pe_table' );

if ( ! function_exists( 'pe_table' ) ) {
	function pe_table( $atts, $content ) {
		$a = shortcode_atts( array(
			'class'  => '',
			'width'  => '100%',
			'style'  => '',
			'head'   => 1,
			'fixed'  => 0,
			'center' => 0,
			'size'   => '',
		), $atts );

		$content = trim( strip_tags( $content ) );
		$content = do_shortcode( $content );

		$class = ( ! empty( $a['class'] ) ) ? sanitize_html_class( $a['class'] ) : '';
		$width = ( ! empty( $a['width'] ) ) ? 'width: ' . esc_attr( $a['width'] ) . ';' : '';
		$style = ( ! empty( $a['style'] ) ) ? esc_attr( $a['style'] ) : '';

		if ( ! empty( $a['fixed'] ) && ( $a['fixed'] === 1 || $a['fixed'] === 'true' ) ) {
			$class .= ' fixed';
		}

		if ( ! empty( $a['center'] ) && ( $a['center'] === 1 || $a['center'] === 'true' ) ) {
			$class .= ' center';
		}

		if ( ! empty( $a['size'] ) ) {
			$a['size']   = esc_attr( $a['size'] );
			$sizes_array = array_map( 'trim', (array) explode( ",", $a['size'] ) );
		}

		$array = array_map( 'trim', (array) explode( "\n", $content ) );

		if ( ! empty( $a['head'] ) && ( $a['head'] === 1 || $a['head'] === 'true' ) ) {
			$show_title = true;
			$th         = array_slice( $array, 0, 1 );
			$th_array   = explode( '|', $th[0] );
			$th_count   = count( $th_array );

			$td       = array_slice( $array, 1 );
			$td_array = array();
			foreach ( $td as $key ) {
				$td_array[] = explode( '|', $key );
			}
			array_multisort( $result = array_map( 'count', $td_array ), SORT_DESC );
			$td_count = ( $result ) ? $result[0] : 0;

		} else {
			$show_title = false;

			$td       = $array;
			$td_array = array();
			foreach ( $td as $key ) {
				$td_array[] = explode( '|', $key );
			}
		}

		$th_nm = 0;
		$tr_nm = 0;
		$td_nm = 0;

		$style_attr = ( $width || $style ) ? 'style="' . $width . $style . '"' : '';

		//open table
		$html = '<table class="pe-table ' . $class . '" ' . $style_attr . '>';

		//show title
		if ( $show_title ) {
			$html .= '<thead>';
			foreach ( $th as $row ) {
				$html    .= '<tr>';
				$colspan = ( $th_count == 1 ) ? 'colspan="' . $td_count . '"' : '';

				foreach ( $th_array as $col ) {
					$th_nm ++;
					$html .= '<th class="th-' . $th_nm . '" ' . $colspan . '>' . trim( $col ) . '</th>';
				}

				$html .= '</tr>';
			}
			$html .= '</thead>';
		}

		//table body
		$html .= '<tbody>';
		foreach ( $td_array as $row ) {
			$tr_nm ++;
			$html .= '<tr class="tr-' . $tr_nm . '">';
			foreach ( $row as $col ) {

				$td_size = ( isset( $sizes_array[ $td_nm ] ) ) ? 'style="width: ' . $sizes_array[ $td_nm ] . ';"' : '';

				$td_nm ++;

				$html .= '<td class="td-' . $td_nm . '" ' . $td_size . '>' . trim( $col ) . '</td>';

			}
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		//close table
		$html .= '</table>';

		return $html;

	}
}

?>
