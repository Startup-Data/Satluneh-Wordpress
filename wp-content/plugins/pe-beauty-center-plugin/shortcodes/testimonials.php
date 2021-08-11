<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/
 
/*-----------------------------------------------------------------------------------*/
/*  Testimonial
/*-----------------------------------------------------------------------------------*/
		add_shortcode('testimonial', 'pe_testimonial_shortcode');
		if (!function_exists('pe_testimonial_shortcode')) {
				function pe_testimonial_shortcode($atts, $content = null ) {
						$a = shortcode_atts(
								array(
										'class' => '',
										'title' => '',
										'subtitle' => ''
								), $atts);
				    
				    $output = '<div class="pe-testimonials '.$a['class'].'">';
				    $output .= '<div class="pe-custom-text">';
						$output .= do_shortcode($content);
						$output .= '</div>';
				    $output .= '<div class="pe-custom-title">'.$a['title'].'</div>';
						$output .= '<div class="pe-custom-subtitle">'.$a['subtitle'].'</div>';
						$output .= '</div>';
						
				    return $output;
				}
		}
?>