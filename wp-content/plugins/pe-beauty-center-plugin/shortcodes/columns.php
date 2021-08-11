<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/
 
/*-----------------------------------------------------------------------------------*/
/*  Bootstrap Columns
/*-----------------------------------------------------------------------------------*/
		add_shortcode('row', 'pe_row');
		if (!function_exists('pe_row')) {
				function pe_row($atts, $content = null ) {
		    		return '<div class="row">'.do_shortcode($content).'</div>';
				}
		}

		add_shortcode('col', 'pe_columns');
		if (!function_exists('pe_columns')) {
				function pe_columns($atts, $content = null) {  
				    $a = shortcode_atts(array(  
				        'size' => '12',
				        'screen' => 'md'
				    ), $atts);  
				    
				    return '<div class="col-'.$a['screen'].'-'.$a['size'].'">'.do_shortcode($content).'</div>';
				}
		}
?>