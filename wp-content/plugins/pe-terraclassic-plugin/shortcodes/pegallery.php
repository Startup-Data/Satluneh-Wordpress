<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*  Image Gallery
/*-----------------------------------------------------------------------------------*/

// remove default wordpress shortcode
remove_shortcode('gallery', 'gallery_shortcode');
remove_shortcode('gallery', 'wp_shortcode_gallery');

// add modified gallery shortcode
add_shortcode('gallery', 'pe_gallery_shortcode');
add_shortcode('pegallery', 'pe_gallery_shortcode');

function pe_gallery_shortcode($attr) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) ) {
			$attr['orderby'] = 'post__in';
		}
		$attr['include'] = $attr['ids'];
	}

	$output = apply_filters( 'post_gallery', '', $attr, $instance );
	if ( $output != '' ) {
		return $output;
	}

	$atts = shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => 'figure',
		'icontag'    => 'div',
		'captiontag' => 'figcaption',
		'columns'    => 3,
		'size'       => 'medium',
		'include'    => '',
		'exclude'    => '',
		'link'       => 'none',
		'modal'      => ''
	), $attr, 'pegallery' );

	$id = intval( $atts['id'] );

	if ( ! empty( $atts['include'] ) ) {
		$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( ! empty( $atts['exclude'] ) ) {
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	} else {
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	}

	if ( empty( $attachments ) ) {
		return;
	}

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) {
			$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
		}
		return $output;
	}

	$itemtag = tag_escape( $atts['itemtag'] );
	$captiontag = tag_escape( $atts['captiontag'] );
	$icontag = tag_escape( $atts['icontag'] );

	$columns = intval( $atts['columns'] );
	$span = 12 / $columns;

	$selector = "gallery-{$instance}";
	$size_class = sanitize_html_class( $atts['size'] );
	$modal_enabled = ( !empty( $atts['modal'] && ($atts['modal'] === 'enable' || $atts['modal'] === 'true' || $atts['modal'] === '1') ) ) ? true : false;

	$output = "<div id='pe-{$selector}' class='pe-gallery pe-gallery-{$id} columns-{$columns} img-size-{$size_class}'><div class='pe-row'>";
	$i = 0;
	foreach ( $attachments as $id => $attachment ) {

		if ( trim( $attachment->post_excerpt ) ) {
			$attr = array( 'data-no-retina' => '', 'aria-describedby' => "$selector-$id" );
		} else {
			$attr = array( 'data-no-retina' => '' );
		}

		if( ! $modal_enabled ) { //modal not enabled
			if( !empty($atts['link']) && $atts['link'] == 'file' ) { //media file
				$attachment_url = wp_get_attachment_url( $id );
				$image_output = '<a href="' . $attachment_url . '">' . wp_get_attachment_image( $id, $atts['size'], false, $attr ) . '</a>';
			} elseif( !empty($atts['link']) && $atts['link'] == 'none' ) { //none
				$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
			} else { //attachment page
				$attachment_url = get_attachment_link($id);
				$image_output = '<a href="' . $attachment_url . '">' . wp_get_attachment_image( $id, $atts['size'], false, $attr ) . '</a>';
			}
		} else { //modal enabled (no need to display links)
			$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
		}
		
		$image_meta  = wp_get_attachment_metadata( $id );

		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
		}

		$modalData = '';
		$modalTrigger = '';
		if ( $modal_enabled ) {
			$modalData = "data-mfp-src='#modal-$selector-$id'";
			$modalTrigger = 'pe-gallery-modal';
		}

		$output .= "<div class='col-md-{$span}'>";

			$output .= "<{$itemtag} tabindex='0' class='pe-gallery-item {$modalTrigger}' {$modalData}>";

			$output .= "<{$icontag} class='pe-gallery-image {$orientation}'>
							$image_output
						</{$icontag}>";

			if ( $captiontag && trim( $attachment->post_excerpt ) ) {
				$output .= "<{$captiontag} class='wp-caption-text pe-gallery-caption'>
								" . wptexturize( $attachment->post_excerpt ) . "
							</{$captiontag}>";
			}

		$output .= "</{$itemtag}>";

		// Modal
		if ( $modal_enabled ) {

			$image_src = wp_get_attachment_image_src( $id, 'full', false, $attr );
			$image_width = $image_src[1];
			$modalWidth = ( !empty($image_width) ) ? "style='max-width: " . intval($image_width) . "px;" : "";

			if( !empty($atts['link']) && $atts['link'] == 'file' ) { //media file
				$attachment_url = wp_get_attachment_url( $id );
				$image_full = '<a href="' . $attachment_url . '">' . wp_get_attachment_image( $id, 'full', false, $attr ) . '</a>';
			} elseif( !empty($atts['link']) && $atts['link'] == 'none' ) { //none
				$image_full = wp_get_attachment_image( $id, 'full', false, $attr );
			} else { //attachment page
				$attachment_url = get_attachment_link($id);
				$image_full = '<a href="' . $attachment_url . '">' . wp_get_attachment_image( $id, 'full', false, $attr ) . '</a>';
			}

			$output .= "<div id='modal-{$selector}-{$id}' class='mfp-modal-content mfp-hide' tabindex='-1' role='dialog' aria-labelledby='{$selector}-{$id}' {$modalWidth}>";
				$output .= "<h4 id='{$selector}-{$id}'>" . $attachment->post_title . "</h4>";
				$output .= "<div class='pe-gallery-full-image'>{$image_full}</div>";
				$output .= "<p>" . wptexturize( $attachment->post_excerpt ) . "</p>";
			$output .= "</div>";
		}

		$output .= "</div>";

	}

	$output .= "</div></div>\n";

	return $output;
}

//Hook gallery settings
add_action('print_media_templates', function(){
	?>
	<script type="text/html" id="tmpl-pe-gallery-setting">
		<label class="setting">
			<span><?php _e('Image Modal', 'pe-terraclassic-plugin'); ?></span>
			<select data-setting="modal">
				<option value="enable"> <?php _e('Enable', 'pe-terraclassic-plugin'); ?> </option>
				<option value="disable"> <?php _e('Disable', 'pe-terraclassic-plugin'); ?> </option>
			</select>
		</label>
	</script>

	<script>

		jQuery(document).ready(function(){

			// add your shortcode attribute and its default value to the
			// gallery settings list; $.extend should work as well...
			_.extend(wp.media.gallery.defaults, {
				modal: 'Enable'
			});

			// merge default gallery settings template with yours
			wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
				template: function(view){
					return wp.media.template('gallery-settings')(view)
							 + wp.media.template('pe-gallery-setting')(view);
				}
			});

		});

	</script>
	<?php

});

?>