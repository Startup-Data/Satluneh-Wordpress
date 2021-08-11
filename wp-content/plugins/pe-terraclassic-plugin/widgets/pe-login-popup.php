<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

if ( ! class_exists( 'PE_Login_Popup' ) ) {

	class PE_Login_Popup extends WP_Widget {

		function __construct() {
			$widget_ops = array(
				'classname'   => 'pe_login_popup_widget',
				'description' => __( 'Displays the login and registration buttons with popups.', 'pe-terraclassic-plugin' )
			);
			parent::__construct( 'pe_login_popup', __( 'PE Login Popup', 'pe-terraclassic-plugin' ), $widget_ops );
		}

		function pe_login_popup_html() {
			echo '<div id="pe-login-popup-html" class="mfp-modal-content mfp-with-anim mfp-hide">';
			if ( is_user_logged_in() ) {
				echo '<div id="pe-login-register-forgot">';
				echo '<p class="pe-info">' . __( 'You are already logged in.', 'pe-terraclassic-plugin' ) . '</p>';
				echo '<a class="button" href="' . wp_logout_url( get_permalink() ) . '">' . __( 'Logout', 'pe-terraclassic-plugin' ) . '</a>';
				echo '</div>';
			} else {
				$args = array(
					'redirect'    => home_url(),
					'remember'    => false,
					'id_username' => 'user',
					'id_password' => 'pass',
				);
				wp_login_form( $args );
			}
			echo '</div>';
		}

		function pe_register_popup_html() {
			echo '<div id="pe-register-popup-html" class="mfp-modal-content mfp-with-anim mfp-hide">';
			if ( is_user_logged_in() ) {
				echo '<div id="pe-login-register-forgot">';
				echo '<p class="pe-info">' . __( 'You are already logged in.', 'pe-terraclassic-plugin' ) . '</p>';
				echo '<a class="button" href="' . wp_logout_url( get_permalink() ) . '">' . __( 'Logout', 'pe-terraclassic-plugin' ) . '</a>';
				echo '</div>';
			} else if ( get_option( 'users_can_register' ) ) {
				echo '<form action="' . site_url( 'wp-login.php?action=register', 'login_post' ) . '" id="signup-form"  method="post">';
				echo '<p class="register-username">';
				echo '<label class="sr-only" for="userName">' . __( 'Username', 'pe-terraclassic-plugin' ) . '</label>';
				echo '<input size="30" type="text" id="userName" name="user_login" placeholder="' . __( 'Username', 'pe-terraclassic-plugin' ) . '" />';
				echo '</p>';
				echo '<p class="register-email">';
				echo '<label class="sr-only" for="user_email">' . __( 'Email', 'pe-terraclassic-plugin' ) . '</label>';
				echo '<input size="30" type="text" id="user_email" name="user_email" placeholder="' . __( 'Email', 'pe-terraclassic-plugin' ) . '" />';
				echo '</p>';
				echo '<p class="register-submit">';
				echo '<input type="submit" class="button" name="user-submit" value="' . __( 'Register', 'pe-terraclassic-plugin' ) . '" />';
				echo '<input type="hidden" name="user-cookie" value="1" />';
				echo '</p>';
				echo '</form>';
			} else {
				echo '<p class="pe-info">' . __( 'User registration is disabled.', 'pe-terraclassic-plugin' ) . '</p>';
			}
			echo '</div>';
		}


		function widget( $args, $instance ) {

			extract( $args );

			$title         = ( ! empty( $instance['title'] ) ) ? apply_filters( 'widget_title', $instance['title'] ) : false;
			$show_login    = ( isset( $instance['show_login'] ) && $instance['show_login'] == 1 ) ? true : false;
			$show_register = ( isset( $instance['show_register'] ) && $instance['show_register'] == 1 ) ? true : false;
			$welcome       = esc_html( $instance['welcome'] );

			add_action( 'wp_footer', array( $this, 'pe_login_popup_html' ), 1 );
			add_action( 'wp_footer', array( $this, 'pe_register_popup_html' ), 2 );

			echo $before_widget;

			if ( $title ) :
				echo $before_title;
				echo $title;
				echo $after_title;
			endif;

			?>

			<div class="pe-login-popup">
				<?php if ( ! is_user_logged_in() && ( $show_login || $show_register ) ) : ?><?php if ( $show_login ) : ?>
					<a class="btn-login open-popup" data-mfp-src="#pe-login-popup-html" href="#"><?php _e( 'Login', 'pe-terraclassic-plugin' ); ?></a>
				<?php endif; ?><?php if ( $show_register ) : ?>
					<a class="readmore btn-register open-popup" data-mfp-src="#pe-register-popup-html" href="#"><?php _e( 'Register', 'pe-terraclassic-plugin' ); ?></a>
				<?php endif; ?><?php endif; ?>
				<?php if ( is_user_logged_in() ) : ?><?php if ( $welcome ) : ?>
					<span class="welcome"><?php echo $welcome; ?></span>
				<?php endif; ?>
					<span class="user">
						<?php
						$current_user = wp_get_current_user();
						echo $current_user->user_login;
						?>
					</span>
					<a class="btn btn-logout" href="<?php echo wp_logout_url( get_permalink() ) ?>"><?php _e( 'Logout', 'pe-terraclassic-plugin' ) ?></a>
				<?php endif; ?>
			</div>

			<?php echo $after_widget;
		}

		function form( $instance ) {

			$instance = wp_parse_args( (array) $instance, array(
					'title'         => '',
					'show_login'    => 1,
					'show_register' => 1,
					'welcome'       => 'Howdy,',
				)
			);

			$title         = ( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$show_login    = ( $instance['show_login'] == 1 ) ? true : false;
			$show_register = ( $instance['show_register'] == 1 ) ? true : false;
			$welcome       = ( $instance['welcome'] ) ? esc_attr( $instance['welcome'] ) : '';

			?>

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget Title', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
			</p>            <p>
				<input class="checkbox" id="<?php echo $this->get_field_id( 'show_login' ); ?>" name="<?php echo $this->get_field_name( 'show_login' ); ?>" type="checkbox" <?php checked( $show_login, 1 ); ?>/>
				<label for="<?php echo $this->get_field_id( 'show_login' ); ?>"><?php _e( 'Show login button', 'pe-terraclassic-plugin' ); ?></label>
			</p>            <p>
				<input class="checkbox" id="<?php echo $this->get_field_id( 'show_register' ); ?>" name="<?php echo $this->get_field_name( 'show_register' ); ?>" type="checkbox" <?php checked( $show_register, 1 ); ?>/>
				<label for="<?php echo $this->get_field_id( 'show_register' ); ?>"><?php _e( 'Show register button', 'pe-terraclassic-plugin' ); ?></label>
			</p>            <p>
				<label for="<?php echo $this->get_field_id( 'welcome' ); ?>"><?php _e( 'Welcome text', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'welcome' ); ?>" name="<?php echo $this->get_field_name( 'welcome' ); ?>" value="<?php echo esc_attr( $welcome ); ?>"/>
			</p>
			<?php
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title']         = sanitize_text_field( $new_instance['title'] );
			$instance['show_login']    = isset( $new_instance['show_login'] ) ? 1 : 0;
			$instance['show_register'] = isset( $new_instance['show_register'] ) ? 1 : 0;
			$instance['welcome']       = sanitize_text_field( $new_instance['welcome'] );

			return $instance;

		}

	}

}
