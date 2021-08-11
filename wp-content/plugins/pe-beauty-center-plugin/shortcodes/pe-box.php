<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/
 
/*-----------------------------------------------------------------------------------*/
/*  PE Box
/*-----------------------------------------------------------------------------------*/
		add_shortcode('box', 'pe_box');
		if (!function_exists('pe_box')) {
				function pe_box($atts, $content = null ) {
						$a = shortcode_atts(
								array(
										'style' => 'light',
										'icon' => '',
										'link' => '',
										'imgsrc' => '',
										'alt' => '',
										'title' => '',
										'subtitle' => '',
										'price' => '',
										'text' => '',
								), $atts);
						
						$output = '<div class="pe-'.$a['style'].'-box">';
						if(empty($a['icon'])) {
								$output .= '<div class="pe-box">';
						} else {
								$output .= '<div class="pe-box '.$a['icon'].'">';
						}
						$output .= '<a href="'.$a['link'].'">';
						if(!empty($a['imgsrc'])) {
								$output .= '<span class="image"><img src="'.$a['imgsrc'].'" alt="'.$a['alt'].'" /></span>';
						}
						$output .= '<span class="description">';
						
						if(!empty($a['subtitle']) || !empty($a['title'])) {
							$output .= '<span class="box-title">';
							if(!empty($a['subtitle'])) {
									$output .= '<span class="subtitle">'.$a['subtitle'].'</span>';
							}
							if(!empty($a['title'])) {
									$output .= '<span class="title">'.$a['title'].'</span>';
							}
							$output .= '</span>';
						}
						
						if(!empty($a['price'])) {
								$output .= '<span class="price">'.$a['price'].'</span>';
						}
						if(!empty($a['text'])) {
								$output .= '<span class="text">'.$a['text'].'</span>';
						}
						$output .= '</span>';
						$output .= '</a>';
						$output .= '</div>';
						$output .= '</div>';
				    
				    return $output;
				}
		}
?>