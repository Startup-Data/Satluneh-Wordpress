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
		add_shortcode('pe_video', 'video_shortcode');
		if (!function_exists('video_shortcode')) {
				function video_shortcode($atts, $content = null ) {
						$a = shortcode_atts(array(  
				        'web' => 'youtube',
				        'id' => '',
				        'fs' => '1',
				        'size' => ''
				    ), $atts);
						
						if ($a['fs'] == 1) {
								$videofs = 'webkitallowfullscreen mozallowfullscreen allowfullscreen';
						} else {
								$videofs = ' ';
						}

						if (!empty($a['size'])) {
							$output = '<div class="col-md-'.$a['size'].'">';
						} else {
							$output = '<div class="col-md-12">';
						}
						$output .= '<figure class="pe_video">';
						if ($a['web'] == 'youtube') {
							$output .= '<iframe src="//www.youtube.com/embed/'.$a['id'].'" '.$videofs.' style="width:100%;" >';
							$output .= '</iframe>';
						} else if ($a['web'] == 'vimeo') {
							$output .= '<iframe src="//player.vimeo.com/video/'.$a['id'].'" '.$videofs.' style="width:100%;" >';
							$output .= '</iframe>';
						} else if ($a['web'] != 'vimeo' || $a['web'] != 'youtube') {
							$output .= __('If you want to use PE Video shortcode than it is required that you provide ...','PixelEmu');
						}
						$output .= '</figure>';
						$output .= '</div>';
				
				    return $output;
				}
		}
?>