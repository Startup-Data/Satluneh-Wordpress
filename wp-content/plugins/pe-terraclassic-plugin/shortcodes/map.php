<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Google Map
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'pe_map_get_coordinates' ) ) {
	function pe_map_get_coordinates( $address, $force_refresh = false ) {

		$address_hash = md5( $address );

		$coordinates = get_transient( $address_hash );

		if ( $force_refresh || $coordinates === false ) {

			$args     = array( 'address' => urlencode( $address ), 'sensor' => 'false' );
			$url      = add_query_arg( $args, 'http://maps.googleapis.com/maps/api/geocode/json' );
			$response = wp_remote_get( $url );

			if ( is_wp_error( $response ) ) {
				return __( 'Error 0 : ', 'pe-terraclassic-plugin' ) . $response;
			}

			$data = wp_remote_retrieve_body( $response );

			if ( is_wp_error( $data ) ) {
				return __( 'Error 1 : ', 'pe-terraclassic-plugin' ) . $data;
			}

			if ( $response['response']['code'] == 200 ) {

				$data = json_decode( $data );

				if ( $data->status === 'OK' ) {

					$coordinates = $data->results[0]->geometry->location;

					$cache_value['lat']     = $coordinates->lat;
					$cache_value['lng']     = $coordinates->lng;
					$cache_value['address'] = (string) $data->results[0]->formatted_address;

					// cache coordinates
					set_transient( $address_hash, $cache_value, 3600 * 24 * 30 * 1 );
					$data = $cache_value;

				} elseif ( $data->status === 'ZERO_RESULTS' ) {
					return __( 'Invalid address.', 'pe-terraclassic-plugin' );
				} elseif ( $data->status === 'INVALID_REQUEST' ) {
					return __( 'Invalid request.', 'pe-terraclassic-plugin' );
				} else {
					return __( 'Please ensure you have entered the short code correctly.', 'pe-terraclassic-plugin' );
				}

			} else {
				return __( 'Unable to connect with Google API service.', 'pe-terraclassic-plugin' );
			}

		} else {
			$data = $coordinates;
		}

		return $data;
	}
}

add_shortcode( 'map', 'pe_map_shortcode' );

if ( ! function_exists( 'pe_map_shortcode' ) ) {
	function pe_map_shortcode( $atts ) {

		$atts = shortcode_atts(
			array(
				'address'           => '',
				'latitude'          => false,
				'longitude'         => false,
				'width'             => '100%',
				'height'            => '400px',
				'enablescrollwheel' => 'false',
				'disablecontrols'   => 'false',
				'zoom'              => 16,
				'tooltip'           => 'disable',
			),
			$atts
		);

		$address = ( ! empty( $atts['address'] ) ) ? esc_attr( $atts['address'] ) : false;
		$tooltip = ( ! empty( $atts['tooltip'] ) && $atts['tooltip'] == 'disable' ) ? 'disable' : $atts['tooltip'];

		$longi = ( ! empty( $atts['longitude'] ) ) ? $atts['longitude'] : false;
		$lati  = ( ! empty( $atts['latitude'] ) ) ? $atts['latitude'] : false;

		if ( $address || ( $lati && $longi ) ) :

			if ( $lati && $longi ) {
				$coordinates['lat'] = $lati;
				$coordinates['lng'] = $longi;
			} elseif ( $address ) {
				$coordinates = pe_map_get_coordinates( $address );
			}

			if ( ! is_array( $coordinates ) ) {
				return __( 'You must provide valid address or coordinates (1)', 'pe-terraclassic-plugin' );
			}

			$map_id = uniqid( 'map' ); // generate a unique ID for this map

			ob_start();
			?>

			<div class="pe_map_canvas" id="<?php echo esc_attr( $map_id ); ?>" style="height: <?php echo esc_attr( $atts['height'] ); ?>; width: <?php echo esc_attr( $atts['width'] ); ?>"></div>

			<script type="text/javascript">

				var options = {
					zoom: <?php echo esc_js( $atts['zoom'] ); ?>,
					center: new google.maps.LatLng('<?php echo esc_js( $coordinates['lat'] ); ?>', '<?php echo esc_js( $coordinates['lng'] ); ?>'),
					scrollwheel: <?php echo 'true' === strtolower( $atts['enablescrollwheel'] ) ? '1' : '0'; ?>,
					disableDefaultUI: <?php echo 'true' === strtolower( $atts['disablecontrols'] ) ? '1' : '0'; ?>,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				}

				pe_init_map('<?php echo $map_id; ?>', options, '<?php echo esc_js( $coordinates['lat'] ); ?>', '<?php echo esc_js( $coordinates['lng'] ); ?>', '<?php echo esc_js( $atts['tooltip'] ); ?>');

			</script>
			<?php
			return ob_get_clean();
		else :
			return __( 'You must provide valid address or coordinates (2)', 'pe-terraclassic-plugin' );
		endif;
	}
}

//add css
function pe_map_css() {
	$css = '.pe_map_canvas img { max-width: none; }';
	wp_add_inline_style( 'style', $css );
}

add_action( 'wp_enqueue_scripts', 'pe_map_css', 15 );

?>
