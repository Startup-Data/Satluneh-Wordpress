<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Load Required CSS Styles
/*-----------------------------------------------------------------------------------*/
	if(!function_exists('load_theme_styles')) {
			function load_theme_styles() {
					if (!is_admin()){

						// register styles
						wp_register_style('bootstrap',  get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css', array(), '3.3.5', 'all');
						wp_register_style('bootstrap_override',  get_template_directory_uri() . '/css/bootstrap_overrides.css', array(), '1.0', 'all');
						wp_register_style('fontawesome',  get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.3.0', 'all');
						wp_register_style('theme',  get_template_directory_uri() . '/css/template.css', array(), '1.0', 'all');
						wp_register_style('offcanvas',  get_template_directory_uri() . '/css/offcanvas.css', array(), '1.0', 'all');
						wp_register_style('comingsoon',  get_template_directory_uri() . '/css/comingsoon.css', array(), '1.0', 'all');
	
						
						// enqueue bootstrap styles
						wp_enqueue_style('bootstrap');
						wp_enqueue_style('bootstrap_override');

						// font awesomne
						wp_enqueue_style('fontawesome');

						// enqueue theme styles
						wp_enqueue_style('theme');
						wp_enqueue_style('offcanvas');
						
						
						
						if (!is_user_logged_in() && ($GLOBALS['comingsoonmode'] == 'on') && ($GLOBALS['otdateFormat'] !='') && $GLOBALS['futuredate'] == 1) {

							wp_enqueue_style('comingsoon');

						}

					}
			}
	}
	add_action('wp_enqueue_scripts', 'load_theme_styles');

	function load_admin_styles() {		

    	wp_enqueue_style( 'pe_admin', get_template_directory_uri() . '/css/pe-admin.css', array(), '1.0', 'all' );
	
	}
	add_action( 'admin_enqueue_scripts', 'load_admin_styles' );
	

/*-----------------------------------------------------------------------------------*/
/*	Load Required JS Scripts
/*-----------------------------------------------------------------------------------*/
	if(!function_exists('load_theme_scripts')){
	    function load_theme_scripts(){
	        if (!is_admin()) {
	
	        // Defining scripts directory url
	        $java_script_url = get_template_directory_uri().'/js/';
			// API key for Google Map	
			$googleMapKey = ( ot_get_option('map_api_key') ) ? '?key=' . ot_get_option('map_api_key') : '';
			
			wp_register_script('bootstrap.min', get_template_directory_uri().'/bootstrap/js/bootstrap.min.js', array('jquery'), true);
	        wp_register_script('jqvalidate', $java_script_url.'jquery.validate.min.js', array('jquery'), '1.14.0', false);
          	wp_register_script('jqform', $java_script_url.'jquery.form.js', array('jquery'), '3.51', false);
			
			//wp_register_script('google-map-api', '//maps.googleapis.com/maps/api/js', array(), '', false);
			wp_register_script('theme_script', $java_script_url.'theme_script.js', array('jquery'), '1.0', false);
					
			// enqueue bootstrap scripts
			wp_enqueue_script('bootstrap.min');
					
			// enqueue theme scripts
	        wp_enqueue_script('jqvalidate');
          	wp_enqueue_script('jqform');
			wp_enqueue_script( 'google-maps-api', '//maps.googleapis.com/maps/api/js' . $googleMapKey, array(), '', false);
			wp_enqueue_script('theme_script');
		    if ( is_singular() && comments_open() ){
		        wp_enqueue_script( 'comment-reply' );
		    }
          }
      }
  }
  add_action('wp_enqueue_scripts', 'load_theme_scripts');
	
?>