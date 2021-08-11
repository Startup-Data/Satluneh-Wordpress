<?php
/**
 * Plugin Name: PE_Image_Carousel
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

if ( ! class_exists( 'PE_Image_Carousel' ) ) {
	class PE_Image_Carousel extends WP_Widget {

		function __construct() {
			$widget_ops = array(
				'classname'   => 'pe-widget-img-carousel',
				'description' => __( 'Displays images carousel.', 'pe-terraclassic-plugin' )
			);
			parent::__construct( 'PE_Image_Carousel', __( 'PE Image Carousel', 'pe-terraclassic-plugin' ), $widget_ops );

			add_action( 'wp_enqueue_scripts', array( $this, 'printCSS' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'printJS' ) );
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

			$indicators = ( ! empty( $setup['indicators'] ) ) ? $setup['indicators'] : 0;
			$buttons    = ( ! empty( $setup['buttons'] ) ) ? $setup['buttons'] : 0;
			$scroll     = ( ! empty( $setup['scroll'] ) ) ? $setup['scroll'] : 0;
			$style      = ( ! empty( $setup['style'] ) ) ? $setup['style'] : 0;
			$loop       = ( ! empty( $setup['loop'] ) ) ? $setup['loop'] : 0;

			$show_desc  = ( ! empty( $setup['show_desc'] ) ) ? intval($setup['show_desc']) : 0;
			$readmore   = ( ! empty( $setup['readmore'] ) ) ? $setup['readmore'] : 0;

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

			if($show_desc == 1) {
				$desc_class = 'desc-below';
			} elseif($show_desc == 2) {
				$desc_class = 'desc-left';
			} elseif($show_desc == 3) {
				$desc_class = 'desc-right';
			} else {
				$desc_class = 'no-desc';
			}

			?>
			<div class="pe-carousel-container <?php echo $desc_class ?>">
			<div class="pe-carousel-flipster"><ul class="pe-image-carousel">

				<?php foreach ( $output as $item ) :

					$i ++;

					$alt = ( !empty($item['name']) ) ? $item['name'] : '' ;

					?>

					<?php if ( ! empty( $item['image'] ) ) : ?>
					<li class="pe-item item-<?php echo $i; ?>" data-flip-title="<?php echo $i; ?>">
						<?php if ( ! empty( $item['url'] ) ) : ?>
							<a href="<?php echo esc_url( $item['url'] ); ?>">
						<?php endif; ?>
							<img alt="<?php echo $alt; ?>" src="<?php echo esc_url( $item['image'] ); ?>">
						<?php if ( ! empty( $item['url'] ) ) : ?>
							</a>
						<?php endif; ?>
					</li>
				<?php endif; ?>

				<?php endforeach; ?>

			</ul></div>

			<?php

			if( $show_desc == 1 || $show_desc == 2 || $show_desc == 3 ) {

				$i_desc = 0;
				//center item should be active
				if( $items % 2 == 0 ) {
					$active_item = round($items / 2) + 1;
				} else {
					$active_item = round($items / 2);
				}

				echo '<div class="pe-carousel-description">';

				foreach ( $output as $item ) {
					$i_desc ++;
					$active = ( $i_desc == $active_item ) ? 'active' : '' ;

					//if( !empty($item['name']) || !empty($item['text']) ) {
						echo '<div class="item item-' . $i_desc . ' ' . $active . '">';
						if( !empty($item['name']) ) {
						echo '<div class="pe-name">';
							echo $item['name'];
						echo '</div>';
						}

						if( !empty($item['text']) ) {
						echo '<div class="pe-text">';
							echo $item['text'];
						echo '</div>';
						}

						if( !empty($item['url']) && $readmore == 1 ) { 
							$readmore_name = ( !empty($item['readmore_name']) ) ? $item['readmore_name'] : __('Readmore', 'pe-terraclassic-plugin');
							echo '<div class="pe-readmore">';
								echo '<a href="' . esc_url( $item['url'] ) . '" class="btn">'. $readmore_name. '</a>';
							echo '</div>';
						}

						echo '</div>';
					//}
				}

				echo '</div>';
			}

			//script

			if ( $style == 1 ) {
				$style = '"coverflow"';
			} elseif ( $style == 2 ) {
				$style = '"flat"';
			} else {
				$style = '"carousel"';
			}

			$loop = ( $loop == 1 ) ? 'true' : 'false';

			$indicators = ( $indicators == 1 ) ? '"after"' : 'false';

			$buttons = ( $buttons == 1 ) ? 'true' : 'false';

			$scroll = ( $scroll == 1 ) ? 'true' : 'false';

			?>
			</div>
			<script>
				jQuery(document).ready(function () {
					jQuery('#<?php echo $this->id; ?> .pe-carousel-flipster').flipster({
						style: <?php echo $style; ?>,
						spacing: -0.4,
						loop: <?php echo $loop; ?>,
						nav: <?php echo $indicators; ?>,
						buttons: <?php echo $buttons; ?>,
						scrollwheel: <?php echo $scroll; ?>,

						<?php if( $show_desc == 1 || $show_desc == 2 || $show_desc == 3 ) { ?>
							onItemSwitch: function(currentItem, previousItem) {
								var id = jQuery(currentItem).attr('data-flip-title');
								var items = jQuery('#<?php echo $this->id; ?> .pe-carousel-description .item');
								console.log(id);
								items.siblings().removeClass('active');
								items.parent().find('.item-' + id).addClass('active');
							}
						<?php } ?>

					});
				});
			</script>

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
				'indicators' => '',
				'buttons'    => '',
				'scroll'     => '',
				'style'      => '',
				'loop'       => '',
				'show_desc'  => '',
				'readmore'   => '',
			) );

			$unsaved = ( $this->number == '__i__' ) ? true : false;

			$title = $setup['title'];

			$data = ( ! empty( $setup['data'] ) ) ? $setup['data'] : '';

			$indicators = ( ! empty( $setup['indicators'] ) ) ? $setup['indicators'] : 0;
			$buttons    = ( ! empty( $setup['buttons'] ) ) ? $setup['buttons'] : 0;
			$scroll     = ( ! empty( $setup['scroll'] ) ) ? $setup['scroll'] : 0;
			$style      = ( ! empty( $setup['style'] ) ) ? $setup['style'] : 0;
			$loop       = ( ! empty( $setup['loop'] ) ) ? $setup['loop'] : 0;

			$readmore       = ( ! empty( $setup['readmore'] ) ) ? $setup['readmore'] : 0;
			$show_desc      = ( ! empty( $setup['show_desc'] ) ) ? $setup['show_desc'] : 0;

			?>
			<div id="<?php echo $this->id; ?>" class="pe-widget-container">

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
				}

				if ( ! $unsaved ) :
					?>

					<!-- fields group -->

					<a class="add-new button button-primary purple" href="#"><?php _e( 'Add new item', 'pe-terraclassic-plugin' ); ?></a>

					<div class="pe-fields-group" style="display: none;">

						<p>
							<label for="image"><?php _e( 'Image:', 'pe-terraclassic-plugin' ); ?></label>
							<input class="widefat" id="image" name="image" type="text" value=""/>
							<input class="media-item button" type="button" value="<?php _e( 'Select image', 'pe-terraclassic-plugin' ); ?>"/>
						</p>

						<p>
							<label for="url"><?php _e( 'URL:', 'pe-terraclassic-plugin' ); ?></label>
							<input class="widefat" id="url" name="url" type="text" value=""/>
						</p>

						<p>
							<label for="name"><?php _e( 'Item title:', 'pe-terraclassic-plugin' ); ?></label>
							<input class="widefat" id="name" name="name" type="text" value=""/>
						</p>

						<p>
							<label for="text"><?php _e( 'Description:', 'pe-terraclassic-plugin' ); ?></label>
							<textarea class="widefat" id="text" name="text"></textarea>
						</p>

						<p>
							<label for="readmore_name"><?php _e( 'Readmore button name:', 'pe-terraclassic-plugin' ); ?></label>
							<input class="widefat" id="readmore_name" name="readmore_name" type="text" value=""/>
						</p>

						<a class="save-item button button-primary green" href="#"><?php _e( 'Save item', 'pe-terraclassic-plugin' ); ?></a>
						<a class="cancel-item button button-primary red" href="#"><?php _e( 'Cancel', 'pe-terraclassic-plugin' ); ?></a>

					</div>                <!-- fields group -->

					<p>
						<label for="<?php echo $this->get_field_id( 'indicators' ); ?>"><?php _e( 'Show indicators', 'pe-terraclassic-plugin' ); ?></label>
						<select class="widefat" id="<?php echo $this->get_field_id( 'indicators' ); ?>" name="<?php echo $this->get_field_name( 'indicators' ); ?>" style="width:100%;">
							<option value='0'<?php echo ( $indicators == 0 ) ? 'selected' : ''; ?>><?php _e( 'No', 'pe-terraclassic-plugin' ); ?></option>
							<option value='1'<?php echo ( $indicators == 1 ) ? 'selected' : ''; ?>><?php _e( 'Yes', 'pe-terraclassic-plugin' ); ?></option>
						</select>
					</p>

					<p>
						<label for="<?php echo $this->get_field_id( 'buttons' ); ?>"><?php _e( 'Show prev/next buttons', 'pe-terraclassic-plugin' ); ?></label>
						<select class="widefat" id="<?php echo $this->get_field_id( 'buttons' ); ?>" name="<?php echo $this->get_field_name( 'buttons' ); ?>" style="width:100%;">
							<option value='0'<?php echo ( $buttons == 0 ) ? 'selected' : ''; ?>><?php _e( 'No', 'pe-terraclassic-plugin' ); ?></option>
							<option value='1'<?php echo ( $buttons == 1 ) ? 'selected' : ''; ?>><?php _e( 'Yes', 'pe-terraclassic-plugin' ); ?></option>
						</select>
					</p>

					<p>
						<label for="<?php echo $this->get_field_id( 'loop' ); ?>"><?php _e( 'Loop carousel', 'pe-terraclassic-plugin' ); ?></label>
						<select class="widefat" id="<?php echo $this->get_field_id( 'loop' ); ?>" name="<?php echo $this->get_field_name( 'loop' ); ?>" style="width:100%;">
							<option value='0'<?php echo ( $loop == 0 ) ? 'selected' : ''; ?>><?php _e( 'No', 'pe-terraclassic-plugin' ); ?></option>
							<option value='1'<?php echo ( $loop == 1 ) ? 'selected' : ''; ?>><?php _e( 'Yes', 'pe-terraclassic-plugin' ); ?></option>
						</select>
					</p>

					<p>
						<label for="<?php echo $this->get_field_id( 'scroll' ); ?>"><?php _e( 'Scroll wheel', 'pe-terraclassic-plugin' ); ?></label>
						<select class="widefat" id="<?php echo $this->get_field_id( 'scroll' ); ?>" name="<?php echo $this->get_field_name( 'scroll' ); ?>" style="width:100%;">
							<option value='0'<?php echo ( $scroll == 0 ) ? 'selected' : ''; ?>><?php _e( 'No', 'pe-terraclassic-plugin' ); ?></option>
							<option value='1'<?php echo ( $scroll == 1 ) ? 'selected' : ''; ?>><?php _e( 'Yes', 'pe-terraclassic-plugin' ); ?></option>
						</select>
					</p>

					<p>
						<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e( 'Style', 'pe-terraclassic-plugin' ); ?></label>
						<select class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>" style="width:100%;">
							<option value='0'<?php echo ( $style == 0 ) ? 'selected' : ''; ?>><?php _e( 'Carousel', 'pe-terraclassic-plugin' ); ?></option>
							<option value='1'<?php echo ( $style == 1 ) ? 'selected' : ''; ?>><?php _e( 'Coverflow', 'pe-terraclassic-plugin' ); ?></option>
							<option value='2'<?php echo ( $style == 2 ) ? 'selected' : ''; ?>><?php _e( 'Flat', 'pe-terraclassic-plugin' ); ?></option>
						</select>
					</p>

					<p>
						<label for="<?php echo $this->get_field_id( 'show_desc' ); ?>"><?php _e( 'Show description', 'pe-terraclassic-plugin' ); ?></label>
						<select class="widefat" id="<?php echo $this->get_field_id( 'show_desc' ); ?>" name="<?php echo $this->get_field_name( 'show_desc' ); ?>" style="width:100%;">
							<option value='0'<?php echo ( $show_desc == 0 ) ? 'selected' : ''; ?>><?php _e( 'No', 'pe-terraclassic-plugin' ); ?></option>
							<option value='1'<?php echo ( $show_desc == 1 ) ? 'selected' : ''; ?>><?php _e( 'Below the image', 'pe-terraclassic-plugin' ); ?></option>
							<option value='2'<?php echo ( $show_desc == 2 ) ? 'selected' : ''; ?>><?php _e( 'Left side', 'pe-terraclassic-plugin' ); ?></option>
							<option value='3'<?php echo ( $show_desc == 3 ) ? 'selected' : ''; ?>><?php _e( 'Right side', 'pe-terraclassic-plugin' ); ?></option>
						</select>
					</p>

					<p>
						<label for="<?php echo $this->get_field_id( 'readmore' ); ?>"><?php _e( 'Show readmore', 'pe-terraclassic-plugin' ); ?></label>
						<select class="widefat" id="<?php echo $this->get_field_id( 'readmore' ); ?>" name="<?php echo $this->get_field_name( 'readmore' ); ?>" style="width:100%;">
							<option value='0'<?php echo ( $readmore == 0 ) ? 'selected' : ''; ?>><?php _e( 'No', 'pe-terraclassic-plugin' ); ?></option>
							<option value='1'<?php echo ( $readmore == 1 ) ? 'selected' : ''; ?>><?php _e( 'Yes', 'pe-terraclassic-plugin' ); ?></option>
						</select>
					</p>

					<!-- data holder -->
					<input class="data-holder" id="<?php echo $this->get_field_id( 'data' ); ?>" name="<?php echo $this->get_field_name( 'data' ); ?>" type="hidden" value='<?php echo $data; ?>'/>

					<script>
						jQuery(document).ready(function () {
							var init = new PEwidget('#<?php echo $this->id; ?>');
							jQuery(document).on('widget-updated', function () {
								init.showtime();
							});
						});
					</script>

				<?php else :
					echo '<p class="notice notice-error"><br>' . __( 'Please save widget first !', 'pe-terraclassic-plugin' ) . '<br><br></p>';
				endif;
				?>

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

			$setup['indicators'] = strip_tags( $new_setup['indicators'] );
			$setup['buttons']    = strip_tags( $new_setup['buttons'] );
			$setup['scroll']     = strip_tags( $new_setup['scroll'] );
			$setup['style']      = strip_tags( $new_setup['style'] );
			$setup['loop']       = strip_tags( $new_setup['loop'] );
			$setup['readmore']   = strip_tags( $new_setup['readmore'] );
			$setup['show_desc']  = strip_tags( $new_setup['show_desc'] );

			return $setup;
		}

		//add CSS
		public function printCSS() {
			if ( is_active_widget( false, false, $this->id_base, true ) ) {
				wp_enqueue_style( 'pe-image-carousel', plugins_url() . '/pe-terraclassic-plugin/css/jquery.flipster.css' );
			}
		}

		//add JS
		public function printJS() {
			if ( is_active_widget( false, false, $this->id_base, true ) ) {
				wp_enqueue_script( 'pe-image-carousel', plugins_url() . '/pe-terraclassic-plugin/js/jquery.flipster.min.js', array( 'jquery' ), '1.1.1', false );
			}
		}

		public function adminJS() {
			wp_enqueue_media();
		}

	}
}

?>
