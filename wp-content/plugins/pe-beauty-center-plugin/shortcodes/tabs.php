<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/
 
/*-----------------------------------------------------------------------------------*/
/*  Tabs
/*-----------------------------------------------------------------------------------*/
		$tabs_divs = '';
		// tabs navigation and tab content wrapper
		add_shortcode('tabs', 'tabs_group');
		if (!function_exists('tabs_group')) {
				function tabs_group($atts, $content = null ) {
		    		global $tabs_divs;
				
				    $tabs_divs = '';
				
				    $output = '<div id="tab-side-container"><ul class="nav nav-tabs" role="tablist"';
				    $output.='>'.do_shortcode($content).'</ul></div>';
				    $output.= '<div id="myTabContent" class="tab-content">'.$tabs_divs.'</div>';
				
				    return $output;
				}
		}

		// tab navigation and tab content
		add_shortcode('tab', 'tab_item');
		if (!function_exists('tab_item')) {
				function tab_item($atts, $content = null) {  
				    global $tabs_divs;
				
				    $a = shortcode_atts(array(  
				        'id' => '',
				        'title' => '',
				        'status' => '',
				    ), $atts);  
				
				    if(empty($a['id']))
			    			$a['id'] = 'side-tab'.rand(100,999);
				
				    $output = '
				        <li role="presentation" class="'.$a['status'].'">
				            <a href="#'.$a['id'].'" aria-controls="'.$a['id'].'" role="tab" data-toggle="tab">'.$a['title'].'</a>
				        </li>
				    ';
				
				    $tabs_divs.= '<div role="tabpanel" class="tab-pane fade in '.$a['status'].'" id="'.$a['id'].'">'.do_shortcode($content).'</div>'; // accepts [pe_shortcodes] for each tab item
				
				    return $output;
				}
		}
?>