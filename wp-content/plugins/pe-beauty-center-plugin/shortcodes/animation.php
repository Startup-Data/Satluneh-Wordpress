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
		add_shortcode('first_box', 'pe_animated_first');
		if (!function_exists('pe_animated_first')) {
				function pe_animated_first($atts, $content = null ) {
						$a = shortcode_atts(
								array(
										'imagebg' => '',
										'link' => '',
										'firsttitle' => '',
										'secondtitle' => ''
								), $atts);
				    
				    $output = '<div class="ch-item ch-first" style="background: url(\''.$a['imagebg'].'\') no-repeat;">';
				    $output .= '<div class="ch-info"> <div class="ch-container"> <div class="ch-outer"> <div class="ch-inner"> <p>';
						$output .= '<a href="'.$a['link'].'">';
						if(!empty($a['firsttitle'])) {
							$output .= $a['firsttitle'].'<br />';
						}
						if(!empty($a['secondtitle'])) {
							$output .= '<span class="smaller">'.$a['secondtitle'].'</span>';
						}
						$output .= '</a>';
				    $output .= 	'</p> </div>	</div> </div> </div>';
						$output .= '</div>';
						
				    return $output;
				}
		}
		
		add_shortcode('second_box', 'pe_animated_second');
		if (!function_exists('pe_animated_second')) {
				function pe_animated_second($atts, $content = null ) {
						$a = shortcode_atts(
								array(
										'imagebg' => '',
										'link' => '',
										'firsttitle' => '',
										'secondtitle' => ''
								), $atts);
				    
				    $output = '<div class="ch-item ch-second" style="background: url(\''.$a['imagebg'].'\') no-repeat;">';
				    $output .= '<div class="ch-info-wrap"> <div class="ch-info"> <div class="ch-info-front"> </div> <div class="ch-info-back"> <div class="ch-container"> <div class="ch-outer"> <div class="ch-inner"> <p>';
						$output .= '<a href="'.$a['link'].'">';
						if(!empty($a['firsttitle'])) {
							$output .= $a['firsttitle'].'<br />';
						}
						if(!empty($a['secondtitle'])) {
							$output .= '<span class="smaller">'.$a['secondtitle'].'</span>';
						}
						$output .= '</a>';
				    $output .= 	'</p> </div> </div> </div> </div> </div> </div>';
						$output .= '</div>';
						
				    return $output;
				}
		}

		add_shortcode('third_box', 'pe_animated_third');
		if (!function_exists('pe_animated_third')) {
				function pe_animated_third($atts, $content = null ) {
						$a = shortcode_atts(
								array(
										'imagebg' => '',
										'link' => '',
										'firsttitle' => '',
										'secondtitle' => ''
								), $atts);
				    
				    $output = '<div class="ch-item ch-third"> <div class="ch-info">';
				    $output .= '<div class="ch-info-front" style="background: url(\''.$a['imagebg'].'\') no-repeat;"> </div>';
				    $output .= '<div class="ch-info-back"> <div class="ch-container"> <div class="ch-outer"> <div class="ch-inner"> <p>';
						$output .= '<a href="'.$a['link'].'">';
						if(!empty($a['firsttitle'])) {
							$output .= $a['firsttitle'].'<br />';
						}
						if(!empty($a['secondtitle'])) {
							$output .= '<span class="smaller">'.$a['secondtitle'].'</span>';
						}
						$output .= '</a>';
				    $output .= 	'</p> </div> </div> </div> </div>';
						$output .= '</div> </div>';
						
				    return $output;
				}
		}

		add_shortcode('video_box', 'pe_animated_video');
		if (!function_exists('pe_animated_video')) {
				function pe_animated_video($atts, $content = null ) {
						$a = shortcode_atts(
								array(
										'imagebg' => '',
										'alt' => '',
										'link' => '',
										'width' => '800',
										'height' => '600',
										'title' => '',
								), $atts);
				    
				    $output = '<div class="view view-video">';
				    $output .= '<img src="'.$a['imagebg'].'" alt="'.$a['alt'].'" />';
				    $output .= '<div class="mask"> <span class="space"> &nbsp; </span>';
						$output .= '<a class="readmore" href="'.$a['link'].'" rel="{handler:\'iframe\', size:{x:'.$a['width'].', y:'.$a['height'].'}}">';
						if(!empty($a['title'])) {
							$output .= '<span>'.$a['title'].'</span>';
						}
						$output .= '</a>';
				    $output .= '</div>';
						$output .= '</div>';
						
				    return $output;
				}
		}
?>