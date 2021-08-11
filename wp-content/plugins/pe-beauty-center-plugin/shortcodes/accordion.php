<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Accordion
/*-----------------------------------------------------------------------------------*/

		add_shortcode('accordion', 'pe_accordion_group');
		
		// Accordion group
		if (!function_exists('pe_accordion_group')) {
				function pe_accordion_group($atts, $content = null) {
						global $unID;
						
						$a = shortcode_atts(
								array(
										'tabid' => 'pe-accordion'
								), $atts);
				
						$unID = $a['tabid'];
				
						$output = '<div class="panel-group" id="'.$unID.'" role="tablist" aria-multiselectable="true">';
						$output .= do_shortcode($content);
						$output .= '</div>';
						
						return $output;
				}
		} 

	add_shortcode('accordion_content', 'pe_accordion_content');
	
	//Accordion group container
		if (!function_exists('pe_accordion_content')) {
				function pe_accordion_content($atts, $content = null) {
						global $unID;
						$a = shortcode_atts(
								array(
										'headerid' => '',
										'target'	=> '',
										'active' => 0,
										'title' =>'',
								), $atts);
						
						if(empty($a['headerid']))
					  		$a['headerid'] = 'pe-heading'.rand(100,999);
						
						if(empty($a['target']))
					  		$a['target'] = 'pe-accordion'.rand(100,999);
			
				$output = '<div class="panel pe-panel">';
				if ($a['active'] == 1) {
						$output .= '<div id="'.$a['headerid'].'" class="panel-heading" role="tab">';
						$output .= '<h4 class="panel-title"><a class="" role="button" data-toggle="collapse" data-parent="#'.$unID.'" href="#'.$a['target'].'" aria-expanded="false" aria-controls="'.$a['target'].'">'.$a['title'].'</a></h4>';
						$output .= '</div>';
						$output .= '<div style="" aria-expanded="false" id="'.$a['target'].'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="'.$a['headerid'].'">';
						$output .= '<div class="panel-body">'.do_shortcode($content).'</div>'; // accepts [pe_shortcodes] for each accordion item
						$output .= '</div>';
				} else {
						$output .= '<div id="'.$a['headerid'].'" class="panel-heading" role="tab">';
						$output .= '<h4 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#'.$unID.'" href="#'.$a['target'].'" aria-expanded="false" aria-controls="'.$a['target'].'">'.$a['title'].'</a></h4>';
						$output .= '</div>';
						$output .= '<div style="height: 0px;" aria-expanded="false" id="'.$a['target'].'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="'.$a['headerid'].'">';
						$output .= '<div class="panel-body">'.do_shortcode($content).'</div>'; // accepts [pe_shortcodes] for each accordion item
						$output .= '</div>';
				}
				$output .= '</div>';
				
				return $output;
				}
		} 
?>