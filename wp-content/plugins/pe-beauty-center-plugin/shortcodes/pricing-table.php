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
	add_shortcode('pricing_table', 'pricing_table');
	
	//Table Heading (service category title)
	if (!function_exists('pricing_table')) {
		function pricing_table($atts, $content = null) {
			$a = shortcode_atts(
				array(
					'size' => '33%', // table size
					'title' => '' // table heading title
				), $atts);

		if (isset($a['size']) || isset($a['title'])) {
			if (isset($a['size'])) {
				$output = '<table class="pricing" style="width:'.$a['size'].'">';
			} else {
				$output = '<table class="pricing">';
			}
			if (isset($a['title'])) {
				$output .= '<thead><tr><th colspan="2">'.$a['title'].'</th></tr></thead>';
			}
				$output .= '<tbody>'.do_shortcode($content).'</tbody>';
				$output .= '</table>';
			}
		
		return $output;
		
		}
	}
	
	add_shortcode('service_item', 'service_item');
	
	//Table body (service title and price)
	if (!function_exists('service_item')) {
		function service_item($atts, $content = null) {
			$a = shortcode_atts(
				array(
					'service_title' => '', // table size
					'service_price' => '' // table heading title
				), $atts);
	
			if (isset($a['service_title']) || isset($a['service_price'])) {
				$output =	'<tr>';
				if (isset($a['service_title'])) {
					$output .=	'<td class="item">'.$a['service_title'].'</td>';
				}
				if (isset($atts['service_price'])) {
					$output .= '<td class="price">'.$atts['service_price'].'</td>';
				}
				$output .= '</tr>';
			}
			
			return $output;	
		}
	}
?>