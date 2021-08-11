<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

if ( ! class_exists( 'PE_Testimonial_Carousel' ) ) {

	class PE_Testimonial_Carousel extends WP_Widget {

		function __construct() {
			$widget_ops = array(
				'classname'   => 'pe_testimonial_carousel',
				'description' => __( 'Display Team Members carousel.', 'pe-terraclassic-plugin' )
			);
			parent::__construct( 'PE_Testimonial_Carousel', __( 'PE Testimonial Carousel', 'pe-terraclassic-plugin' ), $widget_ops );
		}

		function widget( $args, $instance ) {

			extract( $args );

			$title = apply_filters( 'widget_title', $instance['title'] );

			if ( empty( $title ) ) {
				$title = false;
			}

			$desc_limit      = ( isset( $instance['desc_limit'] ) && is_numeric( $instance['desc_limit'] ) ) ? esc_attr( intval( $instance['desc_limit'] ) ) : 'full';
			$occupation      = ( isset( $instance['occupation'] ) && $instance['occupation'] === 1 ) ? true : false;
			$number_of_posts = ( ! empty( $instance['number_of_posts'] ) ) ? esc_attr( intval( $instance['number_of_posts'] ) ) : 5;

			$member_args = array(
				'post_type'      => 'testimonial',
				'posts_per_page' => $number_of_posts
			);

			$member_query = new WP_Query( $member_args );

			echo $before_widget;

			if ( $title ):
				echo $before_title;
				echo $title;
				echo $after_title;
			endif;

			if ( $member_query->have_posts() ): ?>

				<?php $itemid = uniqid( 'pe-testimonial-carousel-' ); ?>

				<!-- Begin of testimonials slider -->
				<div id="<?php echo $itemid; ?>" class="pe-carousel pe-testimonial-carousel">

					<!-- Wrapper for slides -->
					<div class="pe-slick-content" data-slick='{"autoplay": true, "autoplaySpeed": 5000}' aria-label="<?php _e( 'Testimonials', 'pe-terraclassic-plugin' ); ?>">

						<?php

						$counter = 0;

						while ( $member_query->have_posts() ): $member_query->the_post();

							$active_class = ( $counter == 1 ) ? 'active' : '';

							$counter ++;

							$id = uniqid();
							?>
							<div class="item-<?php echo $counter; ?> pe-item pe-testimonials-widget <?php echo $active_class; ?>" aria-labelledby="title-<?php echo $id; ?>" aria-describedby="desc-<?php echo $id; ?>">
								<div class="pe-custom-text" id="desc-<?php echo $id; ?>">
									<p>
										<?php pe_excerpt( $desc_limit, '&hellip;', false, true ); ?>
									</p>
								</div>
								<div class="pe-custom-title" id="title-<?php echo $id; ?>">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</div>
								<?php if ( $occupation ) : ?>
									<div class="pe-custom-subtitle">
										<?php echo get_post_meta( get_the_ID(), 'testimonial_occupation', true ); ?>
									</div>
								<?php endif; ?>
							</div>

						<?php endwhile; ?>

					</div>

					<!-- Indicators -->
					<ol class="pe-indicators" role="tablist" aria-label="<?php _e( 'Indicators', 'pe-terraclassic-plugin' ); ?>">

						<?php

						$i = 0;

						while ( $member_query->have_posts() ): $member_query->the_post();
							$active_class = ( $i === 0 ) ? 'active' : '';

							echo '<li data-slick-goto="' . $i . '" class="pe-indicator ' . $active_class . '" role="tab" aria-label="' . __( 'Testimonial ', 'pe-terraclassic-plugin' ) . $i . '" tabindex="0"></li>';

							$i ++;

						endwhile; ?>

					</ol>

				</div><!-- End of testimonials slider -->

				<?php wp_reset_query();
			else: ?>
				<ul class="testimonial-not-found">
					<?php
					echo '<li>';
					_e( 'No Testimonials Found!', 'pe-terraclassic-plugin' );
					echo '</li>';
					?>
				</ul>
			<?php endif;

			echo $after_widget;
		}


		function form( $instance ) {

			$instance = wp_parse_args( (array) $instance, array(

				'title'           => '',
				'desc_limit'      => 150,
				'number_of_posts' => 5,
				'occupation'      => 0,

			) );

			$title           = esc_attr( $instance['title'] );
			$desc_limit      = $instance['desc_limit'];
			$occupation      = ( $instance['occupation'] === 1 ) ? true : false;
			$number_of_posts = $instance['number_of_posts'];

			?>

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget Title', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>"/>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'number_of_posts' ); ?>"><?php _e( 'Number of testimonials to show', 'pe-terraclassic-plugin' ); ?></label>
				<input id="<?php echo $this->get_field_id( 'number_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_of_posts' ); ?>" type="text" value="<?php echo $number_of_posts; ?>" size="3"/>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'desc_limit' ); ?>"><?php _e( 'Testimonial opinion limit', 'pe-terraclassic-plugin' ); ?></label>
				<input id="<?php echo $this->get_field_id( 'desc_limit' ); ?>" name="<?php echo $this->get_field_name( 'desc_limit' ); ?>" type="text" value="<?php echo $desc_limit; ?>" size="3"/>
			</p>

			<p>
				<input class="checkbox" id="<?php echo $this->get_field_id( 'occupation' ); ?>" name="<?php echo $this->get_field_name( 'occupation' ); ?>" type="checkbox" <?php checked( $occupation, 1 ); ?>/>
				<label for="<?php echo $this->get_field_id( 'occupation' ); ?>"><?php _e( 'Show/Hide Testimonial Occupation.', 'pe-terraclassic-plugin' ); ?></label>
			</p>

			<?php
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title']           = strip_tags( $new_instance['title'] );
			$instance['desc_limit']      = esc_attr( $new_instance['desc_limit'] );
			$instance['occupation']      = isset( $new_instance['occupation'] ) ? 1 : 0;
			$instance['number_of_posts'] = esc_attr( $new_instance['number_of_posts'] );

			return $instance;

		}

	}
}
?>
