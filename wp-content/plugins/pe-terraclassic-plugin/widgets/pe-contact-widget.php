<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

if ( ! class_exists( 'PE_Contact' ) ) {

	class PE_Contact extends WP_Widget {

		function __construct() {
			$widget_ops = array(
				'classname'   => 'pe-widget-contact',
				'description' => __( 'Displays Contact form, details and map.', 'pe-terraclassic-plugin' )
			);
			parent::__construct( 'PE_Contact', __( 'PE Contact', 'pe-terraclassic-plugin' ), $widget_ops );
		}

		function widget( $args, $instance ) {

			extract( $args );

			$title             = ( ! empty( $instance['title'] ) ) ? apply_filters( 'widget_title', $instance['title'] ) : false;
			$number_columns    = ( ! empty( $instance['number-columns'] ) ) ? esc_attr( $instance['number-columns'] ) : 2;
			$show_captcha = ( isset($instance['show_captcha']) && $instance['show_captcha'] == 1 ) ? true : false;
			$email_in_form     = esc_attr( $instance['email_in_form'] );
			$email_recipient   = sanitize_email( $instance['email_recipient'] );
			$senders_name      = sanitize_text_field( $instance['senders_name'] );
			$default_subject   = sanitize_text_field( $instance['default_subject'] );
			$email_with_thanks = esc_attr( $instance['email_with_thanks'] );
			$thanks_subject    = sanitize_text_field( $instance['thanks_subject'] );
			$thanks_message    = esc_textarea( $instance['thanks_message'] );
			$intro_text        = sanitize_text_field( $instance['intro_text'] );
			$message_type      = esc_attr( $instance['message_type'] );
			$message_label     = sanitize_text_field( $instance['message_label'] );
			$textarea_height   = ( ! empty( $instance['textarea_height'] ) ) ? intval( $instance['textarea_height'] ) : '';
			$button_label      = sanitize_text_field( $instance['button_label'] );
			$show_consent1 = ( isset($instance['show_consent1']) && $instance['show_consent1'] == 1 ) ? true : false;
			$show_consent2 = ( isset($instance['show_consent2']) && $instance['show_consent2'] == 1 ) ? true : false;
			$consent1_text = PEsettings::get('consent1-text');
			$consent2_text = PEsettings::get('consent2-text');
						
			$reCaptcha = ( PEsettings::get('google-captcha-api') && PEsettings::get('google-captcha-sitekey') && PEsettings::get('google-captcha-secretkey') ) ? true : false;
			
			echo $before_widget;

			if ( $title ):
				echo $before_title;
				echo $title;
				echo $after_title;
			endif;

			if (empty($this->id)){
				$fid="";
			}  else {
				$fid= $this->id;
			}

			?>


			<form id="pe-contact-form" class="pe-contact-form col-<?php echo $number_columns ?>" method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
				<div role="status" class="alert pe-alert"></div>
				<div role="status" class="alert pe-success"></div>
				<?php if ( ! empty( $intro_text ) ) { ?>
					<span class="pe-contact-intro-text"><?php echo $intro_text ?></span>
				<?php } ?>
				<div class="pe-form-group">
						<label for="<?php echo $fid; ?>contactName" title="<?php _e('Your name', 'pe-terraclassic-plugin'); ?>" class="sr-only"><?php _e('Name', 'pe-terraclassic-plugin'); ?></label>
						<input type="text" name="<?php echo $fid; ?>contactName" id="<?php echo $fid; ?>contactName" autocomplete="name" title="<?php _e( 'Please provide your name', 'pe-terraclassic-plugin'); ?>" placeholder="<?php _e('Name', 'pe-terraclassic-plugin'); ?>" required>
				</div>
				<?php if ( isset( $email_in_form ) AND $email_in_form == 1 ) : ?>
					<div class="pe-form-group">
							<label for="<?php echo $fid; ?>contactEmail" title="<?php _e('Email address for contact', 'pe-terraclassic-plugin'); ?>" class="sr-only"><?php _e('Email', 'pe-terraclassic-plugin'); ?></label>
							<input type="email" name="<?php echo $fid; ?>contactEmail" id="<?php echo $fid; ?>contactEmail" autocomplete="email" title="<?php _e( 'Please provide a valid email address', 'pe-terraclassic-plugin'); ?>" placeholder="<?php _e('Email', 'pe-terraclassic-plugin'); ?>" required>
					</div>
				<?php endif; ?>


				<?php if ( isset( $message_type ) AND $message_type == 0 ) { ?>
					<div class="pe-form-group">
						<label class="sr-only" for="<?php echo $fid; ?>contactMessage"><?php _e( 'Message', 'pe-terraclassic-plugin' ); ?></label>
						<input type="text" name="<?php echo $fid; ?>contactMessage" id="<?php echo $fid; ?>contactMessage_<?php echo $widget_id; ?>" placeholder="<?php echo ( ! empty( $message_label ) ) ? $message_label : ''; ?>" title="<?php _e( '* Please provide your message', 'pe-terraclassic-plugin' ); ?>" required>
					</div>
				<?php } elseif ( isset( $message_type ) AND $message_type == 1 ) {

					$heightstyle = ( ! empty( $textarea_height ) ) ? 'style="height: ' . $textarea_height . 'px;"' : '';

					?>
					<div class="pe-form-group pe-textarea">
						<label class="sr-only" for="<?php echo $fid; ?>contactMessage"><?php _e( 'Message', 'pe-terraclassic-plugin' ); ?></label>
						<textarea name="<?php echo $fid; ?>contactMessage" id="<?php echo $fid; ?>contactMessage" <?php echo $heightstyle; ?>
								  placeholder="<?php echo ( ! empty( $message_label ) ) ? $message_label : ''; ?>" title="<?php _e( '* Please provide your message', 'pe-terraclassic-plugin' ); ?>" required></textarea>
					</div>
				<?php } ?>

				<?php if($show_consent1 || $show_consent2){ ?>
					<div class="pe-form-group pe-consents">
						<?php if($show_consent1){ ?>
						<div class="pe-form-group-consent1">
							<input type="checkbox" name="consent1-input" id="consent1-input" value="0" title="<?php _e( 'Please check the consent.', 'pe-terraclassic-plugin'); ?>" required>                	
						 	<label class="label_terms" for="consent1-input" id="consent1-lbl"><?php echo $consent1_text; ?> <span class="star">*</span></label>
						</div>
						<?php } ?>
						
						<?php if($show_consent2){ ?>
						<div class="pe-form-group-consent2">
							<input type="checkbox" name="consent2-input" id="consent2-input" value="0" title="<?php _e( 'Please check the consent.', 'pe-terraclassic-plugin'); ?>" required>                	
						 	<label class="label_terms" for="consent2-input" id="consent2-lbl"><?php echo $consent2_text; ?> <span class="star">*</span></label>
						</div>
						<?php } ?>
					</div>
				<?php } ?>
									
				<?php
				if( $show_captcha && $reCaptcha ) {
					echo '<div class="pe-form-group g-recaptcha" data-sitekey="' . PEsettings::get('google-captcha-sitekey') . '"></div>';
					echo '<script type="text/javascript" src="https://www.google.com/recaptcha/api.js" async defer></script>';
				}
				?>
									
				<div class="pe-form-group pe-button">
					<input type="submit" value="<?php _e('Send message', 'pe-terraclassic-plugin'); ?>" class="submit-button btn" name="submit">
					<input type="hidden" name="form_prefix" value="<?php echo $fid; ?>" />
					<input type="hidden" name="action" value="send_email" />
					<input type="hidden" name="<?php echo $fid; ?>nonce" value="<?php echo wp_create_nonce('send_email_nonce'); ?>"/>
				</div>
			</form>


			<?php echo $after_widget;

		}


		function form( $instance ) {

			$instance = wp_parse_args( (array) $instance, array(
					'title'             => __( 'We will call you back', 'pe-terraclassic-plugin' ),
					'number-columns'    => 2,
					'show_consent1'         => 0,
					'show_consent2'         => 0,
					'show_captcha'         => 0,
					'email_in_form'     => 0,
					'email_recipient'   => '',
					'senders_name'      => '',
					'default_subject'   => __( 'Default subject', 'pe-terraclassic-plugin' ),
					'email_with_thanks' => 1,
					'thanks_subject'    => __( 'Thank you subject', 'pe-terraclassic-plugin' ),
					'thanks_message'    => __( 'Thank you message sent to user', 'pe-terraclassic-plugin' ),
					'intro_text'        => __( 'Intro text, displayed after Widget title', 'pe-terraclassic-plugin' ),
					'message_type'      => 0,
					'message_label'     => __( 'Phone number', 'pe-terraclassic-plugin' ),
					'textarea_height'   => '',
					'button_label'      => __( 'Send Email', 'pe-terraclassic-plugin' ),
				)
			);

			$title             = ( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$number_columns    = esc_attr( $instance['number-columns'] );
			$show_consent1 = ( $instance['show_consent1'] === 1 ) ? true : false;
			$show_consent2 = ( $instance['show_consent2'] === 1 ) ? true : false;
			$show_captcha = ( $instance['show_captcha'] === 1 ) ? true : false;
			$email_in_form     = esc_attr( $instance['email_in_form'] );
			$email_recipient   = sanitize_email( $instance['email_recipient'] );
			$senders_name      = sanitize_text_field( $instance['senders_name'] );
			$default_subject   = sanitize_text_field( $instance['default_subject'] );
			$email_with_thanks = esc_attr( $instance['email_with_thanks'] );
			$thanks_subject    = sanitize_text_field( $instance['thanks_subject'] );
			$thanks_message    = esc_textarea( $instance['thanks_message'] );
			$intro_text        = sanitize_text_field( $instance['intro_text'] );
			$message_type      = esc_attr( $instance['message_type'] );
			$message_label     = sanitize_text_field( $instance['message_label'] );
			$textarea_height   = intval( $instance['textarea_height'] );
			$button_label      = sanitize_text_field( $instance['button_label'] );

			?>

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget Title', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'number-columns' ); ?>"><?php _e( 'Number of columns', 'pe-terraclassic-plugin' ); ?></label>
				<select class="widefat" name="<?php echo $this->get_field_name( 'number-columns' ); ?>" id="<?php echo $this->get_field_id( 'number-columns' ); ?>" style="width:100%;">
					<option value="1"<?php echo ( $number_columns == '1' ) ? 'selected' : ''; ?>><?php _e( '1 column', 'pe-terraclassic-plugin' ); ?></option>
					<option value="2"<?php echo ( $number_columns == '2' ) ? 'selected' : ''; ?>><?php _e( '2 columns', 'pe-terraclassic-plugin' ); ?></option>
					<option value="3"<?php echo ( $number_columns == '3' ) ? 'selected' : ''; ?>><?php _e( '3 columns', 'pe-terraclassic-plugin' ); ?></option>
				</select>
			</p>    
			<p>
					<input class="checkbox" id="<?php echo $this->get_field_id('show_consent1'); ?>" name="<?php echo $this->get_field_name('show_consent1'); ?>" type="checkbox" <?php checked( $show_consent1, 1 ); ?>/>
					<label for="<?php echo $this->get_field_id('show_consent1'); ?>"><?php _e('Show consent 1', 'pe-terraclassic-plugin'); ?></label>
			</p>
			<p>
					<input class="checkbox" id="<?php echo $this->get_field_id('show_consent2'); ?>" name="<?php echo $this->get_field_name('show_consent2'); ?>" type="checkbox" <?php checked( $show_consent2, 1 ); ?>/>
					<label for="<?php echo $this->get_field_id('show_consent2'); ?>"><?php _e('Show consent 2', 'pe-terraclassic-plugin'); ?></label>
			</p>
			<p>
					<input class="checkbox" id="<?php echo $this->get_field_id('show_captcha'); ?>" name="<?php echo $this->get_field_name('show_captcha'); ?>" type="checkbox" <?php checked( $show_captcha, 1 ); ?>/>
					<label for="<?php echo $this->get_field_id('show_captcha'); ?>"><?php _e('Show captcha', 'pe-lawyer'); ?></label>
			</p>        
			<p>
				<label><?php _e( 'Email Parameters', 'pe-terraclassic-plugin' ); ?></label>
			<hr/>            
			</p>            <p>
				<label for="<?php echo $this->get_field_name( 'email_in_form' ); ?>"><?php _e( 'Email in Form:', 'pe-terraclassic-plugin' ); ?></label>
				<input type="radio" name="<?php echo $this->get_field_name( 'email_in_form' ); ?>" id="<?php echo $this->get_field_id( 'email_in_form' ); ?>_0" value="0" <?php checked( '0', esc_attr( $email_in_form ) ) ?>/>
				<label for="<?php echo $this->get_field_id( 'email_in_form' ); ?>_0"><?php _e( 'No', 'pe-terraclassic-plugin' ); ?></label>
				<input type="radio" name="<?php echo $this->get_field_name( 'email_in_form' ); ?>" id="<?php echo $this->get_field_id( 'email_in_form' ); ?>_1" value="1" <?php checked( '1', esc_attr( $email_in_form ) ) ?>/>
				<label for="<?php echo $this->get_field_id( 'email_in_form' ); ?>_1"><?php _e( 'Yes', 'pe-terraclassic-plugin' ); ?></label>
			</p>            <p>
				<label for="<?php echo $this->get_field_id( 'email_recipient' ); ?>"><?php _e( 'Email Recipient', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" type="text" name="<?php echo $this->get_field_name( 'email_recipient' ); ?>" id="<?php echo $this->get_field_id( 'email_recipient' ); ?>" value="<?php echo sanitize_email( $email_recipient ); ?>"/>
			</p>            <p>
				<label for="<?php echo $this->get_field_id( 'senders_name' ); ?>"><?php _e( 'Sender\'s name', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" type="text" name="<?php echo $this->get_field_name( 'senders_name' ); ?>" id="<?php echo $this->get_field_id( 'senders_name' ); ?>" value="<?php echo sanitize_text_field( $senders_name ); ?>"/>
			</p>            <p>
				<label for="<?php echo $this->get_field_id( 'default_subject' ); ?>"><?php _e( 'Default Subject', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" type="text" name="<?php echo $this->get_field_name( 'default_subject' ); ?>" id="<?php echo $this->get_field_id( 'default_subject' ); ?>" value="<?php echo sanitize_text_field( $default_subject ); ?>"/>
			</p>            <p>
				<label for="<?php echo $this->get_field_name( 'email_with_thanks' ); ?>"><?php _e( 'Email with thanks:', 'pe-terraclassic-plugin' ); ?></label>
				<input type="radio" name="<?php echo $this->get_field_name( 'email_with_thanks' ); ?>" id="<?php echo $this->get_field_id( 'email_with_thanks' ); ?>_0" value="0" <?php checked( '0', esc_attr( $email_with_thanks ) ) ?>/>
				<label for="<?php echo $this->get_field_id( 'email_with_thanks' ); ?>_0"><?php _e( 'No', 'pe-terraclassic-plugin' ); ?></label>
				<input type="radio" name="<?php echo $this->get_field_name( 'email_with_thanks' ); ?>" id="<?php echo $this->get_field_id( 'email_with_thanks' ); ?>_1" value="1" <?php checked( '1', esc_attr( $email_with_thanks ) ) ?>/>
				<label for="<?php echo $this->get_field_id( 'email_with_thanks' ); ?>_1"><?php _e( 'Yes', 'pe-terraclassic-plugin' ); ?></label>
			</p>            <p>
				<label for="<?php echo $this->get_field_id( 'thanks_subject' ); ?>"><?php _e( 'Thanks subject', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" type="text" name="<?php echo $this->get_field_name( 'thanks_subject' ); ?>" id="<?php echo $this->get_field_id( 'thanks_subject' ); ?>" value="<?php echo sanitize_text_field( $thanks_subject ); ?>"/>
			</p>            <p>
				<label for="<?php echo $this->get_field_id( 'thanks_message' ); ?>"><?php _e( 'Thanks message', 'pe-terraclassic-plugin' ); ?></label>
				<textarea class="widefat" rows="2" cols="20" name="<?php echo $this->get_field_name( 'thanks_message' ); ?>" id="<?php echo $this->get_field_id( 'thanks_message' ); ?>
				"><?php echo esc_textarea( $thanks_message ); ?></textarea>
			</p>            <p>
				<label><?php _e( 'Text Parameters', 'pe-terraclassic-plugin' ); ?></label>
			<hr>            </p>            <p>
				<label for="<?php echo $this->get_field_id( 'intro_text' ); ?>"><?php _e( 'Intro Text', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" type="text" name="<?php echo $this->get_field_name( 'intro_text' ); ?>" id="<?php echo $this->get_field_id( 'intro_text' ); ?>" value="<?php echo sanitize_text_field( $intro_text ); ?>"/>
			</p>            <p>
				<label for="<?php echo $this->get_field_name( 'message_type' ); ?>"><?php _e( 'Message Type:', 'pe-terraclassic-plugin' ); ?></label>
				<input type="radio" name="<?php echo $this->get_field_name( 'message_type' ); ?>" id="<?php echo $this->get_field_id( 'message_type' ); ?>_0" value="0" <?php checked( '0', esc_attr( $message_type ) ) ?>/>
				<label for="<?php echo $this->get_field_id( 'message_type' ); ?>_0"><?php _e( 'Text Input', 'pe-terraclassic-plugin' ); ?></label>
				<input type="radio" name="<?php echo $this->get_field_name( 'message_type' ); ?>" id="<?php echo $this->get_field_id( 'message_type' ); ?>_1" value="1" <?php checked( '1', esc_attr( $message_type ) ) ?>/>
				<label for="<?php echo $this->get_field_id( 'message_type' ); ?>_1"><?php _e( 'Textarea', 'pe-terraclassic-plugin' ); ?></label>
			</p>            <p>
				<label for="<?php echo $this->get_field_id( 'textarea_height' ); ?>"><?php _e( 'Textarea height <small>(in px)</small>', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" type="text" name="<?php echo $this->get_field_name( 'textarea_height' ); ?>" id="<?php echo $this->get_field_id( 'textarea_height' ); ?>" value="<?php echo sanitize_text_field( $textarea_height ); ?>"/>
			<p>
				<label for="<?php echo $this->get_field_id( 'message_label' ); ?>"><?php _e( 'Message Label', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" type="text" name="<?php echo $this->get_field_name( 'message_label' ); ?>" id="<?php echo $this->get_field_id( 'message_label' ); ?>" value="<?php echo sanitize_text_field( $message_label ); ?>"/>
			</p>            <p>
				<label for="<?php echo $this->get_field_id( 'button_label' ); ?>"><?php _e( 'Button Label', 'pe-terraclassic-plugin' ); ?></label>
				<input class="widefat" type="text" name="<?php echo $this->get_field_name( 'button_label' ); ?>" id="<?php echo $this->get_field_id( 'button_label' ); ?>" value="<?php echo sanitize_text_field( $button_label ); ?>"/>
			</p>

			<?php
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title']             = strip_tags( $new_instance['title'] );
			$instance['number-columns']    = esc_attr( $new_instance['number-columns'] );
			$instance['show_consent1'] = isset( $new_instance['show_consent1'] ) ? 1 : 0;
			$instance['show_consent2'] = isset( $new_instance['show_consent2'] ) ? 1 : 0;
			$instance['show_captcha'] = isset( $new_instance['show_captcha'] ) ? 1 : 0;
			$instance['email_in_form']     = esc_attr( $new_instance['email_in_form'] );
			$instance['email_recipient']   = sanitize_email( $new_instance['email_recipient'] );
			$instance['senders_name']      = sanitize_text_field( $new_instance['senders_name'] );
			$instance['default_subject']   = sanitize_text_field( $new_instance['default_subject'] );
			$instance['email_with_thanks'] = esc_attr( $new_instance['email_with_thanks'] );
			$instance['thanks_subject']    = sanitize_text_field( $new_instance['thanks_subject'] );
			$instance['thanks_message']    = esc_textarea( $new_instance['thanks_message'] );
			$instance['intro_text']        = sanitize_text_field( $new_instance['intro_text'] );
			$instance['message_type']      = esc_attr( $new_instance['message_type'] );
			$instance['message_label']     = sanitize_text_field( $new_instance['message_label'] );
			$instance['textarea_height']   = intval( $new_instance['textarea_height'] );
			$instance['button_label']      = sanitize_text_field( $new_instance['button_label'] );

			return $instance;

		}

	}
}
?>
