<?php
/**
 * Plugin Name: PE Best Features
 * Plugin URI:  https://pixelemu.com
 * Description: Widget
 * Version:     1.00
 * Author:      artur.kaczmarek@pixelemu.com
 * Author URI:  https://www.pixelemu.com
 * Text Domain: pe-simple
 * License:     GPLv2 or later
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // disable direct access
}

if ( ! class_exists( 'PE_Best_Features' ) ) {
	class PE_Best_Features extends WP_Widget {

		function __construct() {
			$widget_ops = array(
				'classname'   => 'pe-widget-best-features',
				'description' => __( 'Displays custom text.', 'pe-terraclassic-plugin' )
			);
			parent::__construct( 'PE_Best_Features', __( 'PE Best Features', 'pe-terraclassic-plugin' ), $widget_ops );

			add_action( 'admin_enqueue_scripts', array( $this, 'adminJS' ) );

		}

		// ---------------------------------------------------------------
		// Widget
		// ---------------------------------------------------------------

		public function widget( $args, $setup ) {
			extract( $args );

			$title = apply_filters( 'widget_title', $setup['title'] );
			if ( empty( $title ) ) {
				$title = false;
			}

			$widget_id   = $this->number;
			$widget_name = $this->id;

			$image     = ( ! empty( $setup['image_file'] ) ) ? $setup['image_file'] : '';
			$style      = ( ! empty( $setup['style'] ) ) ? $setup['style'] : 1;
			$view      = ( ! empty( $setup['view'] ) ) ? $setup['view'] : 1;
			$span_size = ( ! empty( $setup['span_size'] ) ) ? $setup['span_size'] : 0;

			// before widget
			echo $before_widget;

			// title
			if ( $title ):
				echo $before_title;
				echo $title;
				echo $after_title;
			endif;

			$dataArray = ( ! empty( $setup['data'] ) ) ? json_decode( $setup['data'] ) : false;

			if ( $dataArray ) {
				$output = array();
				foreach ( $dataArray as $items => $fields ) {
					$itemArr = array();
					foreach ( $fields as $field => $item ) {
						$key             = $item->name;
						$value           = $item->value;
						$itemArr[ $key ] = $value;
					}
					$output[] = $itemArr;
				}
			}

			$items = count( $output );
			$i     = 0;

			$error = '<p class="pe-alert"> ' . __( 'No items', 'pe-terraclassic-plugin' ) . ' </p>';

			if ( $items == 0 ) {
				echo $error;

				return;
			}

			$firsthalf  = array();
			$secondhalf = array();

			foreach ( $output as $k => $v ) {
				if ( $k % 2 == 0 ) {
					$firsthalf[] = $v;
				} else {
					$secondhalf[] = $v;
				}
			}

			if ( ! function_exists( 'pe_best_feature_items' ) ) {
				function pe_best_feature_items( $array ) {

					if ( empty( $array ) ) {
						return;
					}

					$i    = 0;
					$html = '';

					foreach ( $array as $item ) {

						$i ++;

						$html .= '<div class="pe-items-outer"><div class="pe-item item-' . $i . '">';

						if ( $item['icon'] && $item['source'] == 'icon') {
							$html .= '<div class="pe-icon"><span class="' . $item['icon'] . '"></span></div>';
						}
						//echo '<pre>';
						//print_r($item);
						//echo '</pre>';
						if ( $item['item_image'] && $item['source'] == 'item_image') {
							$html .= '<div class="pe-item-image"><img src="' . $item['item_image'] . '" alt="' . $item['name'] . ' icon" /></div>';
						}

						if ( $item['name'] || $item['text'] ) {
							$html .= '<div class="pe-title-text">';
						}
						
						if ( $item['name'] ) {
							$html .= '<div class="pe-title">';
							if ( $item['url'] ) {
								$html .= '<a href="' . $item['url'] . '">';
							}

							$html .= $item['name'];

							if ( $item['url'] ) {
								$html .= '</a>';
							}
							$html .= '</div>';
						}

						if ( $item['text'] ) {
							$html .= '<div class="pe-text">' . htmlentities($item['text']) . '</div>';
						}

						if ( $item['name'] || $item['text'] ) {
							$html .= '</div>';
						}
						
						$html .= '</div></div>';
					}

					return $html;

				}
			}

			//ordering

			/*
			1. text img text
			2. img text text
			3. text text img
			4. text img
			5. img text
			*/

			$image_span = ( ! empty( $image ) && isset( $span_size ) ) ? (int) $span_size : 0;
			$alt        = '';

			$isImg    = ( ! empty( $image ) ) ? true : false;
			$isSecond = ( $items > 1 ) ? true : false;

			//spans
			if ( $view == 1 || $view == 2 || $view == 3 ) {
				$col_span = ( $isSecond ) ? floor( ( 12 - $image_span ) / 2 ) : floor( 12 - $image_span );
			} elseif ( $view == 4 || $view == 5 ) {
				$col_span = floor( 12 - $image_span );
			}

			//content
			$img_content    = ( $isImg ) ? '<div class="image-col col-md-' . $image_span . '"><img alt="' . $alt . '" src="' . $image . '"></div>' : false;
			$first_content  = '<div class="first-half col-md-' . $col_span . '">' . pe_best_feature_items( $firsthalf ) . '</div>';
			$second_content = ( $isSecond ) ? '<div class="second-half col-md-' . $col_span . '">' . pe_best_feature_items( $secondhalf ) . '</div>' : false;
			$all_content    = '<div class="all-items col-md-' . $col_span . '">' . pe_best_feature_items( $output ) . '</div>';

			if ( $view == 1 ) { //1. text img text

				$col1_content = $first_content;
				$col2_content = $img_content;
				$col3_content = $second_content;

			} elseif ( $view == 2 ) { //2. img text text

				$col1_content = $img_content;
				$col2_content = $first_content;
				$col3_content = $second_content;

			} elseif ( $view == 3 ) { //3. text text img

				$col1_content = $first_content;
				$col2_content = $second_content;
				$col3_content = $img_content;

			} elseif ( $view == 4 ) { //4. text img

				$col1_content = $all_content;
				$col2_content = $img_content;
				$col3_content = false;

			} elseif ( $view == 5 ) { //5. img text

				$col1_content = $img_content;
				$col2_content = $all_content;
				$col3_content = false;

			}

			//class
			$view_class = ( ! empty( $view ) ) ? 'view-' . $view : '';

			if ( $isImg ) {
				$view_class .= ' img';
			}
			if ( $isSecond ) {
				$view_class .= ' second';
			}


			?>

			<div class="pe-best-features <?php echo $view_class.' style'.$style; ?>">

				<div class="pe-best-features-in">
					<div class="pe-row">

						<?php

						if ( $col1_content ) {
							echo $col1_content;
						}

						if ( $col2_content ) {
							echo $col2_content;
						}

						if ( $col3_content ) {
							echo $col3_content;
						}

						?>

					</div>
				</div>

			</div>

			<?php
			// after widget
			echo $after_widget;

		}

		// ---------------------------------------------------------------
		// WIDGET FORM
		// ---------------------------------------------------------------

		public function form( $setup ) {
			$setup = wp_parse_args( (array) $setup, array(
				'title'      => '',
				'data'       => '',
				'image_file' => '',
				'view'       => '',
				'span_size'  => '',
			) );

			$title = $setup['title'];

			$data = ( ! empty( $setup['data'] ) ) ? $setup['data'] : '';

			$image     = ( ! empty( $setup['image_file'] ) ) ? $setup['image_file'] : '';
			$style      = ( ! empty( $setup['style'] ) ) ? $setup['style'] : 1;
			$view      = ( ! empty( $setup['view'] ) ) ? $setup['view'] : 1;
			$span_size = ( ! empty( $setup['span_size'] ) ) ? $setup['span_size'] : 0;

			?>
			<div id="<?php echo $this->id; ?>" class="multi-fields pe-widget-container">

				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'pe-terraclassic-plugin' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/>
				</p>

				<?php

				$dataArray = ( ! empty( $data ) ) ? json_decode( $data, true ) : false;

				if ( $dataArray ) {
					$count = 0;
					echo '<div class="pe-items"><ol>';
					foreach ( $dataArray as $item => $val ) {
						$name = ( ! empty( $val[0]['value'] ) ) ? esc_html( $val[0]['value'] ) : __( 'Item', 'pe-terraclassic-plugin' ) . ' #' . $count;
						echo '<li>' . $name . ' - <a href="#' . $count . '" data-item="' . $count . '" class="edit-item">' . __( 'Edit', 'pe-terraclassic-plugin' ) . '</a> | <a href="#' . $count . '" data-item="' . $count . '" class="remove-item">' . __( 'Remove', 'pe-terraclassic-plugin' ) . '</a> </li>';
						$count ++;
					}
					echo '</ol></div>';
				} ?>
				
					<!-- fields group -->

					<a class="add-new button button-primary purple" href="#"><?php _e( 'Add new item', 'pe-terraclassic-plugin' ); ?></a>

					<div class="pe-fields-group pe-best-features-item-group" style="display: none;">

						<p>
							<label for="name"><?php _e( 'Item title:', 'pe-terraclassic-plugin' ); ?></label>
							<input class="widefat" id="name" name="name" type="text" value=""/>
						</p>
						<p>
							<label for="url"><?php _e( 'URL:', 'pe-terraclassic-plugin' ); ?></label>
							<input class="widefat" id="url" name="url" type="text" value=""/>
						</p>
			            <p class="pe-best-features-source-selector">
			                <label for="<?php echo $this->get_field_id('source'); ?>"><?php _e('Source', 'pe-terraclassic-plugin'); ?></label>
			                <select class="pe-best-features-source-select" name="source">
			                    <option value="icon"><?php _e('Font Awesome icon', 'pe-terraclassic-plugin'); ?></option>
			                    <option value="item_image"><?php _e('Icon image', 'pe-terraclassic-plugin'); ?></option>
			                </select>
			            </p>
						<p class="source-icon">
							<label for="icon"><?php _e( 'Font Awesome icon class:', 'pe-terraclassic-plugin' ); ?></label>
							<input class="widefat" id="icon" name="icon" type="text" value=""/>
						</p>
						<p class="source-image">
							<label for="<?php echo $this->get_field_id( 'item_image' ); ?>"><?php _e( 'Icon image:', 'pe-terraclassic-plugin' ); ?></label>
							<input class="widefat" id="<?php echo $this->get_field_id( 'item_image' ); ?>" name="item_image" type="text" value=""/>
							<input class="media-item button" type="button" value="<?php _e( 'Select image', 'pe-terraclassic-plugin' ); ?>"/>
						</p>
						<p>
							<label for="text"><?php _e( 'Text:', 'pe-terraclassic-plugin' ); ?></label>
							<textarea class="widefat" id="text" name="text"></textarea>
						</p>

						<a class="save-item button button-primary green" href="#"><?php _e( 'Save item', 'pe-terraclassic-plugin' ); ?></a>
						<a class="cancel-item button button-primary red" href="#"><?php _e( 'Cancel', 'pe-terraclassic-plugin' ); ?></a>

					</div>                <!-- fields group -->

					<p>
						<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e( 'Style', 'pe-terraclassic-plugin' ); ?></label>
						<select class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>" style="width:100%;">
							<option value='1'<?php echo ( $style == 1 ) ? 'selected' : ''; ?>><?php _e( 'Style 1', 'pe-terraclassic-plugin' ); ?></option>
							<option value='2'<?php echo ( $style == 2 ) ? 'selected' : ''; ?>><?php _e( 'Style 2', 'pe-terraclassic-plugin' ); ?></option>
						</select>
					</p>
					<p>
						<label for="<?php echo $this->get_field_id( 'image_file' ); ?>"><?php _e( 'Image:', 'pe-terraclassic-plugin' ); ?></label>
						<input class="widefat" id="<?php echo $this->get_field_id( 'image_file' ); ?>" name="<?php echo $this->get_field_name( 'image_file' ); ?>" type="text" value="<?php echo $image; ?>"/>
						<input class="media-item button" type="button" value="<?php _e( 'Select image', 'pe-terraclassic-plugin' ); ?>"/>
					</p>

					<p>
						<label for="<?php echo $this->get_field_id( 'view' ); ?>"><?php _e( 'Layout', 'pe-terraclassic-plugin' ); ?></label>
						<select class="widefat" id="<?php echo $this->get_field_id( 'view' ); ?>" name="<?php echo $this->get_field_name( 'view' ); ?>" style="width:100%;">
							<option value='1'<?php echo ( $view == 1 ) ? 'selected' : ''; ?>><?php _e( '[text] [image] [text]', 'pe-terraclassic-plugin' ); ?></option>
							<option value='2'<?php echo ( $view == 2 ) ? 'selected' : ''; ?>><?php _e( '[image] [text] [text]', 'pe-terraclassic-plugin' ); ?></option>
							<option value='3'<?php echo ( $view == 3 ) ? 'selected' : ''; ?>><?php _e( '[text] [text] [image]', 'pe-terraclassic-plugin' ); ?></option>
							<option value='4'<?php echo ( $view == 4 ) ? 'selected' : ''; ?>><?php _e( '[text] [image]', 'pe-terraclassic-plugin' ); ?></option>
							<option value='5'<?php echo ( $view == 5 ) ? 'selected' : ''; ?>><?php _e( '[image] [text]', 'pe-terraclassic-plugin' ); ?></option>
						</select>
					</p>

					<p>
						<label for="<?php echo $this->get_field_id( 'span_size' ); ?>"><?php _e( 'Image size (span)', 'pe-terraclassic-plugin' ); ?></label>
						<select class="widefat" id="<?php echo $this->get_field_id( 'span_size' ); ?>" name="<?php echo $this->get_field_name( 'span_size' ); ?>" style="width:100%;">
							<option value='12'<?php echo ( $span_size == 12 ) ? 'selected' : ''; ?>><?php _e( 'col-md-12', 'pe-terraclassic-plugin' ); ?></option>
							<option value='11'<?php echo ( $span_size == 11 ) ? 'selected' : ''; ?>><?php _e( 'col-md-11', 'pe-terraclassic-plugin' ); ?></option>
							<option value='10'<?php echo ( $span_size == 10 ) ? 'selected' : ''; ?>><?php _e( 'col-md-10', 'pe-terraclassic-plugin' ); ?></option>
							<option value='9'<?php echo ( $span_size == 9 ) ? 'selected' : ''; ?>><?php _e( 'col-md-9', 'pe-terraclassic-plugin' ); ?></option>
							<option value='8'<?php echo ( $span_size == 8 ) ? 'selected' : ''; ?>><?php _e( 'col-md-8', 'pe-terraclassic-plugin' ); ?></option>
							<option value='7'<?php echo ( $span_size == 7 ) ? 'selected' : ''; ?>><?php _e( 'col-md-7', 'pe-terraclassic-plugin' ); ?></option>
							<option value='6'<?php echo ( $span_size == 6 ) ? 'selected' : ''; ?>><?php _e( 'col-md-6', 'pe-terraclassic-plugin' ); ?></option>
							<option value='5'<?php echo ( $span_size == 5 ) ? 'selected' : ''; ?>><?php _e( 'col-md-5', 'pe-terraclassic-plugin' ); ?></option>
							<option value='4'<?php echo ( $span_size == 4 ) ? 'selected' : ''; ?>><?php _e( 'col-md-4', 'pe-terraclassic-plugin' ); ?></option>
							<option value='3'<?php echo ( $span_size == 3 ) ? 'selected' : ''; ?>><?php _e( 'col-md-3', 'pe-terraclassic-plugin' ); ?></option>
							<option value='2'<?php echo ( $span_size == 2 ) ? 'selected' : ''; ?>><?php _e( 'col-md-2', 'pe-terraclassic-plugin' ); ?></option>
							<option value='1'<?php echo ( $span_size == 1 ) ? 'selected' : ''; ?>><?php _e( 'col-md-1', 'pe-terraclassic-plugin' ); ?></option>
						</select>
					</p>

					<!-- data holder -->
					<input class="data-holder" id="<?php echo $this->get_field_id( 'data' ); ?>" name="<?php echo $this->get_field_name( 'data' ); ?>" type="hidden" value='<?php echo $data; ?>'/>

					<?php
						$saved_id = ( $this->number == '__i__' ) ? 'false' : '"' . $this->id . '"';
					?>
				
					<script>
						jQuery(document).ready(function() {
							var init_widget = false;
							var widget_id = <?php echo $saved_id; ?>;
	
							if( widget_id ) {
								init_widget = new PEwidget('#' + widget_id);
							}
	
							jQuery(document).on('widget-added', function(event, widget){
									widget_id = jQuery(widget).find('.multi-fields').attr('id');
									if( widget_id && !jQuery(widget).hasClass('latest-added') ) {
										init_widget = new PEwidget('#' + widget_id);
										jQuery('#widgets-right .widget').removeClass('latest-added');
										jQuery(widget).addClass('latest-added');
									}
							});
	
							jQuery(document).on('widget-updated', function(event, widget){
								if( init_widget ) {
									init_widget.showtime();
								}
							});
						});
					</script>

			</div>
			<?php
		}

		// ---------------------------------------------------------------
		// WIDGET UPDATE
		// ---------------------------------------------------------------

		public function update( $new_setup, $old_setup ) {
			$setup = $old_setup;

			$setup['title'] = strip_tags( $new_setup['title'] );
			$setup['data']  = strip_tags( $new_setup['data'] );

			$setup['image_file'] = esc_url( $new_setup['image_file'] );
			$setup['style']       = strip_tags( $new_setup['style'] );
			$setup['view']       = strip_tags( $new_setup['view'] );
			$setup['span_size']  = strip_tags( $new_setup['span_size'] );

			return $setup;
		}

		public function adminJS() {
			wp_enqueue_media();
		}

	}
}

/*function pe_best_features_admin_js($hook) {
    if ( 'widgets.php' != $hook ) {
        return;
    }
    wp_enqueue_script( 'pe-best-features-admin', plugins_url() . '/pe-lawyer-plugin/js/pe-best-features-admin.js' );
}
add_action( 'admin_enqueue_scripts', 'pe_best_features_admin_js' );*/

?>
