<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

if ( ! class_exists( 'PE_Short_Info' ) ) {

	class PE_Short_Info extends WP_Widget {

		function __construct() {
			$widget_ops = array(
				'classname'   => $this->get_classname_placeholder(),
				'description' => __( 'Displays short information with image.', 'pe-terraclassic-plugin' )
			);
			parent::__construct( 'pe_short_info', __( 'PE Short Info', 'pe-terraclassic-plugin' ), $widget_ops );
		}

		function get_classname_placeholder() {
			return 'pe-classname-placeholder';
		}

		function widget( $args, $instance ) {

			extract( $args );

			$title         = ( ! empty( $instance['title'] ) ) ? apply_filters( 'widget_title', $instance['title'] ) : false;
			$pull_right    = ( isset( $instance['pull_right'] ) && $instance['pull_right'] == 1 ) ? true : false;
			$title_heading = esc_attr( $instance['title_heading'] );
			$subtitle      = esc_html( $instance['subtitle'] );
			$subtitle_url  = esc_url( $instance['subtitle_url'] );
			if ( current_user_can( 'unfiltered_html' ) ) {
				$description = $instance['description'];
			} else {
				$description = htmlentities( $instance['description'] );
			}
			$info_icon     = esc_attr( $instance['info_icon'] );
			$info_name     = esc_attr( $instance['info_name'] );
			$readmore_name = esc_attr( $instance['readmore_name'] );
			$readmore_url  = esc_url( $instance['readmore_url'] );

			// add pull-right if set
			$classname_placeholder = $this->get_classname_placeholder();
			if ( $pull_right ) {
				$classname = 'pe_short_info_widget pull-right';
			} else {
				$classname = 'pe_short_info_widget';
			}
			$before_widget_classname = str_replace( $classname_placeholder, $classname, $before_widget );

			echo $before_widget_classname;

			?>
			<div class="pe-short-info">
			<?php if ( ! empty( $title ) or ! empty( $subtitle ) ) : ?>
				<header class="page-header">

				<?php if ( ! empty( $title ) ) : ?>
					<<?php echo $title_heading; ?> class="pe-title">
					<?php echo $title; ?>
					</<?php echo $title_heading; ?>>
				<?php endif; ?>

				<?php if ( ! empty( $subtitle ) ) : ?><?php if ( ! empty( $subtitle_url ) ) { ?>
					<a href="<?php echo $subtitle_url ?>">
							<span class="subtitle">
								<?php echo $subtitle; ?>
							</span>
					</a>
				<?php } else { ?>
					<span class="subtitle">
							<?php echo $subtitle; ?>
						</span>
				<?php } ?><?php endif; ?>

				</header>
			<?php endif; ?><?php if ( ! empty( $description ) ) : ?>
				<div class="description">
					<?php echo $description; ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $info_icon ) or ! empty( $info_name ) or ! empty( $readmore_url ) ) : ?>
				<div class="pe-buttons">
					<?php if ( ! empty( $info_icon ) or ! empty( $info_name ) ) : ?>
						<div class="pull-left">
							<span class="fa <?php echo $info_icon ?>" aria-hidden="true"></span>
							<?php echo $info_name ?>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $readmore_url ) ) :
						$readmore = ( ! empty( $readmore_name ) ) ? $readmore_name : __( 'Read more', 'pe-terraclassic-plugin' );
						?>
						<div class="pull-right">
							<a class="readmore readmore-icon" href="<?php echo $readmore_url; ?>">
								<?php echo $readmore; ?>
								<span class="fa fa-arrow-right" aria-hidden="true"></span>
							</a>
						</div>
					<?php endif; ?>
				</div>

				</div>
			<?php endif; ?>

			<?php echo $after_widget;
		}

		function form( $instance ) {

			$instance = wp_parse_args( (array) $instance, array(
					'title'         => '',
					'pull_right'    => 0,
					'title_heading' => 'h1',
					'subtitle'      => '',
					'subtitle_url'  => '',
					'description'   => '',
					'info_icon'     => '',
					'info_name'     => '',
					'readmore_name' => '',
					'readmore_url'  => '',
				)
			);

			$title         = $instance['title'];
			$pull_right    = ( $instance['pull_right'] == 1 ) ? true : false;
			$title_heading = $instance['title_heading'];
			$subtitle      = $instance['subtitle'];
			$subtitle_url  = $instance['subtitle_url'];
			$info_icon     = $instance['info_icon'];
			$info_name     = $instance['info_name'];
			$readmore_name = $instance['readmore_name'];
			$readmore_url  = $instance['readmore_url'];

			?>

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget Title', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
			</p>            <p>
				<input class="checkbox" id="<?php echo $this->get_field_id( 'pull_right' ); ?>" name="<?php echo $this->get_field_name( 'pull_right' ); ?>" type="checkbox" <?php checked( $pull_right, 1 ); ?>/>
				<label for="<?php echo $this->get_field_id( 'pull_right' ); ?>"><?php _e( 'Pull right', 'pe-terraclassic-plugin' ); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'title_heading' ); ?>"><?php _e( 'Introduction Heading', 'pe-terraclassic-plugin' ); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'title_heading' ); ?>" name="<?php echo $this->get_field_name( 'title_heading' ); ?>" style="width:100%;">
					<option value='h1'<?php echo ( $title_heading == 'h1' ) ? 'selected' : ''; ?>><?php _e( 'H1', 'pe-terraclassic-plugin' ); ?></option>
					<option value='h2'<?php echo ( $title_heading == 'h2' ) ? 'selected' : ''; ?>><?php _e( 'H2', 'pe-terraclassic-plugin' ); ?></option>
				</select>
			</p>            <p>
				<label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e( 'Subtitle', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo esc_attr( $subtitle ); ?>"/>
			</p>            <p>
				<label for="<?php echo $this->get_field_id( 'subtitle_url' ); ?>"><?php _e( 'Subtitle URL', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'subtitle_url' ); ?>" name="<?php echo $this->get_field_name( 'subtitle_url' ); ?>" value="<?php echo esc_attr( $subtitle_url ); ?>"/>
			</p>            <p>
				<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description', 'pe-terraclassic-plugin' ); ?></label>
				<textarea class="widefat" rows="8" cols="20" name="<?php echo $this->get_field_name( 'description' ); ?>" id="<?php echo $this->get_field_id( 'description' ); ?>"><?php echo esc_textarea( $instance['description'] ); ?></textarea>
			</p>            <p>
				<label for="<?php echo $this->get_field_id( 'info_icon' ); ?>"><?php _e( 'Info icon', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'info_icon' ); ?>" name="<?php echo $this->get_field_name( 'info_icon' ); ?>" value="<?php echo esc_attr( $info_icon ); ?>"/>
			</p>            <p>
				<label for="<?php echo $this->get_field_id( 'info_name' ); ?>"><?php _e( 'Info name', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'info_name' ); ?>" name="<?php echo $this->get_field_name( 'info_name' ); ?>" value="<?php echo esc_attr( $info_name ); ?>"/>
			</p>            <p>
				<label for="<?php echo $this->get_field_id( 'readmore_name' ); ?>"><?php _e( 'Readmore name', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'readmore_name' ); ?>" name="<?php echo $this->get_field_name( 'readmore_name' ); ?>" value="<?php echo esc_attr( $readmore_name ); ?>"/>
			</p>            <p>
				<label for="<?php echo $this->get_field_id( 'readmore_url' ); ?>"><?php _e( 'Readmore URL', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'readmore_url' ); ?>" name="<?php echo $this->get_field_name( 'readmore_url' ); ?>" value="<?php echo esc_attr( $readmore_url ); ?>"/>
			</p>

			<?php
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title']         = sanitize_text_field( $new_instance['title'] );
			$instance['pull_right']    = isset( $new_instance['pull_right'] ) ? 1 : 0;
			$instance['title_heading'] = esc_attr( $new_instance['title_heading'] );
			$instance['subtitle']      = sanitize_text_field( $new_instance['subtitle'] );
			$instance['subtitle_url']  = esc_url( $new_instance['subtitle_url'] );
			if ( current_user_can( 'unfiltered_html' ) ) {
				$instance['description'] = $new_instance['description'];
			} else {
				$instance['description'] = wp_kses_post( $new_instance['description'] );
			}
			$instance['info_icon']     = esc_attr( $new_instance['info_icon'] );
			$instance['info_name']     = esc_attr( $new_instance['info_name'] );
			$instance['readmore_name'] = esc_attr( $new_instance['readmore_name'] );
			$instance['readmore_url']  = esc_url( $new_instance['readmore_url'] );

			return $instance;

		}

	}
}
